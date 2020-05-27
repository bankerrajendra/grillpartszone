<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

/**
 * Class BrandRepository
 * @package App\Repositories
 */
class BrandRepository
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $s3_brand_folder;

    /**
     * BrandRepository constructor.
     */
    public function __construct()
    {
        $this->s3_brand_folder = config('constants.BRAND_IMAGES_S3_FOLDER');
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function getRecords($ids = '')
    {
        if ($ids != "") {
            return Brand::find($ids);
        } else {
            return Brand::where('id', '>', 0);
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
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Brand::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Brand::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        $record = Brand::find($id);
        // check image is already exists and delete it
        if (Storage::disk('s3')->exists($this->s3_brand_folder . '/' . $record->image)) {
            Storage::disk('s3')->delete($this->s3_brand_folder . '/' . $record->image);
        }
        Brand::destroy($id);
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function update(object $request)
    {
        $recordId = $request->input('id');
        $oldRecord = Brand::find($recordId);
        // check record exits
        if (!Brand::where('id', $recordId)->exists()) {
            return redirect()->back()->withError('Brand not exist.');
        }
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('brand')), $recordId);
        // save data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            $catObj = Brand::where('id', $recordId)->update($prePareArry);

            // save image
            if ($request->hasFile('image')) {
                // check image is already exists and delete it
                if (Storage::disk('s3')->exists($this->s3_brand_folder . '/' . $oldRecord->image)) {
                    Storage::disk('s3')->delete($this->s3_brand_folder . '/' . $oldRecord->image);
                }
                $originalImage = $request->file('image');
                $imgExt = $originalImage->getClientOriginalExtension();
                $imgSlug = $this->chkDuplicateImgName(slugifyText($request->input('brand')), $imgExt);
                $fileName = $imgSlug . "." . $imgExt;
                $oldRecord->image = $fileName;
                $oldRecord->save();
                Storage::disk('s3')->put($this->s3_brand_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Brand Saved.');
    }

    public function add(object $request)
    {
        // check out the slug
        $slug = $this->chkDuplicateSlug(slugifyText($request->input('brand')));
        // save model data
        try {
            $prePareArry = $this->prepare_data_array($slug, $request);
            $brandObj = Brand::create($prePareArry);

            // save image
            if ($request->hasFile('image')) {
                $originalImage = $request->file('image');
                $imgExt = $originalImage->getClientOriginalExtension();
                $imgSlug = $this->chkDuplicateImgName(slugifyText($request->input('brand')), $imgExt);
                $fileName = $imgSlug . "." . $imgExt;
                $brandObj->image = $fileName;
                $brandObj->save();
                Storage::disk('s3')->put($this->s3_brand_folder . '/' . $fileName, file_get_contents($originalImage), 'public');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        return redirect()->back()->withSuccess('Brand Saved.');
    }

    /**
     * @param string $slug
     * @param object $request
     * @return array
     */
    protected function prepare_data_array(string $slug, object $request)
    {
        $chr = strtoupper($request->input('brand')[0]);
        return [
            'brand' => $request->input('brand'),
            'chr' => $chr,
            'slug' => $slug,
            'description' => $request->input('description'),
            'model_description' => $request->input('model_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
        ];
    }

    /**
     * @param $slug
     * @param $ext
     * @return string
     */
    protected function chkDuplicateImgName($slug, $ext)
    {
        if (Brand::where('image', $slug . '.' . $ext)->exists()) {
            // 2. update slug by adding -2
            $slgName = Brand::where('image', 'like', '%' . $slug . '%')->count();
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
            if (Brand::where('slug', $slug)->where('id', '<>', $recordId)->exists()) {
                // 2. update slug by adding -2
                $slgName = Brand::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        } else {
            if (Brand::where('slug', $slug)->exists()) {
                // 2. update slug by adding -2
                $slgName = Brand::where('slug', 'like', '%' . $slug . '%')->count();
                $slug .= "-" . ($slgName + 1);
            }
        }
        return $slug;
    }

    /**
     * @param string $type
     * @param $value
     * @return mixed
     */
    public function getOrAddBy(string $type = 'brand', $value)
    {
        if (Brand::where($type, '=', $value)->exists()) {
            $brandObj = Brand::where($type, '=', $value)->first();
        } else {
            $chr = strtoupper($value[0]);
            $brandObj = Brand::create([
                'chr' => $chr,
                'brand' => $value
            ]);
        }
        return $brandObj;
    }

    /**
     * @return array
     */
    public function getAssociatedModels()
    {
        $allBrands = Brand::orderBy('brand', 'ASC')->get();
        $availableModels = [];
        foreach ($allBrands as $brand) {
            $availableModels[$brand->brand] = $brand->models()
                                                    ->where('status', 1)
                                                    ->get([
                                                        'id',
                                                        'brand_id',
                                                        'name',
                                                        'slug',
                                                        'model_number'
                                                    ]);
        }
        return $availableModels;
    }

    public function getBrandBy(string $type = 'id', $value)
    {
        return Brand::where($type, $value)->first();
    }

    public function getBrandAssociatedModelsBy(string $type = 'id', $value)
    {
        $brandObj = Brand::where($type, $value)->first();
        $records = [];
        $alpha = 'A'; //range('A', 'Z');
       // $i = 0;
        //foreach ($alphas as $alpha) {
            $alphaRecords = $brandObj->models()->where('status', 1)->orderBy('name')->get(['id', 'slug', 'name','model_number']); //->where('name', 'like', $alpha . '%')
            if($alphaRecords != null) {
                $j = 0;
                foreach ($alphaRecords as $alphaRecord) {
                    $records[$alpha][$j]['id'] = $alphaRecord->id;
                    $records[$alpha][$j]['slug'] = $alphaRecord->slug;
                    $records[$alpha][$j]['name'] = $alphaRecord->name;
                    $records[$alpha][$j]['model_number'] = $alphaRecord->model_number;
                    $j++;
                }
            }
          //  $i++;
        //}
        return $records;
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
            $Img = Brand::find($recordId);
            if (Storage::disk('s3')->exists($this->s3_brand_folder . '/' . $Img->image)) {
                Storage::disk('s3')->delete($this->s3_brand_folder . '/' . $Img->image);
            }
            // remove record from db
            $Img->image = '';
            $Img->save();
            return response()->json(['success' => 'Image removed.']);
        }
        return response()->json(['error' => 'Some issue while deleting image.']);
    }

    public function getBrandBySortAlpha()
    {
        $records = [];
        //$alphas = range('A', 'Z');
        //$i = 0;
        //foreach ($alphas as $alpha) {
            $alphaRecords = Brand::where('slug','<>','grill-accessories')->where('slug','<>','propane-parts')->orderBy('brand', 'ASC')->get(['id', 'chr', 'slug', 'brand']); //where('brand', 'like', $alpha . '%')
            if($alphaRecords != null) {
                $j = 0;
                foreach ($alphaRecords as $alphaRecord) {
                    $records[$alphaRecord->chr][$j]['id'] = $alphaRecord->id;
                    $records[$alphaRecord->chr][$j]['slug'] = $alphaRecord->slug;
                    $records[$alphaRecord->chr][$j]['chr'] = $alphaRecord->chr;
                    $records[$alphaRecord->chr][$j]['brand'] = $alphaRecord->brand;
                    $j++;
                }
            }
            //$i++;
        //}
        return $records;
    }

    public function slugAddToExistings()
    {
        $all_brands = Brand::all();
        foreach ($all_brands as $brand) {
            $slug = $this->chkDuplicateSlug(slugifyText($brand->brand), $brand->id);
            Brand::where('id', $brand->id)->update(['slug' => $slug]);
        }
    }
}
