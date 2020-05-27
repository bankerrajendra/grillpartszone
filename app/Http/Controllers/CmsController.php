<?php

namespace App\Http\Controllers;


use App\Repositories\CmsPagesRepository;
use App\Logic\Common\UserInformationOptionsRepository;
use App\Mail\ContactSubmission;
use Illuminate\Support\Facades\Mail;
use JsValidator;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    protected $cmsPagesService;
    protected $validationRules = [
        'orderno'=>'required',
        'name'=>'required|alpha_spaces',
        'email'=>'required|email',
        'subject'=>'required',
        'mobile'=>'required|numeric',
        'message'=>'required'
    ];
    protected $validationRulesServer = [
        'orderno'=>'required',
        'name'=>'required|alpha_spaces',
        'email'=>'required|email',
        'subject'=>'required',
        'mobile'=>'required',
        'message'=>'required',
        'g-recaptcha-response' => 'required|captcha'
    ];
    //
    public function __construct(CmsPagesRepository $cmsPagesService)
    {
        $this->cmsPagesService=$cmsPagesService;
    }

    public function getTelephone() {
        $response = array(
            'status' => 1,
            'res' => getGeneralSiteSetting('site_contact_telephone')
        );
        return $response;
    }

    public function getPageInfo($slug) {

        $cmsPageInfo=$this->cmsPagesService->getPageRec($slug);
        $meta_fields['title']=$cmsPageInfo->meta_title;
        $meta_fields['keyword']=$cmsPageInfo->meta_keyword;
        $meta_fields['description']=$cmsPageInfo->meta_description;
        return view('front.pages.cms.cms-page')->with(['pageinfo' => $cmsPageInfo, 'metafields' => $meta_fields, 'slug' => $slug]);
    }



    public function contact() {
        $meta_fields['title']="Contact Us - Arabwedding.com, Membership Plans & Support";
        $meta_fields['keyword']="Contact Us, Arabwedding.com, Supporting Help & Premium Membership";
        $meta_fields['description']="Members can contact us on Muslim Shaadi Arab Wedding through contact us page. If you need to report an issue or need assistance, we can help";
        $slug='contact-us';
        $validator = JsValidator::make($this->validationRules);
        return view('front.pages.cms.cms-contact')->with(['metafields'=>$meta_fields,'validator'=>$validator,'slug'=>$slug]);
    }

    public function sitemap() {
        $meta_fields['title']="Site Map - ArabWedding.com - Arab Singles Marriage Dating Site";
        $meta_fields['keyword']="Sitemap Arabwedding.com to Guide & Helps to Users";
        $meta_fields['description']="Use the site map to find a list of all Arab friends, Arab Personals, Arab dating, Arab marriage, Arab zawaj and Arab soul mate near you. Simply click and meet your Arab love";
        $slug='sitemap';
        $religionList = config('constants.religions');
        $site_id= config('constants.site_id');

        $sectList=CmsCityState::where('page_type','Community')->where('type_name','!=','Muslim')->get(); //->where('site_id',$site_id)
        $countryList=CmsCityState::where('page_type','Country')->get(); //->where('site_id',$site_id)
        $languageList=CmsCityState::where('page_type','Language')->orderByRaw('RAND()')->take(12)->get();//->where('site_id',$site_id)

        return view('pages.cms.sitemap')->with(['metafields'=>$meta_fields,
            'slug'=>$slug,
            'religions'=>$religionList,
            'sectList'=>$sectList,
            'countryList'=>$countryList,
            'languageList'=>$languageList,]);
    }

    public function sendContact(Request $request) {
        $validate =$request->validate($this->validationRulesServer,
            [
                'orderno.required'=>'Order number is required',
                'name.required'=>'Name is required',
                'email.required'=>'Email is required',
                'email.email'=>'Invalid email format',
                'subject.required'=>'Subject is required',
                'mobile.required'=>'Mobile is required',
                'message.required'=>'Message is required',
                'g-recaptcha-response.required'=>'Captcha  is required',
                'g-recaptcha-response.captcha'=>'Invalid Captcha'
            ]
        );

        $contact=array();
        $contact['orderno']=$request->orderno;
        $contact['username']=$request->name;
        $contact['email']=$request->email;
        $contact['subject']=$request->subject;
        $contact['mobile']=$request->mobile;
        $contact['message']=$request->message;

        try {
            $adminemail=config('constants.ADMIN_EMAIL');
            Mail::to($adminemail)->send(new ContactSubmission($contact));

        }
        catch (Exception $e){

        }

        return redirect()->back()->withSuccess(config('constants.contact_save.save_message'));
    }

    public function getCms(){
        $cmsPages=$this->cmsPagesService->getPages();

        return view('admin.cms.cms-page')->with(['pageslist'=>$cmsPages]);
    }

    public function setCmsPage($cms_id){
        $cmsPageInfo=$this->cmsPagesService->getPageInfo($cms_id);

        return view('admin.cms.edit-cms-page')->with(['cmspageinfo'=>$cmsPageInfo,'id'=>$cms_id]);
    }

    public function updateCmsPage($cms_id, Request $request) {

        $this->cmsPagesService->updateCmsRec($cms_id, $request);
        return redirect(route('cms-listing'));
    }
}
