<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderPartDetail
 * 
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $part_id
 * @property int $brand_id
 * @property int $quantity
 * @property float $part_price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OrderPartDetail extends Model
{
	protected $table = 'order_part_details';

	protected $casts = [
		'user_id' => 'int',
		'order_id' => 'int',
		'part_id' => 'int',
		'brand_id' => 'int',
		'quantity' => 'int',
		'part_price' => 'float'
	];

	protected $fillable = [
		'user_id',
		'order_id',
		'part_id',
		'brand_id',
		'quantity',
		'part_price'
	];

	public function part()
    {
        return $this->belongsTo(\App\Models\Part::class, 'part_id');
    }
}
