<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelsPartsRelation
 * 
 * @property int $id
 * @property int $model_id
 * @property int $part_id
 *
 * @package App\Models
 */
class ModelsPartsRelation extends Model
{
	protected $table = 'models_parts_relation';
	public $timestamps = false;
    public $incrementing = true;

	protected $casts = [
		'model_id' => 'int',
		'part_id' => 'int'
	];

	protected $fillable = [
		'model_id',
		'part_id',
        'ordernum'
	];
}
