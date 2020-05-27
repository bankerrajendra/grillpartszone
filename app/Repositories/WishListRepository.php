<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Part;
use App\Models\WishList;
use Illuminate\Support\Facades\Auth;

/**
 * Class WishListRepository
 * @package App\Repositories
 */
class WishListRepository
{
    /**
     * WishListRepository constructor.
     */
    public function __construct()
    {

    }

    public function saveLoggedUser(object $user)
    {
        if (session()->has('wish_list')) {
            $wishItemsSess = session()->get('wish_list');
            if (!empty($wishItemsSess)) {
                $wishItemsUs = $user->wish_list;
                if ($wishItemsUs != null && $wishItemsUs != '') {
                    $wishItems = unserialize($wishItemsUs->details);
                    foreach ($wishItemsSess as $key => $item) {
                        $wishItems[$key]['brand_id'] = $wishItemsSess[$key]['brand_id'];
                        $wishItems[$key]['time'] = $wishItemsSess[$key]['time'];
                    }
                    WishList::where('user_id', $user->id)->update([
                        'details' => serialize($wishItems)
                    ]);
                } else {
                    try {
                        WishList::create([
                            'user_id' => $user->id,
                            'details' => serialize($wishItemsSess)
                        ]);
                    } catch (\Exception $e) {
                        // some error
                    }
                }
            }
            session()->forget('wish_list');
        }
    }

    public function showItems()
    {
        $items = $this->getAllWishItems();
        $itemsArray = [];
        $i = 0;
        if(count($items) > 0) {
            foreach ($items as $partKey => $partVal) {
                $brandObj = Brand::find($partVal['brand_id']);
                $partObj = Part::find($partKey);
                $itemsArray[$i]['id'] = $partObj->id;
                $itemsArray[$i]['image'] = $partObj->getSingleImg();
                $itemsArray[$i]['link'] = route('part', ['brandSlug' => $brandObj->slug,  'slug' => $partObj->slug]);
                $itemsArray[$i]['name'] = $partObj->name;
                $itemsArray[$i]['short_description'] = showReadMore($partObj->short_description, 60, '', false);
                $itemsArray[$i]['price'] = $partObj->price;
                $itemsArray[$i]['retail_price'] = $partObj->retail_price;
                $itemsArray[$i]['brand_id'] = $partVal['brand_id'];
                $itemsArray[$i]['stock'] = $partObj->stock;
                $i++;
            }
        }
        return $itemsArray;
    }

    public function addItem(int $part_id, int $brand_id)
    {
        $items = $this->getAllWishItems();
        // if there already remove it
        if(count($items) > 0 && array_key_exists($part_id, $items)) {
            unset($items[$part_id]);
            $return = 'Removed';
        } else {
            $items[$part_id]['brand_id'] = $brand_id;
            $items[$part_id]['time'] = time();
            $return = 'Added';
        }
        $this->saveItems($items);
        return $return;
    }

    public function removeItem(int $part_id)
    {
        $items = $this->getAllWishItems();
        unset($items[$part_id]);
        $this->saveItems($items);
        return 'Removed';
    }

    protected function saveItems(array $items)
    {
        if(count($items) > 0) {
            if(Auth::check()) {
                WishList::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['details' => serialize($items), 'user_id' => Auth::id()]
                );
            } else {
                session()->put('wish_list', $items);
            }
        } else {
            if(Auth::check()) {
                WishList::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['details' => '', 'user_id' => Auth::id()]
                );
            } else {
                session()->forget('wish_list');
            }
        }
    }

    protected function getAllWishItems()
    {
        $items = [];
        if(Auth::check()) {
            $wishObj = WishList::where('user_id', Auth::id())->first(['details']);
            if($wishObj != null && $wishObj->details != '') {
                $items = unserialize($wishObj->details);
            } else {
                $items = [];
            }
        } else {
            if(session()->has('wish_list')) {
                $items = session()->get('wish_list');
            } else {
                $items = [];
            }
        }
        return $items;
    }
}
