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
 * @property string $image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Part $part
 *
 * @package App\Models
 */
class PartsImage extends Model
{
	protected $table = 'parts_images';

	protected $casts = [
		'part_id' => 'int'
	];

	protected $fillable = [
		'part_id',
		'image'
	];

	public function part()
	{
		return $this->belongsTo(Part::class);
	}

    // get part image by id
    public function getImageURL()
    {
        if (Storage::disk('s3')->exists(config('constants.PART_IMAGES_S3_FOLDER') . '/' . $this->image)) {
            return Storage::disk('s3')->url(config('constants.PART_IMAGES_S3_FOLDER') . '/' . $this->image);
        }
    }
}
