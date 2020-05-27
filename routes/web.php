<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::get('/', 'Auth\RegisterController@homePage')->name('welcome');

Route::get('shopexd.asp', 'ModelController@showModelById')->name('brand-models-list-old');

/***
 * Guest - STARTED
 */

Route::get('grill-parts', 'CategoryController@showGrillparts')->name('grill-parts');
Route::get('grill-parts/{slug}', 'CategoryController@showCategoryParts')->name('grill-cat-products');

Route::get('bbq-brands/{category?}', 'BrandController@showBrands')->name('brands');
//Route::get('brand/{slug}', 'BrandController@showBrandModels')->name('brand-models-list');
//Route::get('brand/{brandSlug}/model/{slug}', 'ModelController@showModel')->name('brands-model');
//Route::get('brand/{brandSlug}/model/{modelSlug}/part/{slug}', 'PartController@showPart')->name('part');
Route::get('grillparts/{slug}', 'BrandController@showBrandModels')->name('brand-models-list');
Route::get('bbq-grill-parts/{brandSlug}/{slug}/{categorySlug?}', 'ModelController@showModel')->name('brands-model');
Route::get('bbq-parts/{brandSlug}/{categorySlug}/{slug?}', 'CategoryController@showCategoryParts')->name('brands-category');
//Route::get('bbq-grill-parts/{brandSlug}/{slug}/{categorySlug}', 'ModelController@showModel')->name('brands-model-cat');

Route::get('fetch-brand-allmodels/{brandid}/{catid?}', 'ModelController@showBrandwiseAllModelsCounter')->name('models-with-counter');

Route::get('{brandSlug}/bbq-grill-replacement-parts/{slug}', 'PartController@showPart')->name('part');

//Route::get('grill-accessories/bbq-covers', 'CategoryController@showCategoryAccessories')->name('bbq-covers');
Route::get('grill-accessories/{slug}', 'CategoryController@showCategoryAccessories')->name('accessories-products');
Route::get('propane-parts/{slug}', 'CategoryController@showCategoryAccessories')->name('propane-parts');


Route::post('part-add-to-cart', 'CartController@add')->name('part-add-to-cart');
Route::post('part-add-to-wish-list', 'WishListController@add')->name('part-add-to-wish-list');
Route::post('part-remove-from-cart', 'CartController@remove')->name('part-remove-from-cart');
Route::post('part-remove-from-wish-list', 'WishListController@remove')->name('part-remove-from-wish-list');
Route::post('wish-part-move-to-cart', 'WishListController@moveToCart')->name('wish-part-move-to-cart');
Route::get('cart', 'CartController@list')->name('show-cart');
Route::get('delivery-address', 'CartController@addDeliveryAddress')->name('add-delivery-address');
Route::post('ajax/fetchLocation', ['as' => 'ajax.fetchLocation', 'uses' => 'AjaxController@fetchLocation']);
Route::post('copy-billing-to-shipping-address', 'CartController@copyBillingToShipping')->name('copy-billing-to-shipping-address');
Route::post('submit-address-details', 'CartController@submitAddress')->name('submit-address-details');
Route::post('update-address-price-block', 'CartController@updateAddressPrice')->name('update-address-price-block');
/***
 * Guest - ENDED
 */

