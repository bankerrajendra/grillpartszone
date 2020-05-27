<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateways;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use JsValidator;
use App\Repositories\OrderRepository;
use App\Repositories\LocationRepository;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    protected $editValidationRules = [
        'user_id' => 'required|numeric',
        'order_date' => 'required',
        'amount' => 'required',
        'tax' => 'required',
        'shipping_amount' => 'required',
        'shipping_email' => 'required|email',
        'shipping_company' => 'required|alpha_spaces|max:50',
        'shipping_name' => 'required|alpha_spaces|max:50',
        'shipping_address_1' => 'required|max:100',
        'shipping_address_2' => 'sometimes|max:100',
        'shipping_mobile_number' => 'required|numeric|digits_between:7,12',
        'shipping_country_id' => 'required',
        'shipping_state_id' => 'required',
        'shipping_city_id' => 'required',
        'shipping_zip' => 'required|max:20',
        'currency' => 'required'
    ];

    protected $customEditRuleStrings = [
        'user_id.required' => 'Customer Id required.'
    ];


    protected $orderRepo, $locRepo;

    public function __construct(OrderRepository $orderRepo, LocationRepository $locRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->locRepo = $locRepo;

        View::share('countries', $locRepo->getCountries());
    }

    public function print($id)
    {
        $order_id = $id;
        $orderInfo = $this->orderRepo->getRecords($order_id);

        return view('admin.stores.orders.print', [
            'order_details' => $orderInfo
        ]);

    }

    public function show($id, Request $request)
    {
        $order_id = $id;
        $orderInfo = $this->orderRepo->getRecords($order_id);

        return view('admin.stores.orders.show', [
            'order_details' => $orderInfo
        ]);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function makeACopy($id)
    {
        return $this->orderRepo->make_copy($id);
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function edit($recordId)
    {
        $validator = JsValidator::make($this->editValidationRules, $this->customEditRuleStrings);
        $record = $this->orderRepo->get($recordId);

        // get state and cities shipping
        $statesShippingPopulate = $this->locRepo->getStates($record->shipping_country_id);
        $citiesShippingPopulate = $this->locRepo->getCities($record->shipping_state_id);

        // payment gateways
        $gateway_recs = PaymentGateways::get(['id', 'name']);
        // shipping
        $shipping_recs = Shipping::get(['id', 'shipping_type', 'price']);
        return view('admin.stores.orders.edit', [
                'record' => $record,
                'customers' => User::hasUserRole()->get(['id', 'name']),
                'states' => $statesShippingPopulate,
                'cities' => $citiesShippingPopulate,
                'shipping_records' => $shipping_recs,
                'gateway_records' => $gateway_recs,
                'validator' => $validator
            ]
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleEdit(Request $request)
    {
        $validator = Validator::make($request->all(), $this->editValidationRules, $this->customEditRuleStrings);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->orderRepo->update($request);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function handleDelete($id)
    {
        $this->orderRepo->delete($id);
        return redirect()->route('admin-orders')->withSuccess('Order Deleted.');
    }

    public function getOrderDetail(Request $request)
    {
        $order_id = $request->has('order_id') ? $request->input('order_id') : '';
        if($order_id != '') {
            $orderInfo = $this->orderRepo->getRecords($order_id);
            if($orderInfo != null) {
                return view('admin.stores.orders.includes.order-details', [
                    'order_details' => $orderInfo
                ]);
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $page = $request->has('page') ? $request->input('page') : 1;
        $per_page = $request->has('per_page') ? $request->input('per_page') : 10;
        $process_type = $request->has('process_type') ? $request->input('process_type') : "";
        $paid_type = $request->has('paid_type') ? $request->input('paid_type') : "";
        $catalog_id = $request->has('catalog_id') ? $request->input('catalog_id') : "";
        $search_with = $request->has('search_with') ? $request->input('search_with') : "";
        $search = $request->has('search') ? $request->input('search') : "";
        $records = $this->orderRepo->getRecords();
        $records = $this->orderRepo->getSearchRecords($records, $process_type, $paid_type, $catalog_id, $search, $search_with);
        $records = $records->latest()
            ->paginate($per_page);

        if ($page > 1) {
            $page = (($page - 1) * $per_page) + 1;
        }

        $all_counts = $this->orderRepo->getRecords()
            ->count();


        return view('admin.stores.orders.list', [
                'records' => $records,
                'per_page' => $per_page,
                'process_type' => $process_type,
                'paid_type' => $paid_type,
                'catalog_id' => $catalog_id,
                'search_with' => $search_with,
                'search' => $search,
                'all_records' => $all_counts
            ]
        );
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function handleBulkAction(Request $request)
    {
        $action = $request->has('action') ? $request->input('action') : "";
        $ids = $request->has($action) ? $request->input($action) : "";

        if ($action != "" && ($action == "delete" || $action == 'processed' ||$action == 'failed') && !empty($ids)) {
            $records = $this->orderRepo->getRecords($ids);
            if ($action == "processed" || $action == "failed") {
                try {
                    foreach ($records as $record) {
                        if($action == "processed") {
                            $record->processed = 1;
                        } else if($action == "failed") {
                            $record->order_method = 'Fail';
                        }
                        $record->save();
                    }
                    return redirect()->back()->withSuccess('Records(s) marked as '.$action.' successfully.');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in updating Records(s), please try again.');
                }
            } else if ($action == "delete") {
                try {
                    // delete
                    $records = $this->orderRepo->getRecords($ids);
                    foreach ($records as $record) {
                        $this->orderRepo->delete($record->order_id);
                    }
                    return redirect()->back()->withSuccess('Record(s) deleted successfully.');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in deleting Record(s), please try again.');
                }
            }
        }
        return redirect()->back()->withErrors('There is some problem, please try again.');
    }
}
