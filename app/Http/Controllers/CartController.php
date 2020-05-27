<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateways;
use App\Repositories;
use App\Repositories\LocationRepository;
use App\Repositories\WishListRepository;
use Illuminate\Http\Request;
use App\Repositories\ModelRepository;
use App\Repositories\PartRepository;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use JsValidator;
use Illuminate\Support\Facades\Validator;

/** All Paypal Details class **/
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\InputFields;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\WebProfile;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * Class CartController
 * @package App\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * @var
     */
    private $_api_context;

    protected $modelRepo, $partRepo, $cartRepo, $wishListRepo, $locRepo;

    protected $addressValidationRules = [
        'country' => 'required|numeric|digits_between:1,4',
        'country_shipping' => 'required|numeric|digits_between:1,4',
        'name' => 'required|alpha_spaces|max:50',
        'name_shipping' => 'required|alpha_spaces|max:50',
        'company' => 'required|alpha_spaces|max:50',
        'company_shipping' => 'required|alpha_spaces|max:50',
        'mobile_number' => 'required|numeric|digits_between:7,12',
        'mobile_number_shipping' => 'required|numeric|digits_between:7,12',
        'address_1' => 'required|max:100',
        'address_shipping_1' => 'required|max:100',
        'address_2' => 'sometimes|max:100',
        'address_shipping_2' => 'sometimes|max:100',
        'city' => 'required',
        'city_shipping' => 'required',
        'state' => 'required|numeric|digits_between:1,4',
        'state_shipping' => 'required|numeric|digits_between:1,4',
        'zip' => 'required|max:20',
        'zip_shipping' => 'required|max:20',
        'email' => 'required|email',
        'email_shipping' => 'required|email',
        'comments_shipping' => 'sometimes|max:300'
    ];

    protected $customAddressRuleStrings = [
        'country.required' => 'Country required.',
        'country_shipping.required' => 'Country required.',
        'name.required' => 'Name required.',
        'name_shipping.required' => 'Name required.',
        'name.alpha_spaces' => 'Name may only contain letters and spaces.',
        'name_shipping.alpha_spaces' => 'Name may only contain letters and spaces.',
        'name.max' => 'Name may not be greater than :max.',
        'name_shipping.max' => 'Name may not be greater than :max.',
        'mobile_number.required' => 'Mobile Number required.',
        'mobile_number_shipping.required' => 'Mobile Number required.',
        'mobile_number.numeric' => 'Mobile Number must be a number.',
        'mobile_number_shipping.numeric' => 'Mobile Number must be a number.',
        'mobile_number.digits_between' => 'Mobile Number must be between :min and :max digits.',
        'mobile_number_shipping.digits_between' => 'Mobile Number must be between :min and :max digits.',
        'address_1.required' => 'Address Line 1 required.',
        'address_shipping_2.required' => 'Address Line 1 required.',
        'address_1_shipping.required' => 'Address Line 1 required.',
        'address_1.alpha_spaces' => 'Address Line 1 may only contain letters and spaces.',
        'address_shipping_1.alpha_spaces' => 'Address Line 1 may only contain letters and spaces.',
        'address_1.max' => 'Address Line 1 may not be greater than :max.',
        'address_shipping_1.max' => 'Address Line 1 may not be greater than :max.',
        'address_2.required' => 'Address Line 1 required.',
        'address_2.alpha_spaces' => 'Address Line 2 may only contain letters and spaces.',
        'address_shipping_2.alpha_spaces' => 'Address Line 2 may only contain letters and spaces.',
        'address_2.max' => 'Address Line 2 may not be greater than :max.',
        'address_2_shipping.max' => 'Address Line 2 may not be greater than :max.',
        'city.required' => 'City required.',
        'city_shipping.required' => 'City required.',
        'city.alpha_spaces' => 'City may only contain letters and spaces.',
        'city_shipping.alpha_spaces' => 'City may only contain letters and spaces.',
        'city.max' => 'City may not be greater than :max.',
        'city_shipping.max' => 'City may not be greater than :max.',
        'state.required' => 'State required.',
        'state_shipping.required' => 'State required.',
        'state.numeric' => 'State must be a number.',
        'state_shipping.numeric' => 'State must be a number.',
        'state.digits_between' => 'State must be between :min and :max digits.',
        'state_shipping.digits_between' => 'State must be between :min and :max digits.',
        'zip.required' => 'Zip/Postal code required.',
        'zip_shipping.required' => 'Zip/Postal code required.',
        'zip.max' => 'Zip/Postal code may not be greater than :max.',
        'zip_shipping.max' => 'Zip/Postal code may not be greater than :max.',
    ];

    /**
     * Create a new controller instance.
     *
     * @param ModelRepository $modelRepo
     * @param PartRepository $partRepo
     * @param CartRepository $cartRepo
     * @param WishListRepository $wishListRepo
     * @param LocationRepository $locRepo
     */
    public function __construct(ModelRepository $modelRepo, PartRepository $partRepo, CartRepository $cartRepo, WishListRepository $wishListRepo, LocationRepository $locRepo)
    {
        $this->modelRepo = $modelRepo;
        $this->partRepo = $partRepo;
        $this->cartRepo = $cartRepo;
        $this->wishListRepo = $wishListRepo;
        $this->locRepo = $locRepo;
        View::share('countries', $locRepo->getCountries());
        /**
         * Setup the PayPal
         */
        $paypal_gateway_rec = PaymentGateways::where('name', '=', 'Paypal')->where('status', '=', '1')->first(['settings']);
        if(isset($paypal_gateway_rec->settings)) {
            $paypal_settings = unserialize($paypal_gateway_rec->settings);
        } else {
            $paypal_settings = [];
        }
        $paypal_log_filename = isset($paypal_settings['log_filename']) ? $paypal_settings['log_filename'] : "";
        $paypal_conf = [
            'client_id' => isset($paypal_settings['client_id']) ? $paypal_settings['client_id'] : "",
            'secret'    => isset($paypal_settings['secret_key']) ? $paypal_settings['secret_key'] : "",
            'settings'  => [
                'mode' => isset($paypal_settings['mode']) ? $paypal_settings['mode'] : "",
                'http.ConnectionTimeOut' => isset($paypal_settings['connection_timeout']) ? $paypal_settings['connection_timeout'] : "",
                'log.LogEnabled' => isset($paypal_settings['log_enabled']) ? $paypal_settings['log_enabled'] : "",
                'log.FileName' => storage_path() . '/logs/'. $paypal_log_filename,
                'log.LogLevel' => isset($paypal_settings['log_level']) ? $paypal_settings['log_level'] : ""
            ]
        ];
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function showMonerisDeclined(Request $request)
    {
        if ($request->has('result') && $request->input('result') == -1 && (strpos($request->input('message'), 'cancelled') !== false)) {
            $order_id = $request->input('rvarorder_id');
            $transaction['order_id'] = $order_id;
            $transaction['payment_method'] = 'Moneris';
            $transaction['order_status'] = 'Cancelled by Card Holder';
            $transaction['order_pending'] = 1;
            $transaction_information = '';
            foreach ($request->input() as $receivedKey => $receivedValue) {
                $transaction_information .= $receivedKey . '=' . $receivedValue.'<br>';
            }
            $transaction['transaction_information'] = $transaction_information;
            $transaction['id'] = @$request->input('response_order_id');
            $transaction['amount'] = @$request->input('charge_total');
            // empty cart.
            $this->cartRepo->emptyCart();
            return view('front.pages.payment.cancel', [
                'order_id' => $order_id
            ]);
        }
    }

    public function showMonerisResult(Request $request)
    {
        // update the order record
        if ($request->has('result') && $request->input('result') == 1 && (strpos($request->input('message'), 'APPROVED') !== false)) {
            $order_id = $request->input('rvarorder_id');
            $transaction['order_id'] = $order_id;
            $transaction['payment_method'] = 'Moneris';
            $transaction['order_status'] = 'Paid';
            $transaction['order_pending'] = 1;
            $transaction_information = '';
            foreach ($request->input() as $receivedKey => $receivedValue) {
                $transaction_information .= $receivedKey . '=' . $receivedValue.'<br>';
            }
            $transaction['transaction_information'] = $transaction_information;
            $transaction['id'] = @$request->input('response_order_id');
            $transaction['amount'] = @$request->input('charge_total');

            if($this->cartRepo->saveOrderDetails($transaction)) {
                return Redirect::to('/payment-success?a='.$transaction['amount'].'&c=$&order_id='.$transaction['order_id'])->with('success', 'Payment success');
            } else {
                return Redirect::to('/payment-error?order_id='.$transaction['order_id'])->withErrors('Payment failed, contact site administrator.');
            }
        }
        return Redirect::to('/payment-error')->withErrors('Payment failed, contact site administrator.');
    }

    // Show payment success page only
    public function showPaymentSuccess(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('user') == false) {
            abort(403, 'Unauthorized action.');
        }
        $amount = $request->has('a') ? $request->input('a') : '';
        $currency = $request->has('c') ? $request->input('c') : '$';
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        return view('front.pages.payment.success', [
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $order_id
        ]);
    }

    // Show payment paypal cancel page
    public function showPaymentPaypalCancel(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('user') == false) {
            abort(403, 'Unauthorized action.');
        }
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        return view('front.pages.payment.cancel', [
            'order_id' => $order_id
        ]);
    }

    // Show payment paypal error page
    public function showPaymentError(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('user') == false) {
            abort(403, 'Unauthorized action.');
        }
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        if($order_id != '') {
            $this->cartRepo->paymentFailed($order_id);
        }
        return view('front.pages.payment.error', [
            'order_id' => $order_id
        ]);
    }

    public function showPayPalResult(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('user') == false) {
            abort(403, 'Unauthorized action.');
        }
        /** Get the payment ID before session clear **/
        $payment_id = session()->get('paypal_payment_id');
        /** clear the session payment ID **/
        session()->forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return Redirect::to('/payment-error')->withErrors('Payment failed');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $order_id = explode("::", $result->getTransactions()[0]->getDescription());
            $transaction['order_id'] = $order_id[1];
            $transaction['payment_method'] = 'Paypal';
            $transaction['order_status'] = 'Paid';
            $transaction['order_pending'] = 1;
            $transaction['transaction_information'] = 'PayPal '.strtoupper(@$result->getTransactions()[0]->getRelatedResources()[0]->getSale()->getState()).'<br>Transaction ID='.@$result->getId().'<br>Transaction Type: _express-checkout';
