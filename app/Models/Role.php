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
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $level
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	use SoftDeletes;
	protected $table = 'roles';

	protected $casts = [
		'level' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'level'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class)
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
