<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\ProductModel;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JsValidator;
use App\Repositories\BrandRepository;
use App\Repositories\ModelRepository;
use App\Repositories\PartRepository;
use MongoDB\Driver\Session;

/**
 * Class PartController
 * @package App\Http\Controllers
 */
class PartController extends Controller
{
    /**
     * @var array
     */
    protected $validationAddRecord = [
        'name' => 'required|max:255',
        'meta_description' => 'required|min:50',
        'model_no' => 'required|max:255',
        'sku' => 'required|unique:parts|max:255'
    ];

    /**
     * @var array
     */
    protected $validStringAddRecord = [
        'name.required' => 'The title field is required.'
    ];

    /**
     * @var BrandRepository
     */
    protected $brandRepo, $modelRepo, $catRepo, $partRepo;

    /**
     * Create a new controller instance.
     *
     * @param BrandRepository $brandRepo
     * @param ModelRepository $modelRepo
     * @param CategoryRepository $catRepo
     * @param PartRepository $partRepo
     */
    public function __construct(BrandRepository $brandRepo, ModelRepository $modelRepo, CategoryRepository $catRepo, PartRepository $partRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->modelRepo = $modelRepo;
        $this->catRepo = $catRepo;
        $this->partRepo = $partRepo;
    }

    public function showPart(string $brandSlug, string $slug, Request $request)
    {
        $brand_info = $this->brandRepo->getBrandBy('slug', $brandSlug);
       // $model_info = $this->modelRepo->getModelBy('slug', $modelSlug);
        $partDetails = $this->partRepo->getPartBy('slug', $slug);
        // $this->partRepo->savePartInViewedReturn($partDetails->id, $model_info->id);


		$meta_fields['title']=$partDetails->meta_title;
        $meta_fields['keyword']=$partDetails->meta_keywords;
        $meta_fields['description']=$partDetails->meta_description;
		
        return view('front.pages.part', [
                'metafields'=>$meta_fields,
                'part' => $partDetails,
                'brand' => $brand_info,
               // 'model' => $model_info,
                //'viewedParts' => $this->partRepo->showViewedParts($partDetails->id),
                'associatedModels' => $this->partRepo->getBransNModelsArray($partDetails)
            ]
        );
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
        $search_with = $request->has('search_with') ? $request->input('search_with') : "";
        $search = $request->has('search') ? $request->input('search') : "";
        $records = $this->partRepo->getRecords();

        if ($search != "") {
            $records = $this->partRepo->getSearchRecords($records, $search, $search_with);
        }
        if ($status != "") {
            $records = $records->where('is_active', '=', $status);
        }

        $records = $records->latest()
            ->paginate($per_page);

        if ($page > 1) {
            $page = (($page - 1) * $per_page) + 1;
        }

        $active = $this->partRepo->allStatus(1)
            ->count();
        $inactive = $this->partRepo->allStatus(0)
            ->count();

        $all_counts = $this->partRepo->getRecords()
            ->count();


        return view('admin.stores.parts.list', [
                'records' => $records,
                'per_page' => $per_page,
                'search' => $search,
                'status' => $status,
                'all_records' => $all_counts,
                'active_records' => $active,
                'inactive_records' => $inactive,
                'search_with' => $search_with
            ]
        );
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $validator = JsValidator::make($this->validationAddRecord, $this->validStringAddRecord);
        return view('admin.stores.parts.add', [
                'categories' => $this->catRepo->getLevelRecords(),
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
        $validator = Validator::make($request->all(), $this->validationAddRecord, $this->validStringAddRecord);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->partRepo->add($request);
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
            $records = $this->partRepo->getRecords($ids);
            if ($action == "0" || $action == "1") {
                try {
                    foreach ($records as $record) {
                        $record->is_active = $action;
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
                        $this->partRepo->delete($record->id);
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
     * @param $recordId
     * @return mixed
     */
    public function edit($recordId)
    {
        $validation_rule = $this->validationAddRecord;
        $validation_rule['sku'] = 'required|max:255|unique:parts,sku,' . $recordId;
        $validation_rule['slug'] = 'required|unique:parts,slug,' . $recordId;
        $validator = JsValidator::make($validation_rule, $this->validStringAddRecord);
        $record = $this->partRepo->get($recordId);
        $categoryAssigned = $record->categories;
        $catAssgnTopArr = [];
        $catAssgnSubArr = [];
        $catAssgnSubSubArr = [];
        if ($categoryAssigned != null) {
            foreach ($categoryAssigned as $catObj) {
                if ($catObj->highercategoryid == 0) {
                    // top category
                    $catAssgnTopArr[] = $catObj->id;
                } else if ($catObj->highercategoryid != 0) {
                    if ($catObj->deterMineLevel($catObj->highercategoryid) == 'second') {
                        $catAssgnSubArr[] = $catObj->id;
                    } elseif ($catObj->deterMineLevel($catObj->highercategoryid) == 'third') {
                        $catAssgnSubSubArr[] = $catObj->id;
                    }
                }
            }
        }

        return view('admin.stores.parts.edit', [
                'categories' => $this->catRepo->getLevelRecords(),
                'sub_categories' => (count($catAssgnTopArr) > 0) ? $this->catRepo->getLevelRecords($catAssgnTopArr) : [],
                'sub_sub_categories' => (count($catAssgnSubArr) > 0) ? $this->catRepo->getLevelRecords($catAssgnSubArr) : [],
                'first_cats' => $catAssgnTopArr,
                'second_cats' => $catAssgnSubArr,
                'third_cats' => $catAssgnSubSubArr,
                'record' => $record,
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
        $validation_rule = $this->validationAddRecord;
        $validation_rule['sku'] = 'required|max:255|unique:parts,sku,' . $request->input('id');
        $validation_rule['slug'] = 'required|unique:parts,slug,' . $request->input('id');
        $validator = Validator::make($request->all(), $validation_rule, $this->validStringAddRecord);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->partRepo->update($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removePartImage(Request $request)
    {
        return $this->partRepo->removePartImage($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removePartManual(Request $request)
    {
        return $this->partRepo->removePartManual($request);
    }

    /**
     * @param Request $request
     * @return bool|mixed
     */
    public function fetchChildCategory(Request $request)
    {
        $value = $request->input('value');
        $output = [];
        try {
            $records = $this->catRepo->getLevelRecords($value);
            $count = 0;
            foreach ($records as $record) {
                $output[$count]['id'] = $record->id;
                $output[$count]['slug'] = $record->slug;
                $output[$count]['name'] = $record->name;
                $output[$count]['parent'] = $record->highercategoryid;
                $count++;
            }
            return response()->json($output);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        return false;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSearchedParts(Request $request)
    {
        $key = $request->has('key') ? $request->input('key') : "";
        $type = $request->has('type') ? $request->input('type') : "part";
        if($key != '' && $key != null) {
            $categoryName = '';
            if($type == 'part') {
                $categoryName = config('constants.GRILL_PARTS_CATEGORY');
            } else if($type == 'accessory') {
                $categoryName = config('constants.ACCESSORIES_CATEGORY');
            }
            $results = $this->partRepo->getPartsByCategory($key, $categoryName);
            return view('admin.stores.models.ajax.show-parts', [
                        'results' => $results,
                        'type' => $type
                    ]
                );
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function actionSearchedParts(Request $request)
    {
        $pid = $request->has('pid') ? $request->input('pid') : '';
        $type = $request->has('type') ? $request->input('type') : "part";
        $model_id = $request->has('model_id') ? $request->input('model_id') : "";
        // define session keys
        if($model_id != '' && ProductModel::where('id', $model_id)->exists()) {
            $sessionKeyPartAssign = 'edit_assign_part_session_'.$model_id;
        } else {
            $sessionKeyPartAssign = 'add_assign_part_session';
        }
        $parts_ids = "";
        $results = $this->partRepo->getPartsForAddModelPage($request);

        if($request->session()->has($sessionKeyPartAssign)) {
            $parts_ids = implode(',', $request->session()->get($sessionKeyPartAssign));
        }

        if($pid != '' && $pid != null) {
            return view('admin.stores.models.ajax.list-parts', [
                    'results' => $results,
                    'type' => $type,
                    'parts_ids' => $parts_ids
                ]
            );
        }
    }

    public function showAssociateModels($id)
    {
        $record = $this->partRepo->get($id);

        return view('admin.stores.parts.associate-models', [
            'record' => $record,
            'record_id' => $record->id,
            'brandsModels' => $this->brandRepo->getAssociatedModels(),
            'assignedModels' => $this->partRepo->getBransNModelsArray($record),
            'alreadyAssignedModels' => $this->partRepo->getAssociatedModels($id)
        ]);
    }

    public function associateModelWithPart(Request $request)
    {
        $action = $request->has('action') ? $request->input('action') : '';
        $this->partRepo->doAssignModel($request);
        $part_id = $request->has('part_id') ? $request->input('part_id') : '';
        $record =  Part::find($part_id);
        if($action == 'add') {
            return view('admin.stores.parts.includes.in-models', [
                            'assignedModels' => $this->partRepo->getBransNModelsArray($record),
                            'record_id' => $record->id
                    ]
                );
        } else {
            return view('admin.stores.parts.includes.out-models', [
                        'brandsModels' => $this->brandRepo->getAssociatedModels(),
                        'record_id' => $record->id
                ]
            );
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function makeACopy($id)
    {
        // create a record and redirect to edit page.
        return $this->partRepo->make_copy($id);
    }
}
