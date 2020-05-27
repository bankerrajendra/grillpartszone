<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class PartsImage
 * 
 * @property int $id
 * @property int $part_id
 * @property string $document
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Part $part
 *
 * @package App\Models
 */
class PartsManual extends Model
{
	protected $table = 'parts_manuals';

	protected $casts = [
		'part_id' => 'int'
	];

	protected $fillable = [
		'part_id',
		'document'
	];

	public function part()
	{
		return $this->belongsTo(Part::class);
	}

    // get part manual by id
    public function getDocURL()
    {
        if (Storage::disk('s3')->exists(config('constants.PART_MANUALS_S3_FOLDER') . '/' . $this->document)) {
            return Storage::disk('s3')->url(config('constants.PART_MANUALS_S3_FOLDER') . '/' . $this->document);
        }
    }
}
