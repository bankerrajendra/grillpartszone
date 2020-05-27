<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderPartDetail;
use App\Models\Part;

/**
 * Class OrderRepository
 * @package App\Repositories
 */
class OrderRepository
{
    /**
     * CartRepository constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $id
     * @return mixed
     */
    public function make_copy($id)
    {
        $copyRecord = Order::find($id);

        $arrayToInsert = [
            "user_id" => $copyRecord->user_id,
            "order_date" => $copyRecord->order_date,
            "amount" => $copyRecord->amount,
            "tax" => $copyRecord->tax,
            "shipping_amount" => $copyRecord->shipping_amount,
            "shipping_email" => $copyRecord->shipping_email,
            "shipping_company" => $copyRecord->shipping_company,
            "shipping_name" => $copyRecord->shipping_name,
            "shipping_address_1" => $copyRecord->shipping_address_1,
            "shipping_address_2" => $copyRecord->shipping_address_2,
            "shipping_mobile_number" => $copyRecord->shipping_mobile_number,
            "shipping_country_id" => $copyRecord->shipping_country_id,
            "shipping_state_id" => $copyRecord->shipping_state_id,
            "shipping_city_id" => $copyRecord->shipping_city_id,
            "shipping_zip" => $copyRecord->shipping_zip,
            "shipping_comment" => $copyRecord->shipping_comment,
            "shipping_id" => $copyRecord->shipping_id,
            "payment_method" => $copyRecord->payment_method,
            "order_method" => $copyRecord->order_method,
            "promised_ship_date" => $copyRecord->promised_ship_date,
            "transaction_information" => $copyRecord->transaction_information,
            "transaction_error" => $copyRecord->transaction_error,
            "canceled" => $copyRecord->canceled,
            "ip_address" => $copyRecord->ip_address,
            "product_total_amount" => $copyRecord->product_total_amount,
            "order_status" => $copyRecord->order_status,
            "processed" => $copyRecord->processed,
            "canceled_by_user" => $copyRecord->canceled_by_user,
            "currency" => $copyRecord->currency,
            "order_pending" => $copyRecord->order_pending,
            "shipping_message" => $copyRecord->shipping_message,
            "ups_track_no" => $copyRecord->ups_track_no,
            "store_name" => $copyRecord->store_name
        ];

        // save model data
        try {
            $recObj = Order::create($arrayToInsert);
            // save parts details
            $parts = $copyRecord->products;
            if($parts != null) {
                foreach ($parts as $part) {
                    OrderPartDetail::create([
                        'user_id' => $part->user_id,
                        'order_id' => $recObj->order_id,
                        'part_id' => $part->part_id,
                        'brand_id' => $part->brand_id,
                        'quantity' => $part->quantity,
                        'part_price' => $part->part_price
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->route('edit-order', ['id' => $recObj->order_id])->withSuccess('Order Copied.');
    }

    public function update(object $request)
    {
        $recordId = $request->input('id');
        // check record exits
        if (!Order::where('order_id', $recordId)->exists()) {
            return redirect()->back()->withError('Order not exist.');
        }

        // save data
        try {
            Order::where('order_id', $recordId)->update([
                "user_id" => $request->input('user_id'),
                "order_date" => $request->input('order_date'),
                "amount" => $request->input('amount'),
                "tax" => $request->input('tax'),
                "shipping_amount" => $request->input('shipping_amount'),
                "shipping_email" => $request->input('shipping_email'),
                "shipping_company" => $request->input('shipping_company'),
                "shipping_name" => $request->input('shipping_name'),
                "shipping_address_1" => $request->input('shipping_address_1'),
                "shipping_address_2" => $request->input('shipping_address_2'),
                "shipping_mobile_number" => $request->input('shipping_mobile_number'),
                "shipping_country_id" => $request->input('shipping_country_id'),
                "shipping_state_id" => $request->input('shipping_state_id'),
                "shipping_city_id" => $request->input('shipping_city_id'),
                "shipping_zip" => $request->input('shipping_zip'),
                "shipping_comment" => $request->has('shipping_comment') && $request->input('shipping_comment') != null ? $request->input('shipping_comment') : null,
                "shipping_id" => $request->input('shipping_id'),
                "payment_method" => $request->has('payment_method') && $request->input('payment_method') != null ? $request->input('payment_method') : 0,
                "order_method" => $request->has('order_method') && $request->input('order_method') != null ? $request->input('order_method') : null,
                "promised_ship_date" => $request->has('promised_ship_date') && $request->input('promised_ship_date') != null ? $request->input('promised_ship_date') : null,
                "transaction_information" => $request->has('transaction_information') && $request->input('transaction_information') != null ? $request->input('transaction_information') : null,
                "transaction_error" => $request->has('transaction_error') && $request->input('transaction_error') != null ? $request->input('transaction_error') : null,
                "canceled" => $request->has('canceled') && $request->input('canceled') != null ? $request->input('canceled') : 0,
                "ip_address" => $request->input('ip_address'),
                "product_total_amount" => $request->input('product_total_amount'),
                "order_status" => $request->has('order_status') && $request->input('order_status') != null ? $request->input('order_status') : null,
                "processed" => $request->input('processed'),
                "canceled_by_user" => $request->has('canceled_by_user') && $request->input('canceled_by_user') != null ? $request->input('canceled_by_user') : null,
                "currency" => $request->input('currency'),
                "order_pending" => $request->has('order_pending') && $request->input('order_pending') != null ? $request->input('order_pending') : null,
                "shipping_message" => $request->has('shipping_message') && $request->input('shipping_message') != null ? $request->input('shipping_message') : null,
                "ups_track_no" => $request->has('ups_track_no') && $request->input('ups_track_no') != null ? $request->input('ups_track_no') : null,
                "store_name" => $request->has('store_name') && $request->input('store_name') != null ? $request->input('store_name') : null
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Order Saved.');
    }

    /**
     * Get's a model by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Order::find($id);
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function getRecords($ids = '')
    {
        if ($ids != "") {
            return Order::find($ids);
        } else {
            return Order::where('order_id', '<>', 0);
        }
    }

    public function delete(int $order_id)
    {
        $record = Order::find($order_id);
        foreach ($record->products as $product) {
            $product->delete();
        }
        $record->delete();
    }

    /**
     * @param $records
     * @param string $process_type
     * @param string $paid_type
     * @param string $catalog_id
     * @param string $search
     * @param string $search_with
     * @return mixed
     */
    public function getSearchRecords($records, $process_type = '', $paid_type = '', $catalog_id = '', $search = '', $search_with = '')
    {
        return $records->getRecordsSearch($process_type, $paid_type, $catalog_id, $search, $search_with);
    }
}