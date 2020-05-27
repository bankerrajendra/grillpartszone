<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPartDetail;
use App\Models\Part;
use App\Models\Shipping;
use App\Models\State;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use App\Models\PaymentGateways;

/**
 * Class CartRepository
 * @package App\Repositories
 */
class CartRepository
{
    /**
     * CartRepository constructor.
     */
    public function __construct()
    {

    }

    public function getOrderDetails(int $order_id)
    {
        return $order_details = Order::find($order_id);
    }

    public function removeOrderUponCancel(int $order_id)
    {
        OrderPartDetail::where('user_id', Auth::id())->where('order_id', $order_id)->delete();
        Order::where('user_id', Auth::id())->where('order_id', $order_id)->delete();
    }

    public function paymentFailed(int $order_id)
    {
        $orderObj = Order::where('order_id', $order_id)->where('user_id', Auth::id())->first();
        if($orderObj != null) {
            $orderObj->transaction_error = 'Payment failed, contact site administrator.';
            $orderObj->save();
        }
    }

    public function saveOrderDetails(array $transaction)
    {
        $orderObj = Order::where('order_id', $transaction['order_id'])->where('user_id', Auth::id())->first();
        if($orderObj != null) {
            // update order details
            $orderObj->order_method = $transaction['payment_method'];
            // save payment method
            $payMethodId = PaymentGateways::where('name', $transaction['payment_method'])->first(['id']);
            if($payMethodId != null) {
                $orderObj->payment_method = $payMethodId->id;
            }
            $orderObj->transaction_information = $transaction['transaction_information'];
            $orderObj->order_status = $transaction['order_status'];
            $orderObj->order_pending = $transaction['order_pending'];
            $orderObj->ip_address = request()->ip();
            if($orderObj->save()) {
                // empty out shopping cart
                Cart::where('user_id', Auth::id())->delete();
                return true;
            }
        }
        return false;
    }

