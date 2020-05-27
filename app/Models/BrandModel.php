<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandModel
 * 
 * @property int $id
 * @property string $item
 * @property int $brand_id
 * @property string $brand
 * @property int $model_id
 * @property string $model
 * @property string $iitem
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BrandModel extends Model
{
	protected $table = 'brand_model';

	protected $casts = [
		'brand_id' => 'int',
		'model_id' => 'int'
	];

	protected $fillable = [
		'item',
		'brand_id',
		'brand',
		'model_id',
		'model',
		'iitem'
	];
}
