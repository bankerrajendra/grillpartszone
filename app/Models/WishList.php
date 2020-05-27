<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WishList
 * @package App\Models
 */
class WishList extends Model
{
    /**
     * @var string
     */
	protected $table = 'wish_lists';

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
