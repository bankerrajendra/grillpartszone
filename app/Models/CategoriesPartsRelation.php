<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriesPartsRelation
 * 
 * @property int $id
 * @property int $category_id
 * @property int $part_id
 * 
 * @property Part $part
 *
 * @package App\Models
 */
class CategoriesPartsRelation extends Model
{
	protected $table = 'categories_parts_relation';
	public $timestamps = false;

	protected $casts = [
		'category_id' => 'int',
		'part_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'part_id'
	];
}
