<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ProductModel;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use JsValidator;
use Illuminate\Support\Facades\Log;
/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * @var array
     */
    protected $validationAddRecord = [
        'name' => 'required|max:255',
        'meta_description' => 'required|min:50',
        'image' => 'sometimes|mimes:jpg,jpeg,gif,bmp,png',
        'ordernum' => 'sometimes|numeric'
    ];
    /**
     * @var array
     */
    protected $validationEditRecord = [
        'name' => 'required|max:255',
        'meta_description' => 'required|min:50',
        'image' => 'sometimes|mimes:jpg,jpeg,gif,bmp,png',
        'slug' => 'required'
    ];
    /**
     * @var array
     */
    protected $validStringAddRecord = [
        'name.required' => 'The title field is required.'
    ];
    /**
     * @var
     */
    protected $brandRepo, $modelRepo, $catRepo, $partRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $page           = $request->has('page') ? $request->input('page') : 1;
        $status         = $request->has('status') ? $request->input('status') : "";
        $per_page       = $request->has('per_page') ? $request->input('per_page') : 10;
        $search         = $request->has('search') ? $request->input('search') : "";
        $records        = $this->catRepo->getRecords();

        if($search != "") {
            $records = $this->catRepo->getSearchRecords($records, $search);
        }
        if($status != "") {
            $records  = $records->where('status', '=', $status);
        }

        $records = $records->orderBy('ordernum', 'ASC')
            ->paginate($per_page);

        if($page > 1) {
            $page = (($page - 1) * $per_page) + 1;
        }

        $active      = $this->catRepo->allStatus(1)
            ->count();
        $inactive    = $this->catRepo->allStatus(0)
            ->count();

        $all_counts = $this->catRepo->getRecords()
            ->count();


        return view('admin.categories.list', [
                'records' => $records,
                'per_page' => $per_page,
                'search' => $search,
                'status' => $status,
                'all_records' => $all_counts,
                'active_records' => $active,
                'inactive_records' => $inactive,
            ]
        );
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $validator = JsValidator::make($this->validationAddRecord, $this->validStringAddRecord);

        return view('admin.categories.add', [
                'categories' => $this->catRepo->all(),
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
        $validator = JsValidator::make($this->validationEditRecord, $this->validStringAddRecord);
        $record = $this->catRepo->get($recordId);
        return view('admin.categories.edit', [
                'categories' => $this->catRepo->all(),
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
        return $this->catRepo->add($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handleEdit(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationEditRecord, $this->validStringAddRecord);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return $this->catRepo->update($request);
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
            $records = $this->catRepo->getRecords($ids);
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
                        $this->catRepo->delete($record->id);
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
                            $this->catRepo->changeOrder($record_id, $order);
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
        return $this->catRepo->removeImage($request);
    }

    ///////////////////////////Frontend Starts here///////////////////
    /// Grill Parts - header menu option, /grill-parts route
    public function showGrillparts(Request $request)
    {

        $mainCatId='1';
        $mainCatInfo = $this->catRepo->get($mainCatId);
//        print_r($mainCatInfo); //meta_title, meta_keywords, meta_description, description

        $meta_fields['title']=$mainCatInfo->meta_title;
        $meta_fields['keyword']=$mainCatInfo->meta_keywords;
        $meta_fields['description']=$mainCatInfo->meta_description;
        $page_description=$mainCatInfo->description;

        $records  = $this->catRepo->getCategoriesFront($mainCatId); //getCategoriesFront(category_id='Grill Parts') Category "Grill parts" id is "1". Returning Fields: 'id', 'image', 'slug', 'name', 'highercategoryid'

        return view('front.pages.categories', [
                'metafields' => $meta_fields,
                'description' =>$page_description,
                'records' => $records
            ]
        );
    }

    public function showCategoryParts($brandSlug, $categorySlug, $slug='', Request $request) {
//        echo "Brand: ".$brandSlug."<br>";
//        echo "Category: ".$categorySlug."<br>";
//        echo "Model: ".$slug;
//          die;
        $category = $this->catRepo->getCategoryBySlug($categorySlug);
        $brand_info = Brand::where('slug', $brandSlug)->first();
        $topCatArr = $this->catRepo->getPartsCategory([1]);
        $subCatIdArr=$subCatArr=$topCatIdArr= array();

        foreach ($topCatArr as $key) {
            array_push($topCatIdArr,$key['id']);
            $subCatIdArr[$key['id']]=array();
        }
        //print_r($topCatIdArr);
        if(count($topCatIdArr)>0) {
            $subCatArr = $this->catRepo->getPartsCategory($topCatIdArr);
            //$topCatIdArr
            //print_r($subCatArr);
            foreach ($subCatArr as $kkey) {
                array_push($subCatIdArr[$kkey['highercategoryid']],$kkey);
            }

           // print_r($subCatIdArr);
        }
        //die;



        $meta_fields['title']=$category->meta_title;
        $meta_fields['keyword']=$category->meta_keywords;
        $meta_fields['description']=$category->meta_description;

        $per_page = 24;

        //DB::enableQueryLog();
        $results = $this->catRepo->getCategoryParts($per_page, $category,$brand_info->id, $slug);

       // $queries = DB::getQueryLog();
//        foreach($queries as $k=>$query)
//        {
//            Log::debug(" $k Query - " . json_encode($query));
//        }
//        echo count($results);
//        print_r($results);
//die;

        if($request->ajax()) {
            if($results->nextPageUrl() != "") {
                $nextPageUrl = $results->nextPageUrl();
            } else {
                $nextPageUrl = '';
            }
            return [
                'parts' => view('front.pages.includes.brand-models-parts', [
                        'parts' => $results,
                        'brandInfo' => $brand_info]
                )->render(),
                'metafields'=>$meta_fields,
                'next_page' => $nextPageUrl,
                'total_records' => $results->total()
            ];
        }

        $model_name = '';
        if($slug!='') {
            $modelArr = ProductModel::where('slug', $slug)->first(['name']);
            $model_name = $modelArr['name'];
        }

        return view('front.pages.brand-categories-list',
            [
                'metafields'=>$meta_fields,
                'brandInfo' => (object)$brand_info,
                'parts' => $results,
                'modelName' => $model_name,
                'category' => $category,
                'subCatIdArr' => $subCatIdArr,
                'topCatIdArr' =>$topCatArr
            ]
        );
        die;



    }

    public function showCategoryAccessories($categorySlug, Request $request) {
        $category = $this->catRepo->getCategoryBySlug($categorySlug);
//        print_r($category);
//        die;
        $routeVar='accessories-products';
        if ($category->highercategoryid=='2') { // for accessories (category slug and brand slug should be same for
            $routeVar='accessories-products';
        } else if ($category->highercategoryid=='16') { // for propane parts
            $routeVar='propane-parts';
        }
        $dimensions='';
        if($categorySlug=='bbq-covers') {
           $dimensions= $this->catRepo->getBbqcoverDimension($category->id);
           //print_r($dimensions);
        }

        $topCat=$this->catRepo->get($category->highercategoryid);
        $topCatArr = $this->catRepo->getPartsCategory([$category->highercategoryid]); //id 2 is particularly for Accessories
        $topCatIdArr= array();
        foreach ($topCatArr as $key) {
            array_push($topCatIdArr,$key['id']);
            //$subCatIdArr[$key['id']]=array();
        }

        $meta_fields['title']=$category->meta_title;
        $meta_fields['keyword']=$category->meta_keywords;
        $meta_fields['description']=$category->meta_description;

        $per_page = 24;

        //DB::enableQueryLog();
        $results = $this->catRepo->getCategoryParts($per_page, $category,'0', $slug='');


        if($request->ajax()) {
            if($results->nextPageUrl() != "") {
                $nextPageUrl = $results->nextPageUrl();
            } else {
                $nextPageUrl = '';
            }
            return [
                'parts' => view('front.pages.includes.accessories-parts', [
                        'parts' => $results]
                )->render(),
                'metafields'=>$meta_fields,
                'next_page' => $nextPageUrl,
                'total_records' => $results->total()
            ];
        }

        return view('front.pages.accessories-categories-list',
            [
                'metafields'=>$meta_fields,
                'parts' => $results,
                'category' => $category,
                'resultCount' => $category->parts()->count(),
                'topCatIdArr' =>$topCatArr,
                'routeVar' => $routeVar,
                'topCat' => $topCat,
                'dimensions' =>$dimensions
            ]
        );
    }

}
