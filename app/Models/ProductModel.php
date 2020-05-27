<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProducModel
 *
 * @property int $id
 * @property int $old_id
 * @property int $brand_id
 * @property string $name
 * @property string $model_number
 * @property string $item_number
 * @property string $sku
 * @property string $year
 * @property string $note
 * @property string $short_description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ProductModel extends Model
{
    protected $table = 'models';

    protected $casts = [
        'old_id' => 'int',
        'brand_id' => 'int'
    ];

    protected $fillable = [
        'old_id',
        'brand_id',
        'name',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'model_number',
        'item_number',
        'sku',
        'year',
        'note',
        'short_description',
        'image',
        'status'
    ];

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'models_parts_relation', 'model_id', 'part_id')->withTimestamps();
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeGetRecordsSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('id', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
            ->orWhere('model_number', 'like', '%' . $search . '%')
            ->orWhere('item_number', 'like', '%' . $search . '%')
            ->orWhere('note', 'like', '%' . $search . '%')
            ->orWhere('short_description', 'like', '%' . $search . '%');
    }

    /**
     * @return mixed
     */
    public function getImg(bool $showBrand = true)
    {
        $imgFld = config('constants.MODEL_IMAGES_S3_FOLDER');
        if ($this->image != '') {
            if (Storage::disk('s3')->exists($imgFld . '/' . $this->image)) {
                return Storage::disk('s3')->url($imgFld . '/' . $this->image);
            }
        } //else {
            if($showBrand) {

                return $this->brand->getImg();
                // get image of brand
            }
        //}


    }

    /**
     * @return string
     */
    public function getLink()
    {
        $brand = Brand::where('id', $this->brand_id)->first(['slug']);
        return route('brands-model', ['brandSlug' => $brand->slug, 'slug' => $this->slug]);
    }

}
