<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Repositories\BrandRepository;
use App\Repositories\ModelRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events
     * @param BrandRepository $brandRepository
     * @param ModelRepository $modelRepository
     * @return void
     */
    public function boot(Dispatcher $events, BrandRepository $brandRepository, ModelRepository $modelRepository)
    {
      //  $all_brands = $brandRepository->getRecords()->orderBy('brand', 'ASC')->get(['id', 'brand']);
     //   $all_models = $modelRepository->getRecords()->orderBy('name', 'ASC')->get(['id', 'name']);

      //  View::share('all_brands', $all_brands);
      //  View::share('all_models', $all_models);

        Schema::defaultStringLength(191);

        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha and spaces.
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value);

        });

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('Store Management');
            $event->menu->add(
                [
                    'text' => 'Brands',
                    'url' => 'admin/stores/brands/list',
                    'active' => ['admin/stores/brands/list','admin/stores/brands/list*', 'admin/stores/brands/add', 'admin/stores/brands/add/*', 'admin/stores/brands/edit/*', 'regex:@^admin/stores/brands/edit/[0-9]+$@']
                ],
                [
                    'text' => 'Models',
                    'url' => 'admin/stores/models/list',
                    'active' => ['admin/stores/models/list','admin/stores/models/list*', 'admin/stores/models/add', 'admin/stores/models/add/*', 'admin/stores/models/edit/*', 'regex:@^admin/stores/models/edit/[0-9]+$@']
                ],
                [
                    'text' => 'Parts',
                    'url' => 'admin/stores/parts/list',
                    'active' => ['admin/stores/parts/list','admin/stores/parts/list*', 'admin/stores/parts/add', 'admin/stores/parts/add/*', 'admin/stores/parts/edit/*', 'regex:@^admin/stores/parts/edit/[0-9]+$@', 'admin/stores/parts/associate-models/*']
                ],
                [
                    'text' => 'Orders',
                    'url' => 'admin/stores/orders/list',
                    'active' => ['admin/stores/orders/list','admin/stores/orders/list*', 'admin/stores/orders/add', 'admin/stores/orders/add/*', 'admin/stores/orders/edit/*', 'regex:@^admin/stores/orders/edit/[0-9]+$@']
                ]
            );
            $event->menu->add('Category Management');
            $event->menu->add(
                [
                    'text' => 'List',
                    'url' => 'admin/categories/list',
                    'active' => ['admin/categories/list','admin/categories/list*', 'admin/categories/edit/*', 'regex:@^admin/categories/edit/[0-9]+$@']
                ],
                [
                    'text' => 'Add',
                    'url' => 'admin/categories/add'
                ]
            );
            $event->menu->add('CMS Management');
            $event->menu->add(
                [
                    'text' => 'CMS Pages',
                    'url' => 'admin/cms',
                ]
            );
            $event->menu->add('Customer Management');
        });
    }
}
