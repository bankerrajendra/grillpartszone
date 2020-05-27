<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class Part
 * 
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property int $part_id
 * @property string $model_no
 * @property float $price
 * @property string $parts_images
 * @property string $fit_compatible_models
 * @package App\Models
 */
class TempPart extends Model
{
	protected $table = 'temp_parts';
    public $timestamps = false;


	protected $fillable = [
		'name',
        'part_id',
		'sku',
		'model_no',
		'price',
		'parts_images',
		'fit_compatible_models'
	];
}
