<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class Part
 * 
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string $model_no
 * @property string $item_no
 * @property string $year
 * @property string $note
 * @property string $short_description
 * @property string $long_description
 * @property string $features
 * @property float $price
 * @property float $retail price
 * @property float $cost
 * @property int $stock
 * @property string $weight
 * @property int $impression
 * @property int $created_by
 * @property float $length
 * @property float $height
 * @property float $width
 * @property float $diameter
 * @property bool $is_tax_free
 * @property bool $is_free_ship
 * @property bool $has_qr_code
 * @property bool $is_available_online
 * @property bool $is_available_store
 * @property bool $show_on_grillpartsgallery_com
 * @property bool $show_on_bbqpartsfactory_com
 * @property bool $show_on_bbqpartszone_com
 * @property bool $is_active
 * @property Carbon $date_available
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $manual
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|CategoriesPartsRelation[] $categories_parts_relations
 * @property Collection|PartsImage[] $parts_images
 *
 * @package App\Models
 */
class Part extends Model
{
	protected $table = 'parts';

	protected $casts = [
		'price' => 'float',
		'retail price' => 'float',
		'cost' => 'float',
		'stock' => 'int',
		'impression' => 'int',
		'created_by' => 'int',
		'length' => 'float',
		'height' => 'float',
		'width' => 'float',
		'diameter' => 'float',
		'show_on_grillpartsgallery_com' => 'bool',
		'show_on_bbqpartsfactory_com' => 'bool',
		'show_on_bbqpartszone_com' => 'bool',
		'is_active' => 'bool'
	];

	protected $dates = [
		'date_available'
	];

	protected $fillable = [
		'name',
        'slug',
		'sku',
		'model_no',
		'item_no',
		'year',
		'note',
		'short_description',
		'long_description',
		'features',
		'price',
		'retail_price',
		'cost',
		'stock',
		'weight',
		'impression',
		'created_by',
		'length_1',
		'length_2',
		'height_1',
		'height_2',
		'width_1',
		'width_2',
		'diameter_1',
		'diameter_2',
		'show_on_grillpartsgallery_com',
		'show_on_bbqpartsfactory_com',
		'show_on_bbqpartszone_com',
		'is_active',
		'meta_title',
		'meta_keywords',
		'meta_description'
	];


	public function categories()
	{
		return $this->belongsToMany(Category::class, 'categories_parts_relation', 'part_id', 'category_id');
	}

	public function parts_images()
	{
		return $this->hasMany(PartsImage::class);
	}

    public function parts_manuals()
    {
        return $this->hasMany(PartsManual::class);
    }

    public function models()
    {
        return $this->belongsToMany(ProductModel::class, 'models_parts_relation', 'part_id', 'model_id')->withTimestamps();
    }

    /**
     * @param $query
     * @param string $search
     * @param string $search_with
     * @return mixed
     */
    public function scopeGetRecordsSearch($query, $search = '', $search_with = '')
    {
        if($search_with != '') {
            return $query->where($search_with, 'like', '%' . $search . '%');
        } else {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('model_no', 'like', '%' . $search . '%')
                ->orWhere('note', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%')
                ->orWhere('long_description', 'like', '%' . $search . '%')
                ->orWhere('features', 'like', '%' . $search . '%');
        }
    }

    public function scopeGetCategoryRecords($query, $cat_ids)
    {
        return $query->whereHas('categories', function ($q) use ($cat_ids) {
            $q->whereIn('category_id', $cat_ids);
        });
    }

    public function scopeCheckTypeCategoryPart($query, int $part_id, string $category_name)
    {
        if($part_id != '' && $category_name != '') {
            $cat_access = Category::where('name', $category_name)->first(['id']);
            return $query->where('id', $part_id)->getCategoryRecords([$cat_access->id])->exists();
        }
    }

    public function getSingleImg()
    {
        $imgFld = config('constants.PART_IMAGES_S3_FOLDER');
        $imgRec = PartsImage::where('part_id', $this->id)->first();
        if($imgRec != null) {
            if (Storage::disk('s3')->exists($imgFld . '/' . $imgRec->image)) {
                return Storage::disk('s3')->url($imgFld . '/' . $imgRec->image);
            }
        }
        return asset('img/no-part-image.png');
    }

    public function inWishList()
    {
        if(Auth::check()) {
            $wishList = WishList::where('user_id', Auth::id())->first(['details']);
            if($wishList != null && $wishList->details != '') {
                if(array_key_exists($this->id, unserialize($wishList->details))) {
                    return true;
                }
            }
        } else {
            if(session()->has('wish_list')) {
                $wishList = session()->get('wish_list');
                if(array_key_exists($this->id, $wishList)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $query
     * @param int $model_id
     * @param int $category_id
     * @return mixed
     */
    public function scopeGetPartWithModelCategory($query, int $model_id, int $category_id)
    {
        return $query->whereHas('models',
            function($innerQuery) use($model_id) {
                $innerQuery->where(
                    function($innerQuery1) use($model_id) {
                        $innerQuery1->where('model_id', $model_id);
                    });
            })->whereHas('categories',
                function ($innerQuery) use($category_id) {
                    $innerQuery->where(
                        function ($innerQuery2) use($category_id) {
                            $innerQuery2->where('category_id', $category_id);
                        }
                    );
                });
    }

    /**
     * @param $query
     * @param int $category_id
     * @return mixed
     */
    public function scopeGetPartWithCategory($query, int $category_id)
    {
        return $query->whereHas('categories',
            function ($innerQuery) use($category_id) {
                $innerQuery->where(
                    function ($innerQuery2) use($category_id) {
                        $innerQuery2->where('category_id', $category_id);
                    }
                );
            });
    }

    /**
     * @param $query
     * @param object $model_id
     * @param int $category_id
     * @return mixed
     */
    public function scopeGetPartWithModelCategoryNew($query, $model_id, int $category_id)
    {
        return $query->whereHas('models',
            function($innerQuery) use($model_id) {
                $innerQuery->where(
                    function($innerQuery1) use($model_id) {
                        $innerQuery1->whereIn('model_id', $model_id);
                    });
            })->whereHas('categories',
            function ($innerQuery) use($category_id) {
                $innerQuery->where(
                    function ($innerQuery2) use($category_id) {
                        $innerQuery2->where('category_id', $category_id);
                    }
                );
            });
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGetDistinctDimension($query, int $cat_id) {
        return $query->selectRaw('width_1, diameter_1, height_1, count(*) as total')
            ->where('width_1','>',0)
            ->where('diameter_1','>',0)
            ->where('height_1','>',0)
            ->whereHas('categories',
                    function ($innerQuery) use($cat_id) {
                        $innerQuery->where('category_id', $cat_id);
                    }
                )
            ->groupBy('width_1', 'diameter_1', 'height_1');
    }
}
