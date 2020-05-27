<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\CategoriesPartsRelation;
use App\Models\Category;
use App\Models\ModelsPartsRelation;
use App\Models\Part;
use App\Models\PartsImage;
use App\Models\PartsManual;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

/**
 * Class PartRepository
 * @package App\Repositories
 */
class PartRepository
{
    /**
     * @var mixed
     */
    protected $s3_part_images_folder;
    protected $s3_part_manuals_folder;

    /**
     * PartRepository constructor.
     */
    public function __construct()
    {
        $this->s3_part_images_folder = config('constants.PART_IMAGES_S3_FOLDER');
        $this->s3_part_manuals_folder = config('constants.PART_MANUALS_S3_FOLDER');
    }

    public function getPartBy(string $type = 'id', $value)
    {
        return Part::where($type, $value)->first();
    }

    /**
     * Get's a model by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Part::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Part::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        $record = Part::find($id);
        // delete category associations
        $catsAssoc = CategoriesPartsRelation::where('part_id', $id)->delete();
        // delete manuals
        $manuals = $record->parts_manuals;
        if ($manuals != '') {
            foreach ($manuals as $manual) {
                if (Storage::disk('s3')->exists($this->s3_part_manuals_folder . '/' . $manual->document)) {
                    Storage::disk('s3')->delete($this->s3_part_manuals_folder . '/' . $manual->document);
                }
                // remove record from db
                $manual->delete();
            }
        }
        // delete associated models
        $modelAssoc = ModelsPartsRelation::where('part_id', $id)->delete();

        // get part images
        $imgs = $record->parts_images;
        if ($imgs != '') {
            foreach ($imgs as $image) {
                if (Storage::disk('s3')->exists($this->s3_part_images_folder . '/' . $image->image)) {
                    Storage::disk('s3')->delete($this->s3_part_images_folder . '/' . $image->image);
                }
                // remove record from db
                $image->delete();
            }
        }
        Part::destroy($id);
    }

    /**
     * Get's all status records.
     *
     * @param int $status
     * @return mixed
     */
    public function allStatus($status = 1)
    {
        return Part::where('is_active', $status)->get(['id', 'name']);
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function getRecords($ids = '')
    {
        if ($ids != "") {
            return Part::find($ids);
        } else {
            return Part::whereIn('is_active', [0, 1]);
        }
    }


    /**
     * @param $records
     * @param string $search
     * @return mixed
     */
    public function getSearchRecords($records, $search = '', $search_with = '')
    {
        return $records->getRecordsSearch($search, $search_with);
    }
    /**
     * Updates a record.
     *
     * @param object $request
     * @return mixed
     */
    public function update(object $request)
    {
        $recordId = $request->input('id');
        $oldRecord = Part::find($recordId);
        // check record exits
        if (!Part::where('id', $recordId)->exists()) {
            return redirect()->back()->withError('Part not exist.');
        }
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('slug')), $recordId);
        // save data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            Part::where('id', $recordId)->update($prePareArry);