//            $transaction['txnTime'] = @$result->getTransactions()[0]->getRelatedResources()[0]->getSale()->getState();
            /**
             * Set transaction array
             */
            $transaction['id'] = @$result->getId();
            $transaction['amount'] = @$result->getTransactions()[0]->getAmount()->getTotal();
//            $transaction['currencyCode'] = @$result->getTransactions()[0]->getAmount()->getCurrency();
//            $transaction['customer_code'] = @$result->getTransactions()[0]->getRelatedResources()[0]->getSale()->getId();

//             \Log::info(print_r($result->getId(),1));
//             \Log::info(print_r($result->getPayer()->getPayerInfo(),1));
//             \Log::info(print_r($result->getTransactions(),1));
//             \Log::info(print_r($result->getTransactions()[0]->getAmount(),1));
//             \Log::info(print_r($result->getTransactions()[0]->getItemList()->getItems()[0],1));
//             \Log::info(print_r($result->getTransactions()[0]->getItemList()->getShippingAddress(),1));
            if($this->cartRepo->saveOrderDetails($transaction)) {
                return Redirect::to('/payment-success?a='.$transaction['amount'].'&c=$&order_id='.$transaction['order_id'])->with('success', 'Payment success');
            } else {
                return Redirect::to('/payment-error?order_id='.$transaction['order_id'])->withErrors('Payment failed, contact site administrator.');
            }
        }
        return Redirect::to('/payment-error')->withErrors('Payment failed, contact site administrator.');
    }

    public function payWithPayPal(Request $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') :  '';
        $user = Auth::user();
        $orderDetails = $this->cartRepo->getOrderDetails($order_id);
        if($user->hasRole('user') == false || $orderDetails == null) {
            abort(403, 'Unauthorized action.');
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        // get item from cart
        if($user->country_id == '32') {
            $currency = "CAD";
        } else {
            $currency = "USD";
        }

        $item  = array();
        $items = array();
        $index = 0;
        foreach ($this->cartRepo->showItems() as $_item) {
            $index++;
            $item[$index] = new Item();
            $item[$index]->setName($_item['name'])
                ->setCurrency($currency)
                ->setQuantity($_item['quantity'])
                ->setPrice($_item['price']);
            $items[] = $item[$index];
        }

//        $shipping_address = new ShippingAddress();
//        $shipping_address->setCity($orderDetails->city->name);
//        $shipping_address->setCountryCode($orderDetails->country->code);
//        $shipping_address->setPostalCode($orderDetails->zip);
//        $shipping_address->setLine1($orderDetails->shipping_address_1);
//        $shipping_address->setState($orderDetails->state->name);
//        $shipping_address->setRecipientName($orderDetails->shipping_name);

        $itemList = new ItemList();
        $itemList->setItems($items);
        // set shipping address
//        $itemList->setShippingAddress($shipping_address);

        $details = new Details();
        $details->setShipping($orderDetails->shipping_amount)
            ->setTax($orderDetails->tax)
            ->setSubtotal($orderDetails->product_total_amount);

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($orderDetails->amount)
            ->setDetails($details);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('grillpartszone.com Items for Order ID::'.$order_id);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('payment-status-paypal-success')) /** Specify return URL **/
        ->setCancelUrl(route('show-cart', ['order_id' => $order_id]));

//        $inputfields = new InputFields();
//        $inputfields->setAllowNote(true)
//            ->getNoShipping(1)
//            ->setAddressOverride(0);
//
//        $webProfile = new WebProfile();
//        $webProfile->setName('Grill Parts Zone ' . uniqid())
//            ->setInputFields($inputfields)
//            ->setTemporary(true);
//
//        $webProfileId = $webProfile->create($this->_api_context)->getId();

        $payment = new Payment();
//        $payment->setExperienceProfileId($webProfileId);
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                return Redirect::to('/payment-error')->withErrors('Connection timeout');
            } else {
                return Redirect::to('/payment-error')->withErrors('Some error occur, sorry for inconvenient');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        session()->put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return Redirect::to('/payment-error')->withErrors('Unknown error occurred');
    }

    public function showCheckout(Request $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') :  (session()->has('recent_order_id') ? session()->get('recent_order_id') : '');
        // forgot recent order
        if(session()->has('recent_order_id')) {
            session()->forget('recent_order_id');
        }
        if($order_id == '') {
            return redirect()->route('show-cart')->withError('Your cart is empty.');
        }
        $orderDetails = $this->cartRepo->getOrderDetails($order_id);
        if($orderDetails->transaction_information != '' && $orderDetails->order_method != '' && $orderDetails->order_status != '') {
            return redirect()->route('show-cart')->withError('Your order is invalid for checkout.');
        }
        $user = Auth::user();

        // moneris
        $moneris_gateway_rec = PaymentGateways::where('name', '=', 'Moneris')->where('status', '=', '1')->first(['settings']);
        if(isset($moneris_gateway_rec->settings)) {
            $moneris_settings = unserialize($moneris_gateway_rec->settings);
        } else {
            $moneris_settings = [];
        }

        return view('front.pages.checkout', [
            'items' => $this->cartRepo->showItems(),
            'order' => $orderDetails,
            'user' => $user,
            'moneris_settings' => $moneris_settings
        ]);
    }

    public function updateAddressPrice(Request $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        $shipping_state = $request->has('shipping_state') ? $request->input('shipping_state') : '';
        $shipping_radio = $request->has('shipping_radio') ? $request->input('shipping_radio') : '';
        $shippingPriceArray = $this->cartRepo->getShipPrice($shipping_state, $shipping_radio);
        $state = $request->has('state') ? ( ($request->input('state') != null && $request->input('state') != '') ? $request->input('state') : 0 ) : 0;
        $tax_percentage = $this->cartRepo->getTaxPrice($state);
        $total_item_cost = $this->cartRepo->getTotalPrice();

        if($tax_percentage > 0) {
            $total_tax = getAppropriatePrice(($total_item_cost['total_cart_price'] * $tax_percentage) / 100);
        } else {
            $total_tax = 0.00;
        }
        return view('front.pages.includes.cart-price-block', [
            'total_items_cost' => $total_item_cost,
            'total_shipping_cost' => $shippingPriceArray['shipping_price'],
            'show_radio' => $shippingPriceArray['show_radio'],
            'total_tax' => $total_tax,
            'defaultShipping' => $shippingPriceArray['show_selected_radio'],
            'shipping' => $this->cartRepo->getCartShippingOptions(),
            'order_id' => $order_id
        ]);
    }

    public function submitAddress(Request $request)
    {
        $validator = Validator::make($request->all(), $this->addressValidationRules, $this->customAddressRuleStrings);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if(!Auth::check()) {
            // save the details in session first. if not logged in
            $this->cartRepo->saveCheckOutDetailsSession($request);
            // redirect user to login page with return url. of order details page.
            return redirect()->route('login', ['redirect' => route('show-checkout')]);
        } else {
            // check user role as 'user' and save detail and forward user to check out page for payment.
            return redirect()->route('show-checkout', ['order_id' => $this->cartRepo->saveCheckoutDetailUser($request)]);
        }
    }

    public function copyBillingToShipping(Request $request)
    {
        $name = $request->has('name') ? $request->input('name') : '';
        $company = $request->has('company') ? $request->input('company') : '';
        $address_1 = $request->has('address_1') ? $request->input('address_1') : '';
        $address_2 = $request->has('address_2') ? $request->input('address_2') : '';
        $country = $request->has('country') ? $request->input('country') : '';
        $state = $request->has('state') ? $request->input('state') : '';
        $city = $request->has('city') ? $request->input('city') : '';
        $zip = $request->has('zip') ? $request->input('zip') : '';
        $mobile_number = $request->has('mobile_number') ? $request->input('mobile_number') : '';
        $email = $request->has('email') ? $request->input('email') : '';

        // get shipping details
        $defaultShippingDetails = [
            'name' => $name,
            'company' => $company,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'country_id' => $country,
            'state_id' => $state,
            'city_id' => $city,
            'zip' => $zip,
            'mobile_number' => $mobile_number,
            'email' => $email
        ];
        // get state and cities shipping
        if(isset($defaultShippingDetails['country_id']) && $defaultShippingDetails['country_id'] != '') {
            $statesShippingPopulate = $this->locRepo->getStates($defaultShippingDetails['country_id']);
        } else {
            $statesShippingPopulate = null;
        }
        if(isset($defaultShippingDetails['state_id']) && $defaultShippingDetails['state_id'] != '') {
            $citiesShippingPopulate = $this->locRepo->getCities($defaultShippingDetails['state_id']);
        } else {
            $citiesShippingPopulate = null;
        }

        return view('front.pages.includes.shipping-address', [
            'shippingDetails' => $defaultShippingDetails,
            'statesShippingPopulate' => $statesShippingPopulate,
            'citiesShippingPopulate' => $citiesShippingPopulate,
        ]);
    }

    public function addDeliveryAddress(Request $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') :  (session()->has('recent_order_id') ? session()->get('recent_order_id') : '');

        $validator = JsValidator::make($this->addressValidationRules, $this->customAddressRuleStrings);

        if (count($this->cartRepo->getAllCartItems()) == 0) {
            return redirect()->route('show-cart')->withError('Your cart is empty.');
        }

        $defaultBillingDetails = $this->cartRepo->getDefaultBillingDetails();

        // get state and cities billing
        if(isset($defaultBillingDetails['country_id']) && $defaultBillingDetails['country_id'] != '') {
            $statesPopulate = $this->locRepo->getStates($defaultBillingDetails['country_id']);
        } else {
            $statesPopulate = null;
        }
        if(isset($defaultBillingDetails['state_id']) && $defaultBillingDetails['state_id'] != '') {
            $citiesPopulate = $this->locRepo->getCities($defaultBillingDetails['state_id']);
        } else {
            $citiesPopulate = null;
        }

        // get shipping details
        $defaultShippingDetails = $this->cartRepo->getDefaultShippingDetails($order_id);
        // get state and cities shipping
        if(isset($defaultShippingDetails['country_id']) && $defaultShippingDetails['country_id'] != '') {
            $statesShippingPopulate = $this->locRepo->getStates($defaultShippingDetails['country_id']);
        } else {
            $statesShippingPopulate = null;
        }
        if(isset($defaultShippingDetails['state_id']) && $defaultShippingDetails['state_id'] != '') {
            $citiesShippingPopulate = $this->locRepo->getCities($defaultShippingDetails['state_id']);
        } else {
            $citiesShippingPopulate = null;
        }

        $shipping_radio = $this->cartRepo->getCartShippingPriceBy('shipping_type', 'Free')->id;
        if(isset($defaultShippingDetails['state_id']) && $defaultShippingDetails['state_id'] != '') {
            $stateObj = $this->locRepo->getStateBy($defaultShippingDetails['state_id']);
            $shippingPriceArray = $this->cartRepo->getShipPrice($stateObj->name, $shipping_radio);
        } else {
            $shippingPriceArray = $this->cartRepo->getShipPrice('', $shipping_radio);
        }

        $totalCartCost = $this->cartRepo->getTotalPrice();
        $totalTax = 0.00;
        if(isset($defaultBillingDetails['state_id']) && $defaultBillingDetails['state_id'] != '') {
            $taxPercentage = $this->cartRepo->getTaxPrice($defaultBillingDetails['state_id']);
            if($taxPercentage > 0) {
                $totalTax = getAppropriatePrice(($totalCartCost['total_cart_price'] * $taxPercentage) / 100);
            }
        }

        return view('front.pages.add-delivery-address', [
            'total_items_cost' => $totalCartCost,
            'total_shipping_cost' => $shippingPriceArray['shipping_price'],
            'show_radio' => $shippingPriceArray['show_radio'],
            'total_tax' => $totalTax,
            'shipping' => $this->cartRepo->getCartShippingOptions(),
            'taxes' => $this->cartRepo->getAllTaxes(),
            'defaultShipping' => $shipping_radio,
            'billingDetails' => $defaultBillingDetails,
            'shippingDetails' => $defaultShippingDetails,
            'statesPopulate' => $statesPopulate,
            'statesShippingPopulate' => $statesShippingPopulate,
            'citiesPopulate' => $citiesPopulate,
            'citiesShippingPopulate' => $citiesShippingPopulate,
            'order_id' => $order_id,
            'validator' => $validator
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $token = $request->has('token') ? $request->input('token') : '';
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        if($token != '' && $order_id != '') {
            $this->cartRepo->removeOrderUponCancel($order_id);
            $order_id = '';
        }

        return view('front.pages.cart', [
            'items' => $this->cartRepo->showItems(),
            'wish_list' => $this->wishListRepo->showItems(),
            'order_id' => $order_id
            //'viewedParts' => $this->partRepo->showViewedParts()
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        $part_id = $request->has('part_id') ? (int)$request->input('part_id') : 0;
        $brand_id = $request->has('brand_id') ? (int)$request->input('brand_id') : 0;
        $quantity = $request->has('quantity') ? (int)$request->input('quantity') : 1;
        $action = $request->has('action') ? $request->input('action') : '';
        $part = $this->partRepo->getPartBy('id', $part_id);
        if ($part != null && $quantity != null && $brand_id != 0) {
            $return = $this->cartRepo->addItem($part_id, $quantity, $brand_id, $action);
            return response()->json(['message' => 'Part added in cart.', 'return' => $return]);
        } else {
            return response()->json(['error' => 'Some issue while adding item in cart.']);
        }
    }

    public function remove(Request $request)
    {
        $part_id = $request->has('part_id') ? (int)$request->input('part_id') : 0;
        if ($part_id != null && $part_id != 0) {
            $return = $this->cartRepo->removeItem($part_id);
            return response()->json(['message' => 'Part removed.', 'return' => $return]);
        } else {
            return response()->json(['error' => 'Some issue while removing item from cart.']);
        }
    }
}
