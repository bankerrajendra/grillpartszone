<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 23:14:26 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $phonecode
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $users_preferences
 *
 * @package App\Models
 */
class Country extends Model
{
	public $timestamps = false;

	protected $casts = [
		'phonecode' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'phonecode'
	];

	public function states(){
	    return $this->hasMany(\App\Models\State::class);
    }
}
