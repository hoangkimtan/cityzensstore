<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('admin/welcome', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

/* ===========================CLIENT================================= */
Route::get('/', 'HomeController@index');
Route::get('danh-muc/{slug}.{id}.html', 'ProductController@list')->name('product.list');
Route::get('san-pham/chi-tiet/{slug}.{id}', 'ProductController@detail')->name('product.detail');
Route::get('tim-kiem', 'ProductController@search');
Route::get('filter', 'ProductController@filterPrice')->name('product.filter.price');
Route::get('filter/brand', 'ProductController@filterBrand')->name('product.filter.brand');
Route::get('sort', 'ProductController@sort')->name('product.sort');

//================================CART================================
Route::get('tra-cuu-don-hang', 'CartController@checkOrder')->name('cart.check.order');
Route::get('gio-hang', 'CartController@show')->name('cart.show');
Route::get('thanh-toan', 'CartController@checkout')->middleware('checkCart')->name('cart.checkout');
Route::post('checkout', 'CartController@postCheckout')->name('cart.post.checkout');
Route::post('cart/add/{id}', 'CartController@Add')->name('cart.add');
Route::get('cart/add/{id}', 'CartController@Add')->name('cart.get.add');
Route::get('cart/remove/{rowId}', 'CartController@remove')->name('cart.remove');
Route::get('cart/destroy', 'CartController@destroy')->name('cart.destroy');
Route::get('cart/update/', 'CartController@update')->name('cart.update');
Route::get('cart/buy-now/{id}', 'CartController@buyNow')->name('cart.buynow');
Route::get('gio-hang/dat-hang-thanh-cong/{orderCode}', 'CartController@success')->name('cart.order.success');
Route::get('getDistrict', 'CartController@getDistrict')->name('checkout.get.district');
Route::get('getCommune', 'CartController@getCommune')->name('checkout.get.commune');

//========================================PAGE========================================
Route::get('trang/chi-tiet/{slug}.{id}', 'PageController@detail')->name('page.detail');
Route::get('tin-tuc/{post_cat_id?}', 'PostController@list')->name('post.list');
Route::get('tin-tuc/bai-viet/{slug}.{id}', 'PostController@detail')->name('post.detail');

/*==================================ADMIN============================================= */
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', 'DashboardController@show')->name('dashboard');
    Route::get('admin', 'DashboardController@show');
    //========================PRODUCT===================================
    //-------------------Product-cat------------------------------------
    Route::get('admin/product/cat/index', "AdminProductCatController@index")->name('admin.product_cat.index');
    Route::post('admin/product/cat/store', "AdminProductCatController@store")->name('admin.product_cat.create');
    Route::get('admin/product/cat/destroy/{id}', "AdminProductCatController@destroy")->name('admin.product_cat.destroy');
    Route::get('admin/product/cat/edit/{id}', "AdminProductCatController@edit")->name('admin.product_cat.edit');
    Route::post('admin/product/cat/update/{id}', 'AdminProductCatController@update')->name('admin.product_cat.update');

    //---------------------Product---------------------------------------
    Route::get('admin/product/index', 'AdminProductController@index')->name('admin.product.index');
    Route::get('admin/product/create', 'AdminProductController@create')->name('admin.product.create');
    Route::post('admin/product/create', 'AdminProductController@store')->name('admin.product.store');
    Route::get('admin/product/destroy/{id}', 'AdminProductController@destroy')->name('admin.product.destroy');
    Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('admin.product.delete');
    Route::get('admin/product/action', 'AdminProductController@action')->name('admin.product.action');
    Route::get('admin/product/edit/{id}', 'AdminProductController@edit')->name('admin.product.edit');
    Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('admin.product.update');

    //============================ORDER===================================
    Route::get('admin/order/index', 'AdminOrderController@index')->name('admin.order.index');
    Route::get('admin/order/edit/{id}', 'AdminOrderController@edit')->name('admin.order.edit');
    Route::post('admin/order/update/{id}', 'AdminOrderController@update')->name('admin.order.update');
    Route::post('admin/order/action', 'AdminOrderController@action')->name('admin.order.action');
    Route::get('admin/order/destroy/{id}', 'AdminOrderController@destroy')->name('admin.order.destroy');
    Route::get('admin/order/delete/{id}', 'AdminOrderController@delete')->name('admin.order.delete');

    //============================CUSTOMER===================================
    Route::get('admin/customer/index', 'AdminCustomerController@index')->name('admin.customer.index');
    Route::get('admin/customer/destroy/{id}', 'AdminCustomerController@destroy')->name('admin.customer.destroy');
    Route::get('admin/customer/{id}', 'AdminCustomerController@show')->name('admin.customer.edit');
    Route::post('admin/customer/update/{id}', 'AdminCustomerController@update')->name('admin.customer.update');

    //============================USER===================================
    Route::get('admin/user/list', 'AdminUserController@list')->name('admin.user.index');
    Route::get('admin/user/add', 'AdminUserController@add')->name('admin.user.create');
    Route::post('admin/user/store', 'AdminUserController@store')->name('admin.user.store');
    Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('admin.user.destroy');
    Route::get('admin/user/action', 'AdminUserController@action')->name('admin.user.action');
    Route::get('admin/user/update/{id}', 'AdminUserController@update')->name('admin.user.edit');
    Route::post('admin/user/update/{id}', 'AdminUserController@storeUpdate')->name('admin.user.update');

    //=====================POST====================================
    //---------------------Post-cat---------------------------------
    Route::get('admin/post/cat/', 'AdminPostCatController@index')->name('admin.post_cat.index');
    Route::post('admin/post/cat/create', 'AdminPostCatController@store')->name('admin.post_cat.create');
    Route::get('admin/post/cat/edit/{id}', 'AdminPostCatController@edit')->name('admin.post_cat.edit');
    Route::post('admin/post/cat/edit/{id}', 'AdminPostCatController@update')->name('admin.post_cat.update');
    Route::get('admin/post/cat/destroy/{id}', 'AdminPostCatController@destroy')->name('admin.post_cat.destroy');

    //---------------------Post------------------------------------
    Route::get('admin/post/create', 'AdminPostController@create')->name('admin.post.create');
    Route::post('admin/post/store', 'AdminPostController@store')->name('admin.post.store');
    Route::get('admin/post/index/{page?}', 'AdminPostController@index')->name('admin.post.index');
    Route::get('admin/post/destroy/{id}', 'AdminPostController@destroy')->name('admin.post.destroy');
    Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('admin.post.delete');
    Route::get('admin/post/action', 'AdminPostController@action')->name('admin.post.action');
    Route::get('admin/post/edit/{id}', 'AdminPostController@edit')->name('admin.post.edit');
    Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('admin.post.update');

    //=========================PAGE=============================================
    Route::get('admin/page/list', 'AdminPageController@index')->name('admin.page.index');
    Route::get('admin/page/create', 'AdminPageController@create')->name('admin.page.create');
    Route::post('admin/page/create', 'AdminPageController@store')->name('admin.page.store');
    Route::post('admin/page/action', 'AdminPageController@action')->name('admin.page.action');
    Route::get('admin/page/edit/{id}', 'AdminPageController@edit')->name('admin.page.edit');
    Route::post('admin/page/update/{id}', 'AdminPageController@update')->name('admin.page.update');
    Route::get('admin/page/destroy/{id}', 'AdminPageController@destroy')->name('admin.page.destroy');


    //=========================SLIDERS=============================================
    Route::get('admin/slider/index', 'AdminSliderController@index')->name('admin.slider.index');
    Route::get('admin/slider/action', 'AdminSliderController@action')->name('admin.slider.action');
    Route::get('admin/slider/create', 'AdminSliderController@create')->name('admin.slider.create');
    Route::post('admin/slider/create', 'AdminSliderController@store')->name('admin.slider.store');
    Route::get('admin/slider/edit/{id}', 'AdminSliderController@edit')->name('admin.slider.edit');
    Route::post('admin/slider/update/{id}', 'AdminSliderController@update')->name('admin.slider.update');
    Route::get('admin/slider/destroy/{id}', 'AdminSliderController@destroy')->name('admin.slider.destroy');
});
