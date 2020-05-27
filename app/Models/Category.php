<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string $hassubcategory
 * @property int $highercategoryid
 * @property string $image
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $ordernum
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $casts = [
        'highercategoryid' => 'int',
        'ordernum' => 'int',
        'status' => 'bool'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'hassubcategory',
        'highercategoryid',
        'hide',
        'hide_left_column',
        'image',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'ordernum',
        'status'
    ];

    public function parts()
    {
        //return $this->belongsToMany(Category::class, 'categories_parts_relation', 'category_id', 'part_id');
        return $this->belongsToMany(Part::class, 'categories_parts_relation', 'category_id', 'part_id'); //->withTimestamps();
    }

    public function parent()
    {
        if ($this->highercategoryid > 0) {
            return Category::where('id', $this->highercategoryid)->first(['id', 'highercategoryid', 'name']);
        }
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
            ->orWhere('description', 'like', '%' . $search . '%');
    }

    /**
     * @return mixed
     */
    public function getCatImg()
    {
        $catImgFld = config('constants.CATEGORY_IMAGES_S3_FOLDER');
        if ($this->image != '') {
            if (Storage::disk('s3')->exists($catImgFld . '/' . $this->image)) {
                return Storage::disk('s3')->url($catImgFld . '/' . $this->image);
            }
        }
        return asset('img/no-part-image.png');
    }

    /**
     * @param int $parent_id
     * @return string
     */
    public function deterMineLevel(int $parent_id)
    {
        if(Category::where('id', $parent_id)->where('highercategoryid', 0)->exists()) {
            return 'second';
        } else if(Category::where('id', $parent_id)->where('highercategoryid', '<>', 0)->exists()){
            return 'third';
        }
    }

}
