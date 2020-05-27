<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 23:14:27 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 *
 * @package App\Models
 */
class State extends Model
{
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id'
	];

    public function cities()
    {
        return $this->hasMany(\App\Models\City::class);
    }

    public function country(){
        return $this->belongsTo(\App\Models\Country::class);
    }

}
