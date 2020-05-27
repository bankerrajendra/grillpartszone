<?php

namespace App\Http\Controllers;

use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Validator;
use JsValidator;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class BrandController extends Controller
{
    /**
     * @var array
     */
    protected $validationAddRecord = [
        'brand' => 'required|unique:brands|max:255',
        'meta_description' => 'required|min:50',
        'image' => 'sometimes|mimes:jpg,jpeg,gif,bmp,png'
    ];

    /**
     * @var array
     */
    protected $validStringAddRecord = [
        'name.required' => 'The brand title field is required.'
    ];
    /**
     * @var
     */
    protected $brandRepo;

    /**
     * Create a new controller instance.
     *
     * @param BrandRepository $brandRepo
     */
    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBrands($category='')
    {

        return view('front.pages.brands', [
            'brands' => $this->brandRepo->getBrandBySortAlpha(),
            'category' => $category
        ]);
    }

    public function showBrandModels($slug, Request $request)
    {
        $brand_info = $this->brandRepo->getBrandBy('slug', $slug);
        $brand_models = $this->brandRepo->getBrandAssociatedModelsBy('slug', $slug);

        $meta_fields['title']=$brand_info->meta_title;
        $meta_fields['keyword']=$brand_info->meta_keywords;
        $meta_fields['description']=$brand_info->meta_description;

        return view('front.pages.brand-models', [
            'metafields'=>$meta_fields,
            'brandInfo' => $brand_info,
            'models' => $brand_models
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $page           = $request->has('page') ? $request->input('page') : 1;
        $per_page       = $request->has('per_page') ? $request->input('per_page') : 10;
        $search         = $request->has('search') ? $request->input('search') : "";
        $records        = $this->brandRepo->getRecords();

        if($search != "") {
            $records = $this->brandRepo->getSearchRecords($records, $search);
        }

        $records = $records->orderBy('brand', 'ASC')
            ->paginate($per_page);

        if($page > 1) {
            $page = (($page - 1) * $per_page) + 1;
        }

        $all_counts = $this->brandRepo->getRecords()
            ->count();


        return view('admin.stores.brands.list', [
                'records' => $records,
                'per_page' => $per_page,
                'search' => $search,
                'all_records' => $all_counts
            ]
        );
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $validator = JsValidator::make($this->validationAddRecord, $this->validStringAddRecord);

        return view('admin.stores.brands.add', [
                'categories' => $this->brandRepo->all(),
                'validator' => $validator
            ]
        );
    }

    /**
     * @param $recordId
     * @return mixed
     */
    public function edit($recordId)
    {
        $validation_rule = $this->validationAddRecord;
        $validation_rule['brand'] = 'required|max:255|unique:brands,brand,'.$recordId;
        $validator = JsValidator::make($validation_rule, $this->validStringAddRecord);
        $record = $this->brandRepo->get($recordId);
        return view('admin.stores.brands.edit', [
                'record' => $record,
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
        return $this->brandRepo->add($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleEdit(Request $request)
    {
        $validation_rule = $this->validationAddRecord;
        $validation_rule['brand'] = 'required|max:255|unique:brands,brand,'.$request->input('id');
        $validator = Validator::make($request->all(), $validation_rule, $this->validStringAddRecord);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->brandRepo->update($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleBulkAction(Request $request)
    {
        $action = $request->has('action') ? $request->input('action') : "";
        $ids    = $request->has('ids') ? $request->input('ids') : "";
        if( $action != "" && ($action == "delete" || $action == "0" || $action == "1") && !empty($ids) ) {
            $records = $this->brandRepo->getRecords($ids);
            if($action == "0" || $action == "1") {
                try {
                    foreach($records as $record) {
                        $record->status = $action;
                        $record->save();
                    }
                    return redirect()->back()->withSuccess('Records(s) updated successfully');
                } catch(\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in updating Records(s), please try again.');
                }

            } else if($action == "delete") {
                try {
                    // delete
                    foreach($records as $record) {
                        $this->brandRepo->delete($record->id);
                    }
                    return redirect()->back()->withSuccess('Record(s) deleted successfully');
                } catch(\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in deleting Record(s), please try again.');
                }
            }
        } else if($action == "sort") {
            $orders = $request->has('orders') ? $request->input('orders') : "";
            if(!empty($orders)) {
                try {
                    foreach($orders as $record_id => $order) {
                        if(is_numeric($order)) {
                            $this->brandRepo->changeOrder($record_id, $order);
                        }
                    }
                    return redirect()->back()->withSuccess('Orders updated successfully');
                } catch(\Exception $e) {
                    return redirect()->back()->withErrors('There is problem in updating orders, please try again.');
                }
            }
        }
        return redirect()->back()->withErrors('There is some problem, please try again.');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeImage(Request $request)
    {
        return $this->brandRepo->removeImage($request);
    }
}
