<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * @package App\Models
 */
class Cart extends Model
{
    /**
     * @var string
     */
	protected $table = 'carts';

    /**
     * @var array
     */
	protected $fillable = [
		'user_id',
        'details'
	];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