/**
 * Site's Super Admin Routes - STARTED
 */
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');
    ## Manage START Admin->Brands ##
    Route::get('admin/stores/brands/list', 'BrandController@list')->name('admin-brands');
    Route::post('admin/stores/brands/handle-manage-bulk-brands', 'BrandController@handleBulkAction')->name('handle-manage-bulk-brands');
    Route::get('admin/stores/brands/add', 'BrandController@add')->name('add-brand');
    Route::post('admin/stores/brands/handle-add-brand', 'BrandController@handleAdd')->name('handle-add-brand');
    Route::get('admin/stores/brands/edit/{id}', 'BrandController@edit')->name('edit-brand');
    Route::post('admin/stores/brands/handle-edit-brand', 'BrandController@handleEdit')->name('handle-edit-brand');
    Route::post('admin/ajax/remove-brand-image', 'BrandController@removeImage')->name('admin-remove-brand-image');
    ## Manage END Admin->Brands ##
    ## Manage START Admin->Models ##
    Route::get('admin/stores/models/list', 'ModelController@list')->name('admin-models');
    Route::post('admin/stores/models/handle-manage-bulk-models', 'ModelController@handleBulkAction')->name('handle-manage-bulk-models');
    Route::get('admin/stores/models/add', 'ModelController@add')->name('add-model');
    Route::post('admin/stores/models/handle-add-model', 'ModelController@handleAdd')->name('handle-add-model');
    Route::get('admin/stores/models/edit/{id}', 'ModelController@edit')->name('edit-model');
    Route::get('admin/stores/models/make-copy/{id}', 'ModelController@makeACopy')->name('make-copy-model');
    Route::get('admin/stores/models/association/{start}/{end}', 'ModelController@partsModelAssociation')->name('parts-model-assoc');

    Route::post('admin/stores/models/handle-edit-model', 'ModelController@handleEdit')->name('handle-edit-model');
    Route::post('admin/ajax/remove-model-image', 'ModelController@removeImage')->name('admin-remove-model-image');
    ## Manage END Admin->Models ##
    ## Manage START Admin->Parts ##
    Route::get('admin/stores/parts/list', 'PartController@list')->name('admin-parts');
    Route::post('admin/stores/parts/handle-manage-bulk-parts', 'PartController@handleBulkAction')->name('handle-manage-bulk-parts');
    Route::get('admin/stores/parts/add', 'PartController@add')->name('add-part');
    Route::post('admin/stores/parts/handle-add-part', 'PartController@handleAdd')->name('handle-add-part');
    Route::get('admin/stores/parts/edit/{id}', 'PartController@edit')->name('edit-part');
    Route::get('admin/stores/parts/make-copy/{id}', 'PartController@makeACopy')->name('make-copy-part');
    Route::post('admin/stores/parts/handle-edit-part', 'PartController@handleEdit')->name('handle-edit-part');
    Route::post('admin/ajax/remove-part-image', 'PartController@removePartImage')->name('admin-remove-part-image');
    Route::post('admin/ajax/remove-part-document', 'PartController@removePartManual')->name('admin-remove-part-document');
    Route::post('admin/ajax/fetch-child-category', 'PartController@fetchChildCategory')->name('admin-fetch-child-category');
    Route::post('admin/ajax/get-search-parts', 'PartController@getSearchedParts')->name('admin-get-search-parts');
    Route::post('admin/ajax/action-searched-parts', 'PartController@actionSearchedParts')->name('admin-action-searched-parts');
    Route::get('admin/stores/parts/associate-models/{id}', 'PartController@showAssociateModels')->name('admin-associate-models');
    Route::post('admin/ajax/associate-models-with-part', 'PartController@associateModelWithPart')->name('admin-associate-models-with-part');
    ## Manage END Admin->Parts ##
    ## Manage START Admin->Orders ##
    Route::get('admin/stores/orders/list', 'OrderController@list')->name('admin-orders');
    Route::post('admin/stores/orders/handle-manage-bulk-orders', 'OrderController@handleBulkAction')->name('handle-manage-bulk-orders');
    Route::post('admin/stores/orders/get-order-detail', 'OrderController@getOrderDetail')->name('admin-get-order-detail');
    Route::get('admin/stores/orders/edit/{id}', 'OrderController@edit')->name('edit-order');
    Route::post('admin/stores/orders/handle-edit-order', 'OrderController@handleEdit')->name('handle-edit-order');
    Route::get('admin/stores/orders/delete/{id}', 'OrderController@handleDelete')->name('delete-order');
    Route::get('admin/stores/orders/make-copy/{id}', 'OrderController@makeACopy')->name('make-copy-order');
    Route::get('admin/stores/orders/show/{id}', 'OrderController@show')->name('show-order');
    Route::get('admin/stores/orders/print/{id}', 'OrderController@print')->name('print-order');
    ## Manage END Admin->Orders ##
    ## Manage START Admin->Categories ##
    Route::get('admin/categories/list', 'CategoryController@list')->name('admin-categories');
    Route::post('admin/categories/handle-manage-bulk-categories', 'CategoryController@handleBulkAction')->name('handle-manage-bulk-categories');
    Route::get('admin/categories/add', 'CategoryController@add')->name('add-category');
    Route::post('admin/categories/handle-add-category', 'CategoryController@handleAdd')->name('handle-add-category');
    Route::get('admin/categories/edit/{id}', 'CategoryController@edit')->name('edit-category');
    Route::post('admin/categories/handle-edit-category', 'CategoryController@handleEdit')->name('handle-edit-category');
    Route::post('admin/ajax/remove-category-image', 'CategoryController@removeImage')->name('admin-remove-category-image');
    ## Manage END Admin->Categories ##
    ## Manage START Admin->CMS ##
    Route::get('admin/cms', 'CmsController@getCms')->name('cms-listing');
    Route::get('admin/cms/{id}/edit', 'CmsController@setCmsPage')->name('set-cms-page');
    Route::post('admin/cms/{id}/update', 'CmsController@updateCmsPage')->name('update-cms-page');
    ## Manage END Admin->CMS ##
});
/**
 * Site's Super Admin Routes - ENDED
 */
Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('checkout', 'CartController@showCheckOut')->name('show-checkout');
    Route::post('moneris-approved', 'CartController@showMonerisResult')->name('moneris-approved');
    Route::post('moneris-declined', 'CartController@showMonerisDeclined')->name('moneris-declined');
    Route::post('handle-paypal-payment-submission', 'CartController@payWithPayPal')->name('handle-paypal-payment-submission');
    Route::get('payment-status-paypal-success', 'CartController@showPayPalResult')->name('payment-status-paypal-success');
    // route for cancel paypal url
    Route::get('payment-status-paypal-cancel', 'CartController@showPaymentPaypalCancel')->name('payment-status-paypal-cancel');
    // Show payment error page
    Route::get('payment-error', 'CartController@showPaymentError')->name('payment-error');
    Route::get('payment-success', 'CartController@showPaymentSuccess')->name('payment-success');
});

Route::get('/contact-us.html','CmsController@contact')->name('contact-us');
Route::post('/sendcontact','CmsController@sendContact')->name('send-contact');
Route::get('/{slug}.html','CmsController@getPageInfo')->name('cmsroots');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
