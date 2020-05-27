<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\PartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use JsValidator;
use App\Repositories\ModelRepository;
use App\Repositories\BrandRepository;

/**
 * Class ModelController
 * @package App\Http\Controllers
 */
class ModelController extends Controller
{
    /**
     * @var array
     */
    protected $validationAddModel = [
        'name' => 'required|max:255',
        'meta_description' => 'required|min:50',
        'model_number' => 'required|unique:models|max:255',
        'sku' => 'required|unique:models|max:255',
        'brand' => 'required|max:255',
        'image' => 'sometimes|mimes:jpg,jpeg,gif,bmp,png'
    ];
    /**
     * @var array
     */
    protected $validStringAddModel = [
        'name.required' => 'The title field is required.'
    ];
    /**
     * @var ModelRepository
     */
    protected $modelRepo, $brandRepo,$partRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelRepository $modelRepo, BrandRepository $brandRepo, PartRepository $partRepo)
    {
        $this->modelRepo = $modelRepo;
        $this->brandRepo = $brandRepo;
        $this->partRepo=$partRepo;
        
    }

    /**
     * @param $brandSlug
     * @param $slug
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function showModel($brandSlug, $slug, $categorySlug='', Request $request)
    {
        //$category = $request->has('category') ? $request->input('category') : 0;
        $category=($categorySlug!='')?(getCatId($categorySlug)):0;
        $brand_info = $this->brandRepo->getBrandBy('slug', $brandSlug);
        $model_info = $this->modelRepo->getModelBy('slug', $slug);

        $meta_fields['title']=$model_info->meta_title;
        $meta_fields['keyword']=$model_info->meta_keywords;
        $meta_fields['description']=$model_info->meta_description;

        // get parts associated with models
        $per_page = 24;
        $results = $this->modelRepo->getModelParts($per_page, $model_info, $category);
        if($request->ajax()) {
            if($results->nextPageUrl() != "") {
                $nextPageUrl = $results->nextPageUrl();
            } else {
                $nextPageUrl = '';
            }
            return [
                'parts' => view('front.pages.includes.brand-models-parts', [
                        'parts' => $results, 'modelInfo' => $model_info,
                        'brandInfo' => $brand_info]
                )->render(),
                'metafields'=>$meta_fields,
                'next_page' => $nextPageUrl,
                'total_records' => $results->total()
            ];
        }

        return view('front.pages.brand-models-list',
            [
                'metafields'=>$meta_fields,
                'brandInfo' => $brand_info,
                'modelInfo' => $model_info,
                'parts' => $results,
                'categories' => $this->modelRepo->getPartsModelCategory($model_info->id),
                'category' => $category
            ]
        );
    }


    /**
     * @param $brandSlug
     * @param $slug
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function showModelById(Request $request)
    {
        //echo "hello: ";


        //id=35655&sid
        if($request->has('sid') && $request->has('id')) {
            $part_id=$request->id;
            $model_id=$request->sid;
            // Part page (('{brandSlug}/bbq-grill-replacement-parts/{slug}', 'PartController@showPart')->name('part');  //['brandSlug' => $brandInfo->slug, 'slug' => $part->slug]
            $model_info = $this->modelRepo->getModelBy('old_id', $model_id);
            $brand_info = $this->brandRepo->getBrandBy('id', $model_info->brand_id);
            // $model_info = $this->modelRepo->getModelBy('slug', $modelSlug);
            $partDetails = $this->partRepo->getPartBy('catalogid', $part_id);
            //return redirect()->route('part',['brandSlug' => $brand_info->slug, 'slug' => $partDetails->slug]);

           // return (new PartController($this->brandRepo,$this->modelRepo, $this->catRepo, $this->partRepo))->showPart($brand_info->slug,$partDetails->slug,$request);

            return redirect()->route('part',['brandSlug' => $brand_info->slug, 'slug' => $partDetails->slug]);
        } else if($request->has('id')) {
            // Model Page
            $model_id=$request->id;
            $model_info = $this->modelRepo->getModelBy('old_id', $model_id);
            $brand_info = $this->brandRepo->getBrandBy('id', $model_info->brand_id);
            return redirect()->route('brands-model',['brandSlug' => $brand_info->slug, 'slug' => $model_info->slug]);
            //return $this->showModel($brand_info->slug, $model_info->slug,$request);

        } else {
            abort('404');
        }
        die;

    }



    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $page = $request->has('page') ? $request->input('page') : 1;
        $status = $request->has('status') ? $request->input('status') : "";
        $per_page = $request->has('per_page') ? $request->input('per_page') : 10;
        $search = $request->has('search') ? $request->input('search') : "";
        $records = $this->modelRepo->getRecords();

        if ($search != "") {
            $records = $this->modelRepo->getSearchRecords($records, $search);
        }
        if ($status != "") {
            $records = $records->where('status', '=', $status);
        }

        $records = $records->latest()
            ->paginate($per_page);

        if ($page > 1) {
            $page = (($page - 1) * $per_page) + 1;
        }

        $active = $this->modelRepo->allStatus(1)
            ->count();
        $inactive = $this->modelRepo->allStatus(0)
            ->count();

        $all_counts = $this->modelRepo->getRecords()
            ->count();

        return view('admin.stores.models.list', [
            'records' => $records,
            'per_page' => $per_page,
            'search' => $search,
            'status' => $status,
            'all_records' => $all_counts,
            'active_records' => $active,
            'inactive_records' => $inactive,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleBulkAction(Request $request)
    {
        $action = $request->has('action') ? $request->input('action') : "";
        $ids = $request->has('ids') ? $request->input('ids') : "";
        if ($action != "" && ($action == "delete" || $action == "0" || $action == "1") && !empty($ids)) {
            $records = $this->modelRepo->getRecords($ids);
            if ($action == "0" || $action == "1") {
                try {
                    foreach ($records as $record) {
                        $record->status = $action;
                        $record->save();
                    }
                    return redirect()->back()->withSuccess('Records(s) updated successfully');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in updating Records(s), please try again.');
                }

            } else if ($action == "delete") {
                try {
                    // delete
                    foreach ($records as $record) {
                        $this->modelRepo->delete($record->id);
                    }
                    return redirect()->back()->withSuccess('Record(s) deleted successfully');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in deleting Record(s), please try again.');
                }
            }
        } else if ($action == "sort") {
            //
        }
        return redirect()->back()->withErrors('There is some problem, please try again.');
    }

    /**
     * @return mixed
     */
    public function add()
    {
        // brands existing
        $brands = $this->brandRepo->all();
        $validator = JsValidator::make($this->validationAddModel, $this->validStringAddModel);
        // clear the parts association session vals
        Session::forget(['add_assign_part_session']);
        return view('admin.stores.models.add', [
                'brands' => $brands,
                'validator' => $validator
            ]
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleAdd(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationAddModel, $this->validStringAddModel);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->modelRepo->add($request);
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function edit($recordId)
    {
        $validation_rule = $this->validationAddModel;
        $validation_rule['model_number'] = 'required|max:255|unique:models,model_number,'.$recordId;
        $validation_rule['sku'] = 'required|max:255|unique:models,sku,'.$recordId;
        $validation_rule['slug'] = 'required|unique:models,slug,'.$recordId;
        $validator = JsValidator::make($validation_rule, $this->validStringAddModel);
        $record = $this->modelRepo->get($recordId);

        // get associated parts
        $associatedParts = $this->modelRepo->getAssociatedParts($recordId);
        // set session vars
        if($associatedParts['results']['part_ids'] != '') {
            Session::put('edit_assign_part_session_' . $recordId, explode(',', $associatedParts['results']['part_ids']));
        }

        return view('admin.stores.models.edit', [
                'brands' => $this->brandRepo->all(),
                'record' => $record,
                'associatedParts' => $associatedParts['results'],
                'validator' => $validator
            ]
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleEdit(Request $request)
    {
        $validation_rule = $this->validationAddModel;
        $validation_rule['model_number'] = 'required|max:255|unique:models,model_number,'.$request->input('id');
        $validation_rule['sku'] = 'required|max:255|unique:models,sku,'.$request->input('id');
        $validation_rule['slug'] = 'required|unique:models,slug,'.$request->input('id');
        $validator = Validator::make($request->all(), $validation_rule, $this->validStringAddModel);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->modelRepo->update($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeImage(Request $request)
    {
        return $this->modelRepo->removeImage($request);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function makeACopy($id)
    {
        // create a record and redirect to edit page.
        return $this->modelRepo->make_copy($id);
    }

    public function partsModelAssociation($start,$end) {
        return $this->modelRepo->parts_model_association($this->partRepo,$start,$end);
    }

    public function showBrandwiseAllModelsCounter($brandId,$catid=0) {
        $brand_info = $this->brandRepo->getBrandBy('id', $brandId);
        if($catid==0) {
            $modelArr = $this->modelRepo->getIdByBrandid('brand_id', $brandId, $brand_info->slug);
        } else {
            $modelArr = $this->modelRepo->getIdByBrandidCategoryid('brand_id', $brandId, $brand_info->slug, $catid);
        }
        return $modelArr;
    }
}
