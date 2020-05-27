<?php

namespace App\Listeners;

use App\Repositories\WishListRepository;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\CartRepository;

class LogSuccessfulLogin
{
    protected $cartRepo, $wishListRepo;

    /**
     * Create the event listener.
     *
     * @param CartRepository $cartRepo
     * @param WishListRepository $wishListRepo
     */
    public function __construct(CartRepository $cartRepo, WishListRepository $wishListRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->wishListRepo = $wishListRepo;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        if ($event->user->hasRole('user')) {
            /**
             * Save cart items
             */
            $this->cartRepo->saveLoggedUser($event->user);
            /**
             * Save wish list
             */
            $this->wishListRepo->saveLoggedUser($event->user);
            /**
             * Save checkout details
             */
            $this->cartRepo->saveCheckOutDetailsLoggedUser($event->user);
        }
    }
}
