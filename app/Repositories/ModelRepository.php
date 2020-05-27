<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\CategoriesPartsRelation;
use App\Models\Category;
use App\Models\ModelsPartsRelation;
use App\Models\Part;
use App\Models\ProductModel;
use App\Models\TempPart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

/**
 * Class ModelRepository
 * @package App\Repositories
 */
class ModelRepository
{
    /**
     * @var BrandRepository
     */
    protected $brandRepo;
    protected $s3_model_folder;

    /**
     * ModelRepository constructor.
     * @param BrandRepository $brandRepo
     */
    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->s3_model_folder = config('constants.MODEL_IMAGES_S3_FOLDER');
    }

    /**
     * @param string $type
     * @param $value
     * @return mixed
     */
    public function getModelBy(string $type = 'id', $value)
    {
        return ProductModel::where($type, $value)->first();
    }

    public function getIdByBrandid(string $type = 'id', $value, $brand_slug)
    {
        $modelArr= ProductModel::where($type, $value)->get(['id','sku','slug','name']);
        //$modArr=array();
        $res='';
        foreach($modelArr as $modVal) {
            $associatedParts = ModelsPartsRelation::where('model_id', $modVal->id)->count();
            if($associatedParts>0) {
                //$modArr[$modVal->sku]=$associatedParts;
                $res.='<a class="list-group-item" href="'. route('brands-model',['brandSlug' => $brand_slug, 'slug' => $modVal->slug]) .'">' . $modVal->name . '('. $associatedParts .')' . '</a>';
            }
        }
        return $res;
    }


    public function getIdByBrandidCategoryid(string $type = 'id', $value, $brand_slug,$cat_id)
    {
        $modelArr= ProductModel::where($type, $value)->get(['id','sku','slug','name']);
        $partArr=CategoriesPartsRelation::where('category_id',$cat_id)->get('part_id');
        $cat_obj=Category::find($cat_id);
        //$modArr=array();
        $res='';
        foreach($modelArr as $modVal) {
            $associatedParts = ModelsPartsRelation::where('model_id', $modVal->id)->whereIn('part_id',$partArr)->count();
            if($associatedParts>0) {
                //$modArr[$modVal->sku]=$associatedParts;
                $res.='<a class="list-group-item" href="'. route('brands-category',['brandSlug' => $brand_slug, 'categorySlug' => $cat_obj->slug, 'slug' => $modVal->slug]) .'">' . $modVal->name . '('. $associatedParts .')' . '</a>';
            }
        }
        return $res;
    }

    public function getModelParts(int $per_page = 6, object $model, int $category_id = 0)
    {
        if($category_id == 0) {
            return $parts = $model->parts()->paginate($per_page);
        } else {
            return $parts = Part::getPartWithModelCategory($model->id, $category_id)->paginate($per_page);
        }
    }

    public function getPartsModelCategory(int $model_id)
    {
        $catArray = [];
        $i = 0;
        foreach (Category::all() as $key => $category) {
            $partsCount = Part::getPartWithModelCategory($model_id, $category->id)->count();
            if($partsCount > 0 && $category->highercategoryid != 0) {
                $catArray[$i]['id'] = $category->id;
                $catArray[$i]['name'] = $category->name;
                $catArray[$i]['slug'] = $category->slug;
                $catArray[$i]['total'] = $partsCount;
                $i++;
            }
        }
        return $catArray;
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function getRecords($ids = '')
    {
        if ($ids != "") {
            return ProductModel::find($ids);
        } else {
            return ProductModel::whereIn('status', [0, 1]);
        }
    }

    /**
     * Get's a model by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return ProductModel::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return ProductModel::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        $record = ProductModel::find($id);
        // check image is already exists and delete it
        if (Storage::disk('s3')->exists($this->s3_model_folder . '/' . $record->image)) {
            Storage::disk('s3')->delete($this->s3_model_folder . '/' . $record->image);
        }
        ProductModel::destroy($id);
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
     * Get's all status records.
     *
     * @param int $status
     * @return mixed
     */
    public function allStatus($status = 1)
    {
        return ProductModel::where('status', $status)->get(['id', 'name']);
    }

    /**
     * Updates a record.
     *
     * @param int
     * @param array
     * @return
     */
    public function update(object $request)
    {
        $recordId = $request->input('id');
        $oldRecord = ProductModel::find($recordId);
        // check and retrieve id of brand
        $getBrandInfo = $this->brandRepo->getOrAddBy('brand', $request->input('brand'));
        // check record exits
        if (!ProductModel::where('id', $recordId)->exists()) {
            return redirect()->back()->withError('Record not exist.');
        }
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('slug')), $recordId);
        // save data
        try {
            $prePareArry = $this->prepare_data_array($slug, $getBrandInfo, $request);
            ProductModel::where('id', $recordId)->update($prePareArry);
            // save associated parts
            $this->saveAssociatedParts($request, $recordId);
            // save image
            $this->save_image($oldRecord, $getBrandInfo, $request);

        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Model Saved.');
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function add(object $request)
    {
        // check and retrieve id of brand
        $getBrandInfo = $this->brandRepo->getOrAddBy('brand', $request->input('brand'));
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyModel($getBrandInfo->brand) . '-' . slugifyText($request->input('model_number')));
        // save model data
        try {
            $prePareArry = $this->prepare_data_array($slug, $getBrandInfo, $request);
            $pMdlObj = ProductModel::create($prePareArry);
            // save associated parts
            $this->saveAssociatedParts($request, $pMdlObj->id);
            // save image
            $this->save_image($pMdlObj, $getBrandInfo, $request);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Model Saved.');
    }

    protected function saveAssociatedParts(object $request, int $model_id)
    {
        $parts = $request->has('hideparts') ? explode(',', $request->input('hideparts')) : [];
        // remove already associated parts
        if(ModelsPartsRelation::where('model_id', $model_id)->exists()) {
            ModelsPartsRelation::where('model_id', $model_id)->delete();
        }
        // reassign
        if ($request->input('hideparts') != null && count($parts) > 0) {
            $j = 1;
            foreach ($parts as $single_part) {
                ModelsPartsRelation::create(
                    ['model_id' => $model_id, 'part_id' => $single_part, 'ordernum' => $j]
                );
                $j++;
            }
        }
    }

    /**
     * @param object $pMdlObj
     * @param object $getBrandInfo
     * @param object $request
     */
    protected function save_image(object $pMdlObj, object $getBrandInfo, object $request)
    {
        // save image
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($pMdlObj->image != '') {
                if (Storage::disk('s3')->exists($this->s3_model_folder . '/' . $pMdlObj->image)) {
                    Storage::disk('s3')->delete($this->s3_model_folder . '/' . $pMdlObj->image);
                }
            }
            // save new image
            $originalImage = $request->file('image');
            $imgExt = $request->image->getClientOriginalExtension();
            $imgSlug = $this->chkDuplicateImgName(slugifyModel($getBrandInfo->brand) . '-' . slugifyText($request->input('model_number')), $imgExt);
            $fileName = $imgSlug . "." . $imgExt;
            $pMdlObj->image = $fileName;
            $pMdlObj->save();
            Storage::disk('s3')->put($this->s3_model_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
        }
    }

    /**
     * @param string $slug
     * @param object $getBrandInfo
     * @param object $request
     * @return array
     */
    protected function prepare_data_array(string $slug, object $getBrandInfo, object $request)
    {
        return [
            'name' => $request->input('name'),
            'slug' => $slug,
            'brand_id' => $getBrandInfo->id,
            'model_number' => $request->input('model_number'),
            'item_number' => $request->input('item_number'),
            'sku' => $request->input('sku'),
            'year' => $request->input('year'),
            'note' => $request->input('note'),
            'short_description' => $request->input('short_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
            'status' => $request->input('status')
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
            if (ProductModel::where('slug', $slug)->where('id', '<>', $recordId)->exists()) {
                // 2. update slug by adding -2
                $slgName = ProductModel::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        } else {
            if (ProductModel::where('slug', $slug)->exists()) {
                // 2. update slug by adding -2
                $slgName = ProductModel::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        }
        return $slug;
    }

    /**
     * @param $slug
     * @param $ext
     * @return string
     */
    protected function chkDuplicateImgName($slug, $ext)
    {
        if (ProductModel::where('image', $slug . '.' . $ext)->exists()) {
            // 2. update slug by adding -2
            $slgName = ProductModel::where('image', 'like', '%' . $slug . '%')->count();
            $slug .= "-" . ($slgName + 1);
        }
        return $slug;
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
            $Img = ProductModel::find($recordId);
            if (Storage::disk('s3')->exists($this->s3_model_folder . '/' . $Img->image)) {
                Storage::disk('s3')->delete($this->s3_model_folder . '/' . $Img->image);
            }
            // remove record from db
            $Img->image = '';
            $Img->save();
            return response()->json(['success' => 'Image removed.']);
        }
        return response()->json(['error' => 'Some issue while deleting image.']);
    }

    /**
     * @param int $recordId
     * @return array
     */
    public function getAssociatedParts(int $recordId)
    {
        $associategParts = ModelsPartsRelation::where('model_id', $recordId)
            ->get();
        $partIds = [];
        if ($associategParts != null) {
            $k = 0;
            $part_ids = '';
            foreach ($associategParts as $key => $relObj) {
                $partObj = Part::find($relObj->part_id);
                if(!is_null($partObj)) {
                    $partIds[$k]['id'] = $partObj->id;
                    $partIds[$k]['model_no'] = $partObj->model_no;
                    $partIds[$k]['name'] = $partObj->name;
                    $part_ids .= $partObj->id . ',';
                    $k++;
                }
            }
            return [
                'results' => [
                    'parts' => $partIds,
                    'part_ids' => rtrim($part_ids, ',')
                ]
            ];
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function make_copy($id)
    {
        $copyRecord = ProductModel::find($id);

        $slug = $this->chkDuplicateSlug($copyRecord->slug);

        $arrayToInsert = [
            'name' => $copyRecord->name,
            'slug' => $slug,
            'brand_id' => $copyRecord->brand_id,
            'model_number' => $copyRecord->model_number,
            'item_number' => $copyRecord->item_number,
            'sku' => $copyRecord->sku,
            'year' => $copyRecord->year,
            'note' => $copyRecord->note,
            'short_description' => $copyRecord->short_description,
            'status' => $copyRecord->status
        ];

        // save model data
        try {
            $pMdlObj = ProductModel::create($arrayToInsert);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->route('edit-model', ['id' => $pMdlObj->id])->withSuccess('Model Copied.');
    }


    /**
     *@param
     * @this is models parts association code for database. we will delete it later
     *@return
     */
    public function parts_model_association(PartRepository $partRepo,$start,$end)
    {


        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=parts.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

// 1. parts: name, sku, model_no, price
        $parts= Part::select('name', 'sku', 'model_no', 'price','id','slug')->where('id','>=',$start)->where('id','<=',$end)->get();
        $partArr=array();
        try {
            foreach ($parts as $part) {
                $partArr[$part->id]['id'] = $part->id;
                $partArr[$part->id]['name'] = $part->name;
                $partArr[$part->id]['sku'] = $part->sku;
                $partArr[$part->id]['model_no'] = $part->model_no;
                $partArr[$part->id]['price'] = $part->price;

                $partImgArr=array();
                if (count($part->parts_images) > 0) {
                    foreach ($part->parts_images as $image) {
                        array_push($partImgArr,'http://www.bbqpartszone.com/grillparts/'.$image->image);
                    }
                }



                $partArr[$part->id]['parts_images']=implode(',',$partImgArr);

                $partDetails = $partRepo->getPartBy('slug', $part->slug);
                $associatedModels=$partRepo->getBransNModelsArray($partDetails);
                $fitcompatible='';
                if(count($associatedModels) > 0) {
                    foreach($associatedModels as $branModels) {
                        $fitcompatible.=$branModels['brand'].": ";

                        if(count($branModels['models']) > 0) {
                            foreach($branModels['models'][0] as $keyModel => $modelSingle) {
                                $fitcompatible.=$modelSingle['model_number'];
                                if ($keyModel != count($branModels['models'][0]) - 1) {
                                    $fitcompatible.=', ';
                                }
                            }
                        }
                        $fitcompatible.='<br>';

                    }
                }
                $partArr[$part->id]['fit_compatible_models']= $fitcompatible;



            }

            //print_r($partArr);
//            $callback = function() use ($partArr) {
//                $FH = fopen('php://output', 'w');
//                foreach ($partArr as $row) {
//                    fputcsv($FH, $row);
//                }
//                fclose($FH);
//            };
//
//            return Response::stream($callback, 200, $headers);

            foreach ($partArr as $partArrRec){
                $prePareArry=[
                    'name' => $partArrRec['name'],
                    'part_id' => $partArrRec['id'],
                    'sku' => $partArrRec['sku'],
                    'model_no' => $partArrRec['model_no'],
                    'price' => $partArrRec['price'],
                    'parts_images' => $partArrRec['parts_images'],
                    'fit_compatible_models' => $partArrRec['fit_compatible_models'],
                ];

                $brandObj = TempPart::create($prePareArry);
            }


        } catch (\Exception $e) {
            echo $e->getMessage();
        }


        ///////////////////////////////////////////////////////////////////////////////////////

//        $parts= Part::select('id','catalogid')->whereIn('id',['1229','1228','1224','1218','1221','1220','1226','1219','1227'])->get();
//        try {
//            foreach ($parts as $part) {
//                ModelsPartsRelation::where('old_part_id', $part->catalogid)->update(['part_id' => $part->id, "updated_at" => date('Y-m-d')]);
//            }
//
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }




//        $allModels=ProductModel::select('id','parting_todelete')->where('id','>',25426)->orderBy('id')->get();
//        try {
//
//            foreach ($allModels as $allModel) {
//                $model_id=$allModel->id;
//                if(isset($allModel->parting_todelete) && $allModel->parting_todelete!='') {
//                    $parts = explode(',', $allModel->parting_todelete);
//                    $j = 1;
//                    foreach ($parts as $single_part) {
//                        ModelsPartsRelation::create(
//                            ['model_id' => $model_id, 'part_id' => $single_part, 'ordernum' => $j]
//                        );
//                        $j++;
//                    }
//                }
//            }
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }


        echo "association done";
    }
}