    public function saveCheckoutDetailUser(object $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        $user = Auth::user();
        // save billing details in user table
        $user->where('id', $user->id)->update([
            'name' => $request->input('name'),
            'company' => $request->input('company'),
            'mobile_number' => $request->input('mobile_number'),
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'zip' => $request->input('zip'),
            'city_id' => $request->input('city'),
            'state_id' => $request->input('state'),
            'country_id' => $request->input('country')
        ]);
        // get cart and details and calculate price tax ship etc
        // Items Cost Array
        $total_item_cost_array = $this->getTotalPrice();
        // Shipping Cost
        $selected_radio = '';
        if($request->has('shipping_options') && $request->input('shipping_options') != '') {
            $selected_radio = $this->getCartShippingPriceBy('id', $request->input('shipping_options'))->id;
        } else {
            $selected_radio = $this->getCartShippingPriceBy('shipping_type', 'Free')->id;
        }
        // get state name
        $stateObj = State::find($request->input('state_shipping'));
        $shippingPriceArray = $this->getShipPrice($stateObj->name, $selected_radio);
        // Tax
        $tax_percentage = $this->getTaxPrice($request->input('state'));
        if($tax_percentage > 0) {
            $total_tax = ($total_item_cost_array['total_cart_price'] * $tax_percentage) / 100;
        } else {
            $total_tax = 0;
        }
        // Final Product Amount
        $final_total = $total_item_cost_array['total_cart_price'] + $shippingPriceArray['shipping_price'] + $total_tax;

        // get currency based on selected billing country
        $billCountryInfo = Country::find($request->input('country'));
        $currency = '';
        if($billCountryInfo->code == 'CA') {
            $currency = 'CAD';
        } elseif ($billCountryInfo->code == 'US') {
            $currency = 'USD';
        }
        // save order details
        if($order_id != '') {
            Order::where('order_id', $order_id)->update(
                [
                    'user_id' => $user->id,
                    'order_date' => Carbon::now()->toDateTimeString(),
                    'amount' => $final_total,
                    'tax' => $total_tax,
                    'shipping_amount' => $shippingPriceArray['shipping_price'],
                    'shipping_email' => $request->input('email_shipping'),
                    'shipping_company' => $request->input('company_shipping'),
                    'shipping_name' => $request->input('name_shipping'),
                    'shipping_address_1' => $request->input('address_shipping_1'),
                    'shipping_address_2' => $request->input('address_shipping_2'),
                    'shipping_mobile_number' => $request->input('mobile_number_shipping'),
                    'shipping_country_id' => $request->input('country_shipping'),
                    'shipping_state_id' => $request->input('state_shipping'),
                    'shipping_city_id' => $request->input('city_shipping'),
                    'shipping_zip' => $request->input('zip_shipping'),
                    'shipping_comment' => $request->input('comments_shipping'),
                    'shipping_id' => $shippingPriceArray['show_selected_radio'],
                    'store_name' => config('constants.STORE_NAME'),
                    'ip_address' => request()->ip(),
                    'product_total_amount' => $total_item_cost_array['total_cart_price'], // minus tax, ship etc.
                    'currency' => $currency // CAD or USD
                ]
            );
            // save the order part details
            $this->saveOrderPartDetails($order_id);
            return $order_id;
        } else {
            $orderObj = Order::create(
                [
                    'user_id' => $user->id,
                    'order_date' => Carbon::now()->toDateTimeString(),
                    'amount' => $final_total,
                    'tax' => $total_tax,
                    'shipping_amount' => $shippingPriceArray['shipping_price'],
                    'shipping_email' => $request->input('email_shipping'),
                    'shipping_company' => $request->input('company_shipping'),
                    'shipping_name' => $request->input('name_shipping'),
                    'shipping_address_1' => $request->input('address_shipping_1'),
                    'shipping_address_2' => $request->input('address_shipping_2'),
                    'shipping_mobile_number' => $request->input('mobile_number_shipping'),
                    'shipping_country_id' => $request->input('country_shipping'),
                    'shipping_state_id' => $request->input('state_shipping'),
                    'shipping_city_id' => $request->input('city_shipping'),
                    'shipping_zip' => $request->input('zip_shipping'),
                    'shipping_comment' => $request->input('comments_shipping'),
                    'shipping_id' => $shippingPriceArray['show_selected_radio'],
                    'store_name' => config('constants.STORE_NAME'),
                    'ip_address' => request()->ip(),
                    'product_total_amount' => $total_item_cost_array['total_cart_price'], // minus tax, ship etc.
                    'currency' => $currency // CAD or USD
                ]
            );
            // save order part details
            $this->saveOrderPartDetails($orderObj->order_id);
            return $orderObj->order_id;
        }
    }

