<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ModelRepository;
use App\Repositories\PartRepository;
use App\Repositories\WishListRepository;
use App\Repositories\CartRepository;

/**
 * Class WishListController
 * @package App\Http\Controllers
 */
class WishListController extends Controller
{
    /**
     * @var
     */
    protected $modelRepo, $partRepo, $wishListRepo, $cartRepo;

    /**
     * WishListController constructor.
     * @param ModelRepository $modelRepo
     * @param PartRepository $partRepo
     * @param WishListRepository $wishListRepo
     * @param CartRepository $cartRepo
     */
    public function __construct(ModelRepository $modelRepo, PartRepository $partRepo, WishListRepository $wishListRepo, CartRepository $cartRepo)
    {
        $this->modelRepo = $modelRepo;
        $this->partRepo = $partRepo;
        $this->wishListRepo = $wishListRepo;
        $this->cartRepo = $cartRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        return view('front.pages.cart', [
            'items' => $this->wishListRepo->showItems(),
            //'viewedParts' => $this->partRepo->showViewedParts()
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        $part_id = $request->has('part_id') ? (int)$request->input('part_id') : 0;
        $brand_id = $request->has('brand_id') ? (int)$request->input('brand_id') : 0;
        $part = $this->partRepo->getPartBy('id', $part_id);
        if ($part != null && $brand_id != 0) {
            $return = $this->wishListRepo->addItem($part_id, $brand_id);
            return response()->json(['message' => 'Part added in wish list.', 'return' => $return]);
        } else {
            return response()->json(['error' => 'Some issue while adding item in wish list.']);
        }
    }

    public function remove(Request $request)
    {
        $part_id = $request->has('part_id') ? (int)$request->input('part_id') : 0;
        if($part_id != null && $part_id != 0) {
            $return = $this->wishListRepo->removeItem($part_id);
            return response()->json(['message' => 'Part removed.', 'return' => $return]);
        } else {
            return response()->json(['error' => 'Some issue while removing item from wish list.']);
        }
    }

    public function moveToCart(Request $request)
    {
        $part_id = $request->has('part_id') ? (int)$request->input('part_id') : 0;
        $brand_id = $request->has('brand_id') ? (int)$request->input('brand_id') : 0;
        $part = $this->partRepo->getPartBy('id', $part_id);
        if ($part != null && $brand_id != 0) {
            $this->cartRepo->addItem($part_id, 1, $brand_id);
            $this->wishListRepo->removeItem($part_id);
            return view('front.pages.includes.cart-items', [
               'total_items' => count($this->cartRepo->showItems()),
               'items' => $this->cartRepo->showItems()
            ]);
        }
    }
}
