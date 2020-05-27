<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RoleUser
 * 
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Role $role
 * @property User $user
 *
 * @package App\Models
 */
class RoleUser extends Model
{
	use SoftDeletes;
	protected $table = 'role_user';

	protected $casts = [
		'role_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'user_id'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
