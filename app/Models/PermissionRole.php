<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PermissionRole
 * 
 * @property int $id
 * @property int $permission_id
 * @property int $role_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Permission $permission
 * @property Role $role
 *
 * @package App\Models
 */
class PermissionRole extends Model
{
	use SoftDeletes;
	protected $table = 'permission_role';

	protected $casts = [
		'permission_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'permission_id',
		'role_id'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
