<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $order_id
 * @property int $user_id
 * @property Carbon $order_date
 * @property float $amount
 * @property float $tax
 * @property string $shipping_email
 * @property string $shipping_company
 * @property string $shipping_name
 * @property string $shipping_address_1
 * @property string $shipping_address_2
 * @property string $shipping_mobile_number
 * @property int $shipping_country_id
 * @property int $shipping_state_id
 * @property int $shipping_city_id
 * @property string $shipping_zip
 * @property string $shipping_comment
 * @property int $shipping_id
 * @property int $payment_method
 * @property string $order_method
 * @property Carbon $promised_ship_date
 * @property string $transaction_information
 * @property string $transaction_error
 * @property bool $canceled
 * @property string $coupon
 * @property float $coupon_discount
 * @property string $ip_address
 * @property float $product_total_amount
 * @property string $order_status
 * @property bool $canceled_by_user
 * @property string $currency
 * @property string $currency_rate
 * @property string $order_pending
 * @property string $shipping_message
 * @property string $ups_track_no
 * @property string $store_match
 * @property string $store_name
 * @property int $ossuserid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	protected $primaryKey = 'order_id';

	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float',
		'tax' => 'float',
		'shipping_country_id' => 'int',
		'shipping_state_id' => 'int',
		'shipping_city_id' => 'int',
		'payment_method' => 'int',
		'canceled' => 'bool',
		'coupon_discount' => 'float',
		'product_total_amount' => 'float',
		'canceled_by_user' => 'bool',
		'ossuserid' => 'int'
	];

	protected $dates = [
		'order_date',
		'promised_ship_date'
	];

	protected $fillable = [
		'user_id',
        'old_db_user_id',
		'order_date',
		'amount',
		'tax',
        'shipping_amount',
		'shipping_email',
		'shipping_company',
		'shipping_name',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_mobile_number',
		'shipping_country_id',
		'shipping_state_id',
		'shipping_city_id',
		'shipping_zip',
		'shipping_comment',
        'shipping_id',
		'payment_method',
		'order_method',
		'promised_ship_date',
		'transaction_information',
		'transaction_error',
		'canceled',
		'coupon',
		'coupon_discount',
		'ip_address',
		'product_total_amount',
		'order_status',
        'processed',
		'canceled_by_user',
		'currency',
		'currency_rate',
		'order_pending',
		'shipping_message',
		'ups_track_no',
		'store_match',
		'store_name',
		'ossuserid'
	];

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'shipping_country_id');
    }

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class, 'shipping_state_id');
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'shipping_city_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function shipping()
    {
        return $this->belongsTo(\App\Models\Shipping::class, 'shipping_id');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\OrderPartDetail::class, 'order_id');
    }

    /**
     * @param $query
     * @param string $process_type
     * @param string $paid_type
     * @param string $catalog_id
     * @param string $search
     * @param string $search_with
     * @return mixed
     */
    public function scopeGetRecordsSearch($query, $process_type = '', $paid_type = '', $catalog_id = '', $search = '', $search_with = '')
    {
        if($process_type != '') {
            $query->where('processed', '=', $process_type);
        }
        if($paid_type != '') {
            if($paid_type == 'Yes') {
                $query->where('order_status', '=', 'Paid');
            } else if($paid_type == 'No') {
                $query->whereNull('order_status');
            }
        }
        if($catalog_id != '') {
            $query->whereHas('products', function ($innerQuery) use ($catalog_id) {
                return $innerQuery->where('part_id', $catalog_id);
            });
        }
        if($search != '') {
            if ($search_with != '') {
                switch ($search_with) {
                    case 'order_date':
                        $date = str_replace('/', '-', $search);
                        $search = date('Y-m-d', strtotime($date));
                        break;
                    case 'shipping_country_id':
                        $countryObj = Country::where('name', 'like', '%'.$search.'%')->orWhere('code', 'like', '%'.$search.'%')->first(['id']);
                        if($countryObj != null) {
                            $search = $countryObj->id;
                        }
                        break;
                    case 'shipping_state_id':
                        $stateObj = State::where('name', 'like', '%'.$search.'%')->first(['id']);
                        if($stateObj != null) {
                            $search = $stateObj->id;
                        }
                        break;
                    case 'shipping_city_id':
                        $cityObj = City::where('name', 'like', '%'.$search.'%')->first(['id']);
                        if($cityObj != null) {
                            $search = $cityObj->id;
                        }
                        break;
                }

                $query->where($search_with, 'like', '%' . $search . '%');
            } else {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            }
        }
        return $query;
    }
}
