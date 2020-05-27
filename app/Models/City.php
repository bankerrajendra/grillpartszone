<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 23:14:26 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property int $state_id
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $users_preferences
 *
 * @package App\Models
 */
class City extends Model
{
	public $timestamps = false;

	protected $casts = [
		'state_id' => 'int'
	];

	protected $fillable = [
		'name',
		'state_id'
	];

	public function state(){
        return $this->belongsTo(\App\Models\State::class);
    }
}
