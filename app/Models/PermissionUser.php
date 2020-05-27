<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PermissionUser
 * 
 * @property int $id
 * @property int $permission_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Permission $permission
 * @property User $user
 *
 * @package App\Models
 */
class PermissionUser extends Model
{
	use SoftDeletes;
	protected $table = 'permission_user';

	protected $casts = [
		'permission_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'permission_id',
		'user_id'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
