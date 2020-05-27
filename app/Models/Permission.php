<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $model
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Collection|Role[] $roles
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Permission extends Model
{
	use SoftDeletes;
	protected $table = 'permissions';

	protected $fillable = [
		'name',
		'slug',
		'description',
		'model'
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class)
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function users()
	{
		return $this->belongsToMany(User::class)
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
