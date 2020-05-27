<?php

namespace App\Repositories;

use App\Models\CmsPage;

/**
 * Class CmsPagesRepository
 * @package App\Repositories
 */
class CmsPagesRepository {
    public function __construct()
    {
    }

    public function getPages() {
        $cmsPages=CmsPage::get(); //where('site_id', '=', config('constants.site_id'))->
        return $cmsPages;
    }

    public function getPageInfo($cms_id) {
        $cmsPageInfo=CmsPage::find($cms_id);
        return $cmsPageInfo;
    }
    public function updateCmsRec($cms_id, $request){
        $cmsPageRec=CmsPage::find($cms_id);

        //$cmsPageRec->page_title=$request->input('page_title');
        $cmsPageRec->page_description=$request->input('page_description');
        $cmsPageRec->meta_title=$request->input('meta_title');
        $cmsPageRec->meta_keyword=$request->input('meta_keyword');
        $cmsPageRec->meta_description=$request->input('meta_description');
        //$cmsPageRec->slug=$request->input('slug');
//        $cmsPageRec->status=$request->input('status');
        $cmsPageRec->save();
    }

    public function getPageRec($slug) {
        $cmsPageInfo=CmsPage::where('slug',$slug)->first(); //->where('site_id', '=', config('constants.site_id'))
        if($cmsPageInfo) {
            return $cmsPageInfo;
        } else {
            return abort(404);
        }
    }

}
