<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Permission[] $permissions
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasRoleAndPermission;
    use Notifiable;

	protected $table = 'users';

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
        'company',
        'mobile_number',
        'address_1',
        'address_2',
        'zip',
        'city_id',
        'state_id',
        'country_id',
        'old_user_name',
        'old_customer_id',
        'active',
		'remember_token'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class)
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class)
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }

    public function wish_list()
    {
        return $this->hasOne('App\Models\WishList');
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function scopeHasUserRole($query){
        return $query->whereHas('roles', function ($innerQuery) {
            $innerQuery->where('roles.slug', '=', 'user');
        });
    }
}
