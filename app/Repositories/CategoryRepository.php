<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductModel;
use App\Models\Part;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $s3_cat_folder;

    /**
     * CategoryRepository constructor.
     */
    public function __construct()
    {
        $this->s3_cat_folder = config('constants.CATEGORY_IMAGES_S3_FOLDER');
    }

    /**
     * Get's a model by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Category::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Category::orderby('ordernum', 'ASC')->get();
    }

    /**
     * Get's all status records.
     *
     * @param int $status
     * @return mixed
     */
    public function allStatus($status = 1)
    {
        return Category::where('status', $status)->orderBy('ordernum', 'ASC')->get(['id', 'name']);
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        $record = Category::find($id);
        // check image is already exists and delete it
        if (Storage::disk('s3')->exists($this->s3_cat_folder . '/' . $record->image)) {
            Storage::disk('s3')->delete($this->s3_cat_folder . '/' . $record->image);
        }
        Category::destroy($id);
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function update(object $request)
    {
        $recordId = $request->input('id');
        $oldRecord = Category::find($recordId);
        // check record exits
        if (!Category::where('id', $recordId)->exists()) {
            return redirect()->back()->withError('Category not exist.');
        }
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('slug')), $recordId);
        // save data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            $catObj = Category::where('id', $recordId)->update($prePareArry);

            // update the parent record if require
            if ($request->has('highercategoryid')) {
                Category::where('id', $request->input('highercategoryid'))->update([
                    'hassubcategory' => 'Y'
                ]);
            }

            // save images
            if ($request->hasFile('image')) {
                // check image is already exists and delete it
                if (Storage::disk('s3')->exists($this->s3_cat_folder . '/' . $oldRecord->image)) {
                    Storage::disk('s3')->delete($this->s3_cat_folder . '/' . $oldRecord->image);
                }
                $originalImage = $request->file('image');
                $imgExt = $originalImage->getClientOriginalExtension();
                $imgSlug = $this->chkDuplicateImgName(slugifyText($request->input('slug')), $imgExt);
                $fileName = $imgSlug . "." . $imgExt;
                $oldRecord->image = $fileName;
                $oldRecord->save();
                Storage::disk('s3')->put($this->s3_cat_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Category Saved.');
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function getRecords($ids = '')
    {
        if ($ids != "") {
            return Category::find($ids);
        } else {
            return Category::whereIn('status', [0, 1]);
        }
    }

    /**
     * @param $records
     * @param string $search
     * @return mixed
     */
    public function getSearchRecords($records, $search = '')
    {
        return $records->getRecordsSearch($search);
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function add(object $request)
    {
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('name')));
        // save model data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            $catObj = Category::create($prePareArry);

            // update the parent record if require
            if ($request->has('highercategoryid')) {
                Category::where('id', $request->input('highercategoryid'))->update([
                    'hassubcategory' => 'Y'
                ]);
            }

            // save images
            if ($request->hasFile('image')) {
                $originalImage = $request->file('image');
                $imgExt = $originalImage->getClientOriginalExtension();
                $imgSlug = $this->chkDuplicateImgName(slugifyText($request->input('name')), $imgExt);
                $fileName = $imgSlug . "." . $imgExt;
                $catObj->image = $fileName;
                $catObj->save();
                Storage::disk('s3')->put($this->s3_cat_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Category Saved.');
    }

    /**
     * @param $slug
     * @param $ext
     * @return string
     */
    protected function chkDuplicateImgName($slug, $ext)
    {
        if (Category::where('image', $slug . '.' . $ext)->exists()) {
            // 2. update slug by adding -2
            $slgName = Category::where('image', 'like', '%' . $slug . '%')->count();
            $slug .= "-" . ($slgName + 1);
        }
        return $slug;
    }

    /**
     * @param $slug
     * @param string $recordId
     * @return string
     */
    protected function chkDuplicateSlug($slug, $recordId = '')
    {
        if ($recordId != '') {
            if (Category::where('slug', $slug)->where('id', '<>', $recordId)->exists()) {
                // 2. update slug by adding -2
                $slgName = Category::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        } else {
            if (Category::where('slug', $slug)->exists()) {
                // 2. update slug by adding -2
                $slgName = Category::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        }
        return $slug;
    }

    /**
     * @param string $slug
     * @param object $request
     * @return array
     */
    protected function prepare_data_array(string $slug, object $request)
    {
        return [
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'highercategoryid' => $request->has('highercategoryid') && $request->input('highercategoryid') != null ? $request->input('highercategoryid') : 0,
            'ordernum' => $request->has('ordernum') ? $request->input('ordernum') : 0,
            'hide' => $request->input('hide'),
            'hide_left_column' => $request->input('hide_left_column'),
            'status' => $request->input('status'),
            'meta_title' => $request->input('meta_title'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
        ];
    }

    /**
     * @param int $recordId
     * @param int $order
     */
    public function changeOrder(int $recordId, int $order)
    {
        $record = Category::find($recordId);
        $record->ordernum = $order;
        $record->save();
    }

    /**
     * Get level categories
     * @param int $parent_id
     * @return mixed
     */
    public function getLevelRecords(array $parent_ids = [])
    {
        if(!empty($parent_ids)) {
            return Category::whereIn('highercategoryid', $parent_ids)->orderBy('ordernum', 'ASC')->get(['id', 'slug', 'name', 'highercategoryid']);
        } else {
            return Category::where('highercategoryid', 0)->orderBy('ordernum', 'ASC')->get(['id', 'slug', 'name', 'highercategoryid']);
        }
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function removeImage(object $request)
    {
        if ($request->has('payload')) {
            $payload = explode("-", $request->input('payload'));
            $recordId = $payload[1];
            $Img = Category::find($recordId);
            if (Storage::disk('s3')->exists($this->s3_cat_folder . '/' . $Img->image)) {
                Storage::disk('s3')->delete($this->s3_cat_folder . '/' . $Img->image);
            }
            // remove record from db
            $Img->image = '';
            $Img->save();
            return response()->json(['success' => 'Image removed.']);
        }
        return response()->json(['error' => 'Some issue while deleting image.']);
    }

    /**
     * Get level categories
     * @param int $parent_id
     * @return mixed
     */
    public function getCategoriesFront($parent_id)
    {
        if(!empty($parent_id)) {
            return Category::where('highercategoryid', $parent_id)->where('status','1')->orderBy('ordernum', 'ASC')->get(['id', 'image', 'slug', 'name', 'highercategoryid']);
        } else {
            return Category::where('highercategoryid', '0')->where('status','1')->orderBy('ordernum', 'ASC')->get(['id', 'image', 'slug', 'name', 'highercategoryid']);
        }
    }

    public function getCategoryBySlug($slug)
    {
        if(!empty($slug)) {
            return Category::where('slug', $slug)->first();
        } else {
            abort('404');
        }
    }

    public function getCategoryParts(int $per_page = 6, object $model, $brandId='0',$modelSlug='')
    {
        //return $parts = $model->parts()->paginate($per_page);
        if($brandId == '0') {
            //echo $per_page.'==>'.$model->id.'==>'.$brandSlug.'<br>';
            return $parts = $model->parts()->paginate($per_page);
        } else {
            //echo "gg";
            if($modelSlug=='') {
                $model_id = ProductModel::where('brand_id', $brandId)->get(['id']);
            } else {
                $model_id = ProductModel::where('slug', $modelSlug)->get(['id']);
            }
            return $parts = Part::getPartWithModelCategoryNew($model_id, $model->id)->paginate($per_page);
        }
    }

    public function getPartsCategory($parent_id)
    {
        $catArray = [];
        $i = 0;
        foreach (Category::whereIn('highercategoryid', $parent_id)->where('status','1')->orderBy('ordernum', 'ASC')->get() as $key => $category) {
            $partsCount = Part::getPartWithCategory($category->id)->count();
            $catArray[$i]['id'] = $category->id;
            $catArray[$i]['name'] = $category->name;
            $catArray[$i]['slug'] = $category->slug;
            $catArray[$i]['highercategoryid'] = $category->highercategoryid;
            $catArray[$i]['total'] = $partsCount;
            $i++;
        }
        return $catArray;
    }

    public function getBbqcoverDimension($cat_id) {
        return $distinctDimensions=Part::getDistinctDimension($cat_id)->get();
    }

}