            // save categories
            $catDetArry = [];
            foreach ($oldRecord->categories as $catObj) {
                $catDetArry[] = $catObj->id;
            }
            // remove attached
            if (count($catDetArry) > 0) {
                $oldRecord->categories()->detach($catDetArry);
            }
            if ($request->has('categories_top') || $request->has('categories_sub') || $request->has('categories_sub_sub')) {
                // sync
                $array_cats = array_merge($request->has('categories_top') ? $request->input('categories_top') : [], $request->has('categories_sub') ? $request->input('categories_sub') : [], $request->has('categories_sub_sub') ? $request->input('categories_sub_sub') : []);
                $oldRecord->categories()->sync($array_cats);
            }
            // save images
            $this->save_images($recordId, $request);
            // save manual
            $this->save_manuals($recordId, $request);

        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Part Saved.');
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function add(object $request)
    {
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('name')));
        // save data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            $partObj = Part::Create($prePareArry);

            // save models
            /**
             * if($request->has('models')) {
             * // attach
             * $models = ProductModel::find($request->input('models'));
             * $partObj->models()->attach($models);
             * }**/

            // save categories
            if ($request->has('categories_top')) {
                // attach
                $categories_top = Category::find($request->input('categories_top'));
                $partObj->categories()->attach($categories_top);
            }
            if ($request->has('categories_sub')) {
                // attach
                $categories_sub = Category::find($request->input('categories_sub'));
                $partObj->categories()->attach($categories_sub);
            }
            if ($request->has('categories_sub_sub')) {
                // attach
                $categories_sub_sub = Category::find($request->input('categories_sub_sub'));
                $partObj->categories()->attach($categories_sub_sub);
            }

            // save images
            $this->save_images($partObj->id, $request);
            // save manual
            $this->save_manuals($partObj->id, $request);

        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Part Saved.');
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
            'sku' => $request->input('sku'),
            'model_no' => $request->has('model_no') && $request->input('model_no') != null ? $request->input('model_no') : '',
            'item_no' => $request->has('item_number') && $request->input('item_number') != null ? $request->input('item_number') : '',
            'year' => $request->input('year'),
            'note' => $request->input('note'),
            'short_description' => $request->input('short_description'),
            'long_description' => $request->input('long_description'),
            'features' => $request->input('features'),
            'price' => $request->has('price') && $request->input('price') != null ? $request->input('price') : 0,
            'retail_price' => $request->has('retail_price') && $request->input('retail_price') != null ? $request->input('retail_price') : 0,
            'cost' => $request->has('cost') && $request->input('cost') != null ? $request->input('cost') : 0,
            'stock' => $request->has('stock') && $request->input('stock') != null ? $request->input('stock') : 0,
            'weight' => $request->has('weight') && $request->input('weight') != null ? $request->input('weight') : 0,
            'created_by' => Auth::id(),
            'length_1' => $request->input('length_1'),
            'length_2' => $request->input('length_2'),
            'height_1' => $request->input('height_1'),
            'height_2' => $request->input('height_2'),
            'width_1' => $request->input('width_1'),
            'width_2' => $request->input('width_2'),
            'diameter_1' => $request->input('diameter_1'),
            'diameter_2' => $request->input('diameter_2'),
            'show_on_grillpartsgallery_com' => $request->input('show_on_grillpartsgallery_com'),
            'show_on_bbqpartsfactory_com' => $request->input('show_on_bbqpartsfactory_com'),
            'show_on_bbqpartszone_com' => $request->input('show_on_bbqpartszone_com'),
            'is_active' => $request->input('status'),
            'meta_title' => $request->input('meta_title'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
        ];
    }

    /**
     * @param $slug
     * @param string $recordId
     * @return string
     */
    protected function chkDuplicateSlug($slug, $recordId = '')
    {
        if ($recordId != '') {
            if (Part::where('slug', $slug)->where('id', '<>', $recordId)->exists()) {
                // 2. update slug by adding -2
                $slgName = Part::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        } else {
            if (Part::where('slug', $slug)->exists()) {
                // 2. update slug by adding -2
                $slgName = Part::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        }
        return $slug;
    }

    /**
     * @param $slug
     * @param $ext
     * @param string $recordId
     * @return string
     */
    protected function chkDuplicateImgName($slug, $ext)
    {
        if (PartsImage::where('image', 'like', '%' . $slug . '%')->exists()) {
            // 2. update slug by adding -2
            $slgName = PartsImage::where('image', 'like', '%' . $slug . '%')->count();
            $slug .= "-" . ($slgName + 1);
        }
        return $slug;
    }

    /**
     * @param int $partId
     * @param object $request
     */
    protected function save_images(int $partId, object $request)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $originalImage = $img;
                $imgExt = $originalImage->getClientOriginalExtension();
                $imgSlug = $this->chkDuplicateImgName(slugifyText($request->input('name')), $imgExt);
                $fileName = $imgSlug . "." . $imgExt;
                // save image
                $partImg = new PartsImage();
                $partImg->part_id = $partId;
                $partImg->image = $fileName;
                $partImg->save();
                Storage::disk('s3')->put($this->s3_part_images_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
            }
        }
    }

    /**
     * @param int $partId
     * @param object $request
     */
    protected function save_manuals(int $partId, object $request)
    {
        if ($request->hasFile('manual')) {
            // remove if already exists
            $partDocs = PartsManual::where('part_id', $partId)->get();
            if ($partDocs != null) {
                foreach ($partDocs as $partDoc) {
                    if (Storage::disk('s3')->exists($this->s3_part_manuals_folder . '/' . $partDoc->document)) {
                        Storage::disk('s3')->delete($this->s3_part_manuals_folder . '/' . $partDoc->document);
                    }
                    // remove record from db
                    $partDoc->delete();
                }
            }

            $originalDoc = $request->file('manual');
            $docExt = $request->manual->getClientOriginalExtension();
            $docSlug = $this->chkDuplicateImgName(slugifyText($request->input('name')), $docExt);
            $fileName = $docSlug . "." . $docExt;
            // save image
            $partMan = new PartsManual();
            $partMan->part_id = $partId;
            $partMan->document = $fileName;
            $partMan->save();
            Storage::disk('s3')->put($this->s3_part_manuals_folder . '/' . $fileName, file_get_contents($originalDoc), 'public');
        }
    }

    /**
     * @param object $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePartImage(object $request)
    {
        if ($request->has('payload')) {
            $payload = explode("-", $request->input('payload'));
            $image_id = $payload[1];
            $partImg = PartsImage::find($image_id);
            if (Storage::disk('s3')->exists($this->s3_part_images_folder . '/' . $partImg->image)) {
                Storage::disk('s3')->delete($this->s3_part_images_folder . '/' . $partImg->image);
            }
            // remove record from db
            $partImg->delete();
            return response()->json(['success' => 'Image removed.']);
        }
        return response()->json(['error' => 'Some issue while deleting part image.']);
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function removePartManual(object $request)
    {
        if ($request->has('payload')) {
            $payload = explode("-", $request->input('payload'));
            $id = $payload[1];
            $partDoc = PartsManual::find($id);
            if (Storage::disk('s3')->exists($this->s3_part_manuals_folder . '/' . $partDoc->document)) {
                Storage::disk('s3')->delete($this->s3_part_manuals_folder . '/' . $partDoc->document);
            }
            // remove record from db
            $partDoc->delete();
            return response()->json(['success' => 'Manual removed.']);
        }
        return response()->json(['error' => 'Some issue while deleting part manual.']);
    }

    /**
     * @param string $value
     * @param string $cat_name
     * @return mixed
     */
    public function getPartsByCategory(string $value, string $cat_name)
    {
        if ($value != '' && $cat_name != '') {
            $cat_access = Category::where('name', $cat_name)->first(['id']);
            return Part::getCategoryRecords([$cat_access->id])
                ->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('model_no', 'like', '%' . $value . '%');
                })
                ->where('is_active', 1)
                ->get(['id', 'name', 'slug', 'model_no']);
        }
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function getPartsForAddModelPage(object $request)
    {
        $pid = $request->has('pid') ? $request->input('pid') : '';
        $type = $request->has('type') ? $request->input('type') : "part";
        $action = $request->has('action') ? $request->input('action') : "add";
        $model_id = $request->has('model_id') ? $request->input('model_id') : "";
        // define session keys
        if($model_id != '' && ProductModel::where('id', $model_id)->exists()) {
            $sessionKeyPartAssign = 'edit_assign_part_session_'.$model_id;
        } else {
            $sessionKeyPartAssign = 'add_assign_part_session';
        }
        // set parts in sessions
        if(Session::has($sessionKeyPartAssign)) {
            if(count(Session::get($sessionKeyPartAssign)) == 0) {
                Session::forget($sessionKeyPartAssign);
            }
        }
        if($action == 'add') {
            $add_assign_part_session = Session::get($sessionKeyPartAssign);
            if ($add_assign_part_session != null) {
                if(!in_array($pid, $add_assign_part_session)) {
                    $add_assign_part_session[] = $pid;
                }
            } else {
                $add_assign_part_session[] = $pid;
            }
            Session::put($sessionKeyPartAssign, $add_assign_part_session);

        } elseif ($action == 'remove') {
            $add_assign_part_session = Session::get($sessionKeyPartAssign);
            if (($key = array_search($pid, $add_assign_part_session )) !== false) {
                unset($add_assign_part_session[$key]);
            }
            Session::put($sessionKeyPartAssign, $add_assign_part_session);
        } elseif ($action == 'moveup') {
            $add_assign_part_session = Session::get($sessionKeyPartAssign);
            $key = array_search($pid, $add_assign_part_session );
            if($key > 0) {
                $item = $add_assign_part_session[$key];
                $add_assign_part_session[$key] = $add_assign_part_session[$key - 1];
                $add_assign_part_session[$key - 1] = $item;
            }
            Session::put($sessionKeyPartAssign, $add_assign_part_session);
        } elseif ($action == 'movedown') {
            $add_assign_part_session = Session::get($sessionKeyPartAssign);
            $key = array_search($pid, $add_assign_part_session );
            $lastKey = key(array_slice($add_assign_part_session, -1, 1, true));
            if($key < $lastKey) {
                $item = $add_assign_part_session[$key];
                $add_assign_part_session[$key] = $add_assign_part_session[$key + 1];
                $add_assign_part_session[$key + 1] = $item;
            }
            Session::put($sessionKeyPartAssign, $add_assign_part_session);
        }

        $partsArray = Session::get($sessionKeyPartAssign);

        if(count($partsArray) > 0) {
            $arryResult = [];
            foreach ($partsArray as $key => $partId) {
                $partObj = Part::find($partId);
                $arryResult[$key]['id'] = $partObj->id;
                $arryResult[$key]['model_no'] = $partObj->model_no;
                $arryResult[$key]['name'] = $partObj->name;
            }
            return $arryResult;
        }
    }



    public function getBransNModelsArray($record)
    {
        $associtedBrands = [];
        $brnd_arry = [];
        $mld_arry = [];
        $i = 0;

        $brands = Brand::orderBy('brand', 'ASC')->get();
        foreach ($brands as $brand) {
            foreach ($record->models as $model) {
                if($model->brand->id == $brand->id && !in_array($brand->id, $associtedBrands)) {
                    $associtedBrands[$i]['brand_id'] = $model->brand->id;
                    $associtedBrands[$i]['model_name'] = $model->name;
                    $i++;
                    $brnd_arry[] = $model->brand->id;
                    $mld_arry[] = $model->id;
                }
            }
        }

        $uniq_brands = array_unique($brnd_arry);

        $j = 0;
        $mdls_arrry = [];
        foreach ($uniq_brands as $key => $brnd) {
            $brandObj = Brand::where('id', $brnd)->first(['id', 'brand', 'slug']);
            $mdls_arrry[$j]['brand'] = $brandObj->brand;
            $mdls_arrry[$j]['link'] = $brandObj->getLink();
            $mdls_arrry[$j]['models'] = [];

            $k = 0;
            $htmlArry = [];
            foreach ($brandObj->models as $model) {
                if(in_array($model->id, $mld_arry)) {
                    $htmlArry[$k]['id'] = $model->id;
                    $htmlArry[$k]['name'] = $model->name;
                    $htmlArry[$k]['model_number'] = $model->model_number;
                    $htmlArry[$k]['link'] = $model->getLink();
                    $k++;
                }
            }
            array_push($mdls_arrry[$j]['models'], $htmlArry);
            $j++;
        }
        return $mdls_arrry;
    }

    public function doAssignModel(object $request)
    {
        $part_id = $request->has('part_id') ? $request->input('part_id') : '';
        $action = $request->has('action') ? $request->input('action') : '';
        $model_id = $request->has('model_id') ? $request->input('model_id') : '';

        $checkExists = ModelsPartsRelation::where('model_id', $model_id)->where('part_id', $part_id)->exists();

        if($action == 'add') {
            if(!$checkExists) {
                $order_num = ModelsPartsRelation::where('model_id', $model_id)->count();
                ModelsPartsRelation::create(
                    ['model_id' => $model_id, 'part_id' => $part_id, 'ordernum' => $order_num+1]
                );
            }
        } elseif($action == 'remove') {
            if($checkExists) {
                ModelsPartsRelation::where('model_id', $model_id)->where('part_id', $part_id)->delete();
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function make_copy($id)
    {
        $copyRecord = Part::find($id);

        $slug = $this->chkDuplicateSlug($copyRecord->slug);

        $arrayToInsert = [
            'name' => $copyRecord->name,
            'slug' => $slug,
            'sku' => $copyRecord->sku,
            'model_no' => $copyRecord->model_no,
            'item_no' => $copyRecord->item_number,
            'year' => $copyRecord->year,
            'note' => $copyRecord->note,
            'short_description' => $copyRecord->short_description,
            'long_description' => $copyRecord->long_description,
            'features' => $copyRecord->features,
            'price' => $copyRecord->price,
            'retail_price' => $copyRecord->retail_price,
            'cost' => $copyRecord->cost,
            'stock' => $copyRecord->stock,
            'weight' => $copyRecord->weight,
            'created_by' => Auth::id(),
            'length_1' => $copyRecord->length_1,
            'length_2' => $copyRecord->length_2,
            'height_1' => $copyRecord->height_1,
            'height_2' => $copyRecord->height_2,
            'width_1' => $copyRecord->width_1,
            'width_2' => $copyRecord->width_2,
            'diameter_1' => $copyRecord->diameter_1,
            'diameter_2' => $copyRecord->diameter_2,
            'show_on_grillpartsgallery_com' => $copyRecord->show_on_grillpartsgallery_com,
            'show_on_bbqpartsfactory_com' => $copyRecord->show_on_bbqpartsfactory_com,
            'show_on_bbqpartszone_com' => $copyRecord->show_on_bbqpartszone_com,
            'is_active' => $copyRecord->is_active
        ];

        // save model data
        try {
            $pMdlObj = Part::create($arrayToInsert);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->route('edit-part', ['id' => $pMdlObj->id])->withSuccess('Part Copied.');
    }

    public function getAssociatedModels($id)
    {
        $partObj = Part::find($id);
        $part_models_array = [];
        if($partObj->models != null) {
            foreach ($partObj->models as $modObj) {
                $part_models_array[] = $modObj->id;
            }
        }
        return $part_models_array;
    }

    public function savePartInViewedReturn(int $part_id, int $model_id)
    {
        $viewed_parts = session()->get('viewed_parts');
        if(session()->has('viewed_parts')) {
            if(count($viewed_parts) >= 5) {
                // remove item that is having low time stamp
                $lowest_time = time();
                foreach ($viewed_parts as $partKey => $partItm) {
                    if($partItm['time'] < $lowest_time) {
                        $lowest_time = $partItm['time'];
                        $keyRemove = $partKey;
                    }
                }
                unset($viewed_parts[$keyRemove]);
            }
        }
        $viewed_parts[$part_id]['model_id'] = $model_id;
        $viewed_parts[$part_id]['time'] = time();
        session()->put('viewed_parts', $viewed_parts);
    }

    public function showViewedParts(int $part_id = 0)
    {
        $latest_viewed_parts = session()->get('viewed_parts');
        $viewedPartsArry = [];
        $i = 0;
        if(session()->has('cart_items')) {
            foreach ($latest_viewed_parts as $partKey => $partVal) {
                if ($part_id == 0 && $i == 3) return;
                if ($partKey != $part_id) {
                    $partObj = Part::find($partKey);
                    $modelObj = ProductModel::find($partVal['model_id']);
                    $brandObj = Brand::find($modelObj->brand_id);
                    $viewedPartsArry[$i]['part_id'] = $partObj->id;
                    $viewedPartsArry[$i]['part_slug'] = $partObj->slug;
                    $viewedPartsArry[$i]['part_name'] = $partObj->name;
                    $viewedPartsArry[$i]['part_image'] = $partObj->getSingleImg();
                    $viewedPartsArry[$i]['part_link'] = route('part', ['brandSlug' => $brandObj->slug, 'slug' => $partObj->slug]); //'modelSlug' => $modelObj->slug,
                    $viewedPartsArry[$i]['short_description'] = showReadMore($partObj->short_description, 60, '', false);
                    $viewedPartsArry[$i]['price'] = $partObj->price;
                    $viewedPartsArry[$i]['retail_price'] = $partObj->retail_price;

                    $i++;
                }
            }
        }
        return $viewedPartsArry;
    }
}
