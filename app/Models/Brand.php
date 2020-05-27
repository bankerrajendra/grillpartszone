<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Brand
 *
 * @property int $id
 * @property string $chr
 * @property string $brand
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brands';

	protected $fillable = [
		'chr',
		'brand',
        'slug',
        'image',
        'description',
        'model_description',
        'meta_title',
        'meta_keywords',
        'meta_description'
	];

    /**
     * @return mixed
     */
    public function models()
    {
        return $this->hasMany(\App\Models\ProductModel::class, 'brand_id');
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        $imgFld = config('constants.BRAND_IMAGES_S3_FOLDER');
        if ($this->image != '') {
            if (Storage::disk('s3')->exists($imgFld . '/' . $this->image)) {
                return Storage::disk('s3')->url($imgFld . '/' . $this->image);
            }
        }
        return asset('img/no-part-image.png');
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeGetRecordsSearch($query, $search)
    {
        return $query->where('brand', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%');
    }

    public function getLink()
    {
        return route('brand-models-list', ['slug' => $this->slug]);
    }
}