    public function saveOrderPartDetails(int $order_id)
    {
        if(!empty($this->getAllCartItems())) {
            foreach ($this->getAllCartItems() as $partId => $cartItem) {
                OrderPartDetail::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'order_id' => $order_id,
                        'part_id' => $partId
                    ],
                    [
                        'user_id' => Auth::id(),
                        'order_id' => $order_id,
                        'part_id' => $partId,
                        'brand_id' => $cartItem['brand_id'],
                        'quantity' => $cartItem['quantity'],
                        'part_price' => $this->getPartPrice($partId)->price
                    ]
                );
            }
        }
    }

    public function getPartPrice(int $partId)
    {
        return Part::where('id', $partId)->first(['price']);
    }

    public function saveCheckOutDetailsLoggedUser(object $user)
    {
        if (session()->has('checkout_session_storage')) {
            $checkout_session_storage = session()->get('checkout_session_storage');
            if (!empty($checkout_session_storage)) {
                // save billing details in user table
                $user->where('id', $user->id)->update([
                    'name' => $checkout_session_storage['name_billing'],
                    'company' => $checkout_session_storage['company_billing'],
                    'mobile_number' => $checkout_session_storage['mobile_number_billing'],
                    'address_1' => $checkout_session_storage['address_1_billing'],
                    'address_2' => $checkout_session_storage['address_2_billing'],
                    'zip' => $checkout_session_storage['zip_billing'],
                    'city_id' => $checkout_session_storage['city_billing'],
                    'state_id' => $checkout_session_storage['state_billing'],
                    'country_id' => $checkout_session_storage['country_billing']
                ]);
                // get cart and details and calculate price tax ship etc
                // Items Cost Array
                $total_item_cost_array = $this->getTotalPrice();
                // Shipping Cost
                if(isset($checkout_session_storage['shipping_radio']) && $checkout_session_storage['shipping_radio'] != '') {
                    $selected_radio = $this->getCartShippingPriceBy('id', $checkout_session_storage['shipping_radio'])->id;
                } else {
                    $selected_radio = $this->getCartShippingPriceBy('shipping_type', 'Free')->id;
                }
                $shippingPriceArray = $this->getShipPrice($checkout_session_storage['state_shipping'], $selected_radio);
                // Tax
                $tax_percentage = $this->getTaxPrice($checkout_session_storage['state_billing']);
                if($tax_percentage > 0) {
                    $total_tax = ($total_item_cost_array['total_cart_price'] * $tax_percentage) / 100;
                } else {
                    $total_tax = 0;
                }
                // Final Product Amount
                $final_total = $total_item_cost_array['total_cart_price'] + $shippingPriceArray['shipping_price'] + $total_tax;

                // get currency based on selected billing country
                $billCountryInfo = Country::find($checkout_session_storage['country_shipping']);
                $currency = '';
                if($billCountryInfo->code == 'CA') {
                    $currency = 'CAD';
                } elseif ($billCountryInfo->code == 'US') {
                    $currency = 'USD';
                }
                // save order details
                $orderObj = Order::create(
                    [
                        'user_id' => $user->id,
                        'order_date' => Carbon::now()->toDateTimeString(),
                        'amount' => $final_total,
                        'tax' => $total_tax,
                        'shipping_amount' => $shippingPriceArray['shipping_price'],
                        'shipping_email' => $checkout_session_storage['email_shipping'],
                        'shipping_company' => $checkout_session_storage['company_shipping'],
                        'shipping_name' => $checkout_session_storage['name_shipping'],
                        'shipping_address_1' => $checkout_session_storage['address_shipping_1'],
                        'shipping_address_2' => $checkout_session_storage['address_shipping_2'],
                        'shipping_mobile_number' => $checkout_session_storage['mobile_number_shipping'],
                        'shipping_country_id' => $checkout_session_storage['country_shipping'],
                        'shipping_state_id' => $checkout_session_storage['state_shipping'],
                        'shipping_city_id' => $checkout_session_storage['city_shipping'],
                        'shipping_zip' => $checkout_session_storage['zip_shipping'],
                        'shipping_comment' => $checkout_session_storage['comments_shipping'],
                        'shipping_id' => $shippingPriceArray['show_selected_radio'],
                        'store_name' => config('constants.STORE_NAME'),
                        'ip_address' => request()->ip(),
                        'product_total_amount' => $total_item_cost_array['total_cart_price'], // minus tax, ship etc.
                        'currency' => $currency // CAD or USD
                    ]
                );
                // save order id in session
                session()->put('recent_order_id', $orderObj->order_id);
            }
            session()->forget('checkout_session_storage');
        }
    }

    public function saveCheckOutDetailsSession(object $request)
    {
        $checkout_session_storage = [];
        $checkout_session_storage['name_billing'] = $request->input('name');
        $checkout_session_storage['company_billing'] = $request->input('company');
        $checkout_session_storage['address_1_billing'] = $request->input('address_1');
        $checkout_session_storage['address_2_billing'] = $request->input('address_2');
        $checkout_session_storage['country_billing'] = $request->input('country');
        $checkout_session_storage['state_billing'] = $request->input('state');
        $checkout_session_storage['city_billing'] = $request->input('city');
        $checkout_session_storage['zip_billing'] = $request->input('zip');
        $checkout_session_storage['mobile_number_billing'] = $request->input('mobile_number');
        $checkout_session_storage['email_billing'] = $request->input('email');
        $checkout_session_storage['name_shipping'] = $request->input('name_shipping');
        $checkout_session_storage['company_shipping'] = $request->input('company_shipping');
        $checkout_session_storage['address_shipping_1'] = $request->input('address_shipping_1');
        $checkout_session_storage['address_shipping_2'] = $request->input('address_shipping_2');
        $checkout_session_storage['country_shipping'] = $request->input('country_shipping');
        $checkout_session_storage['state_shipping'] = $request->input('state_shipping');
        $checkout_session_storage['city_shipping'] = $request->input('city_shipping');
        $checkout_session_storage['zip_shipping'] = $request->input('zip_shipping');
        $checkout_session_storage['mobile_number_shipping'] = $request->input('mobile_number_shipping');
        $checkout_session_storage['email_shipping'] = $request->input('email_shipping');
        $checkout_session_storage['comments_shipping'] = $request->input('comments_shipping');
        $checkout_session_storage['shipping_radio'] = $request->has('shipping_options') ? $request->input('shipping_options') : '';

        session()->put('checkout_session_storage', $checkout_session_storage);

    }

    public function getShipPrice(string $shipping_state, $shipping_radio)
    {
        $shipping_price = 0.00;
        $show_shipping_radio = true;
        $selected_radio = $this->getCartShippingPriceBy('shipping_type', 'Free')->id;
        if($shipping_state != '' && Shipping::where('shipping_type', $shipping_state)->exists()) {
            $shippingObj = Shipping::where('shipping_type', $shipping_state)->first();
            if($shippingObj != null) {
                $shipping_price = $shippingObj->price;
                $show_shipping_radio = false;
            }
        } else {
            $show_shipping_radio = true;
            if($shipping_radio == '') {
                $shipping_radio = $selected_radio;
            }
            $shippingObj = $this->getCartShippingPriceBy('id', $shipping_radio);
            if($shippingObj->shipping_type == 'Expedited') {
                $shipping_price = $shippingObj->price;
                $selected_radio = $shippingObj->id;
            } else if($shippingObj->shipping_type == 'Free') {
                $selected_radio = $shippingObj->id;
                $total_cart_price = $this->getTotalPrice();
                if($total_cart_price['total_cart_price'] <= config('constants.SHIPPING_THRESHOLD_PRICE')) {
                    $shipping_price = Shipping::where('shipping_type', 'MinOrder')->first(['price'])->price;
                } else {
                    // free price
                    $shipping_price = $shippingObj->price;
                }
            }
        }

        return [
            'shipping_price' => getAppropriatePrice($shipping_price),
            'show_radio' => $show_shipping_radio,
            'show_selected_radio' => $selected_radio
        ];
    }

    public function getTaxPrice(int $state)
    {
        $tax_percentage = 0;
        if($state != 0) {
            $taxObj = Tax::where('state_id', $state)->first();
            if($taxObj != null) {
                $tax_percentage = $taxObj->vat_percentage;
            }
        }
        return $tax_percentage;
    }

    public function getCartShippingPriceBy($type = 'id', $value)
    {
        return Shipping::where($type, $value)->first();
    }

    public function getCartShippingOptions()
    {
        return Shipping::whereIn('shipping_type', ['Free', 'Expedited'])->get();
    }

    public function getCartShippingForMinOrder()
    {
        $total_cart_price = $this->getTotalPrice();
        if($total_cart_price <= config('constants.SHIPPING_THRESHOLD_PRICE')) {
            $minOrder = Shipping::where('shipping_type', 'MinOrder')->first(['price']);
            return $minOrder->price;
        } else {
            //
            return 0;
        }
    }

    public function getAllShipping()
    {
        return Shipping::all();
    }

    public function getAllTaxes()
    {
        return Tax::all();
    }

    public function saveLoggedUser(object $user)
    {
        if (session()->has('cart_items')) {
            $cartItemsSess = session()->get('cart_items');
            if (!empty($cartItemsSess)) {
                $cartItemsUs = $user->cart;
                if ($cartItemsUs != null && $cartItemsUs != '') {
                    $cartItems = unserialize($cartItemsUs->details);
                    foreach ($cartItemsSess as $key => $item) {
                        $cartItems[$key]['brand_id'] = $cartItemsSess[$key]['brand_id'];
                        $cartItems[$key]['quantity'] = $cartItemsSess[$key]['quantity'];
                        $cartItems[$key]['time'] = $cartItemsSess[$key]['time'];
                    }
                    Cart::where('user_id', $user->id)->update([
                        'details' => serialize($cartItems)
                    ]);
                } else {
                    try {
                        Cart::create([
                            'user_id' => $user->id,
                            'details' => serialize($cartItemsSess)
                        ]);
                    } catch (\Exception $e) {
                        // some error
                    }
                }
            }
            session()->forget('cart_items');
        }
    }

    public function showItems()
    {
        $cart_items = $this->getAllCartItems();
        $cartItemsArray = [];
        $i = 0;
        if (count($cart_items) > 0) {
            foreach ($cart_items as $partKey => $partVal) {
                $brandObj = Brand::find($partVal['brand_id']);
                $partObj = Part::find($partKey);
                $cartItemsArray[$i]['id'] = $partObj->id;
                $cartItemsArray[$i]['quantity'] = $partVal['quantity'];
                $cartItemsArray[$i]['image'] = $partObj->getSingleImg();
                $cartItemsArray[$i]['link'] = route('part', ['brandSlug' => $brandObj->slug, 'slug' => $partObj->slug]);
                $cartItemsArray[$i]['name'] = $partObj->name;
                $cartItemsArray[$i]['short_description'] = showReadMore($partObj->short_description, 60, '', false);
                $cartItemsArray[$i]['price'] = $partObj->price;
                $cartItemsArray[$i]['retail_price'] = $partObj->retail_price;
                $cartItemsArray[$i]['brand_id'] = $partVal['brand_id'];
                $cartItemsArray[$i]['stock'] = $partObj->stock;
                $i++;
            }
        }
        return $cartItemsArray;
    }

    public function addItem(int $part_id, int $quantity, int $brand_id, string $action = '')
    {
        $cart_items = $this->getAllCartItems();
        $cart_items[$part_id]['brand_id'] = $brand_id;
        if ($action == 'add' && array_key_exists('quantity', $cart_items[$part_id])) {
            $quantity = $cart_items[$part_id]['quantity'] + 1;
        }
        $cart_items[$part_id]['quantity'] = $quantity;
        $cart_items[$part_id]['time'] = time();
        $this->saveItems($cart_items);
        return $this->getTotalPrice($part_id);
    }

    public function removeItem(int $part_id)
    {
        $cart_items = $this->getAllCartItems();
        unset($cart_items[$part_id]);
        $this->saveItems($cart_items);
        return $this->getTotalPrice($part_id);
    }

    protected function saveItems(array $cart_items)
    {
        if(count($cart_items) > 0) {
            if(Auth::check()) {
                Cart::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['details' => serialize($cart_items), 'user_id' => Auth::id()]
                );
            } else {
                session()->put('cart_items', $cart_items);
            }
        } else {
            if(Auth::check()) {
                Cart::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['details' => '', 'user_id' => Auth::id()]
                );
            } else {
                session()->forget('cart_items');
            }
        }
    }

    public function getTotalPrice(int $part_id = 0)
    {
        $total_cart_price = 0;
        $cart_items = $this->getAllCartItems();
        foreach ($cart_items as $partKey => $cartItm) {
            $partObj = Part::where('id', $partKey)->first(['id', 'price']);
            $total_cart_price += ($partObj->price * $cartItm['quantity']);
        }
        return [
            'total_cart_price' => round($total_cart_price, 2),
            'total_items' => count($cart_items),
            'part_id' => $part_id
        ];
    }

    public function getAllCartItems()
    {
        $cart_items = [];
        if(Auth::check()) {
            $cartObj = Cart::where('user_id', Auth::id())->first(['details']);
            if($cartObj != null && $cartObj->details != '') {
                $cart_items = unserialize($cartObj->details);
            } else {
                $cart_items = [];
            }
        } else {
            if(session()->has('cart_items')) {
                $cart_items = session()->get('cart_items');
            } else {
                $cart_items = [];
            }
        }
        return $cart_items;
    }

    public function getDefaultBillingDetails()
    {
        // billing address
        $billing_address = [];
        if(Auth::check()) {
            $user = Auth::user();
            $billing_address['name'] = $user->name;
            $billing_address['company'] = $user->company;
            $billing_address['address_1'] = $user->address_1;
            $billing_address['address_2'] = $user->address_2;
            $billing_address['country_id'] = $user->country_id;
            $billing_address['state_id'] = $user->state_id;
            $billing_address['city_id'] = $user->city_id;
            $billing_address['zip'] = $user->zip;
            $billing_address['mobile_number'] = $user->mobile_number;
            $billing_address['email'] = $user->email;
        } else {
            if(session()->has('checkout_session_storage')) {
                $checkout_session_storage = session()->get('checkout_session_storage');
                $billing_address['name'] = @$checkout_session_storage['name_billing'];
                $billing_address['company'] = @$checkout_session_storage['company_billing'];
                $billing_address['address_1'] = @$checkout_session_storage['address_1_billing'];
                $billing_address['address_2'] = @$checkout_session_storage['address_2_billing'];
                $billing_address['country_id'] = @$checkout_session_storage['country_billing'];
                $billing_address['state_id'] = @$checkout_session_storage['state_billing'];
                $billing_address['city_id'] = @$checkout_session_storage['city_billing'];
                $billing_address['zip'] = @$checkout_session_storage['zip_billing'];
                $billing_address['mobile_number'] = @$checkout_session_storage['mobile_number_billing'];
                $billing_address['email'] = @$checkout_session_storage['email_billing'];
            }
        }
        return $billing_address;
    }

    public function getDefaultShippingDetails($order_id = '')
    {
        // shipping address
        $shipping_address = [];
        if(Auth::check() && $order_id != '') {
            $orderDetails = Order::where('order_id', $order_id)->where('user_id', Auth::id())->first();
            $shipping_address['name'] = $orderDetails->shipping_name;
            $shipping_address['company'] = $orderDetails->shipping_company;
            $shipping_address['address_1'] = $orderDetails->shipping_address_1;
            $shipping_address['address_2'] = $orderDetails->shipping_address_2;
            $shipping_address['country_id'] = $orderDetails->shipping_country_id;
            $shipping_address['state_id'] = $orderDetails->shipping_state_id;
            $shipping_address['city_id'] = $orderDetails->shipping_city_id;
            $shipping_address['zip'] = $orderDetails->shipping_zip;
            $shipping_address['mobile_number'] = $orderDetails->shipping_mobile_number;
            $shipping_address['email'] = $orderDetails->shipping_email;
            $shipping_address['comment'] = $orderDetails->shipping_comment;
        } else {
            if(session()->has('checkout_session_storage')) {
                $checkout_session_storage = session()->get('checkout_session_storage');
                $shipping_address['name'] = $checkout_session_storage['name_shipping'];
                $shipping_address['company'] = $checkout_session_storage['company_shipping'];
                $shipping_address['address_1'] = $checkout_session_storage['address_shipping_1'];
                $shipping_address['address_2'] = $checkout_session_storage['address_shipping_2'];
                $shipping_address['country_id'] = $checkout_session_storage['country_shipping'];
                $shipping_address['state_id'] = $checkout_session_storage['state_shipping'];
                $shipping_address['city_id'] = $checkout_session_storage['city_shipping'];
                $shipping_address['zip'] = $checkout_session_storage['zip_shipping'];
                $shipping_address['mobile_number'] = $checkout_session_storage['mobile_number_shipping'];
                $shipping_address['email'] = $checkout_session_storage['email_shipping'];
                $shipping_address['comment'] = $checkout_session_storage['comments_shipping'];
            }
        }
        return $shipping_address;
    }

    public function emptyCart()
    {
        Cart::where('user_id', Auth::id())->delete();
    }
}
