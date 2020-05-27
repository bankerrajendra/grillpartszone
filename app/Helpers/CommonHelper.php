<?php
function slugifyText($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function slugifyModel($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '_');

    // remove duplicate -
    $text = preg_replace('~-+~', '_', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n_a';
    }

    return $text;
}

// get three level cat name
function getCategoryName($catId)
{
    $catInfo = \App\Models\Category::find($catId);
    $cat_name = '';
    if ($catInfo->highercategoryid > 0) {
        $highCatInfo = \App\Models\Category::find($catInfo->highercategoryid);
        if ($highCatInfo->highercategoryid > 0) {
            $topHighCatInfo = \App\Models\Category::find($highCatInfo->highercategoryid);
            $cat_name .= $topHighCatInfo->name . " (" . $topHighCatInfo->id . ") --- ";
        }
        $cat_name .= $highCatInfo->name . " (" . $highCatInfo->id . ") --- ";
    }
    $cat_name .= $catInfo->name . " (" . $catInfo->id . ")";
    return $cat_name;
}

// shift element up and down
function moveElementUpDown(&$a, $oldpos, $newpos)
{
    if ($oldpos == $newpos) {
        return;
    }
    return array_splice($a, max($newpos, 0), 0, array_splice($a, max($oldpos, 0), 1));
}

function showReadMore($string, $limit = 100, $read_more_lnk = '', $echo = true)
{
    $string = strip_tags($string);
    if (strlen($string) > $limit) {
        // truncate string
        $stringCut = substr($string, 0, $limit);
        $endPoint = strrpos($stringCut, ' ');
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        if ($read_more_lnk != "") {
            $string .= '... <a href="' . $read_more_lnk . '" target="_blank">READ MORE</a>';
        } else {
            $string .= '...';
        }
    }
    if($echo) {
        echo $string;
    } else {
        return $string;
    }
}

function getTotalCartItems()
{
    if(\Auth::check()) {
        $cartObj = \App\Models\Cart::where('user_id', \Auth::id())->first(['details']);
        if($cartObj != null && $cartObj->details != '') {
            return $cart_items = count(unserialize($cartObj->details));
        }
    } else {
        if(session()->has('cart_items')) {
            return $cart_items = count(session()->get('cart_items'));
        }
    }
    return 0;
}

function getBrandInfo($partId) {
    //echo $partId;
    $modelId=\App\Models\ModelsPartsRelation::where('part_id',$partId)->first(['model_id']); //['id','slug']
    $brandId=App\Models\ProductModel::where('id',$modelId['model_id'])->first(['brand_id']);
    $brand_info = \App\Models\Brand::where('id',$brandId['brand_id'])->get();
    //print_r($modelId);
    //die;
}

function getCatId($slug) {
    $catRec=\App\Models\Category::where('slug',$slug)->first('id');
    return $catRec['id'];
}

function getAppropriatePrice($price)
{
    return number_format($price, 2, '.', '');
}

function getFinalTotalPrice($partCost, $shippingCost, $taxCost)
{
    $final_total = $partCost + $shippingCost + $taxCost;
    return number_format($final_total, 2, '.', '');
}

function getAccessoriesCategoryList($highCatId) {
 //SELECT * FROM grillpartslaravel.categories where  highercategoryid=2
    $highCat_info=\App\Models\Category::where('status','1')->where('highercategoryid',$highCatId)->orderBy('ordernum','asc')->get(['id','name','slug']);
    return $highCat_info;
}

function getAccessoriesBrandId() {
    $accessIdArr=\App\Models\Brand::where('slug','accessories')->first(['id']);
    return $accessIdArr['id'];
}
