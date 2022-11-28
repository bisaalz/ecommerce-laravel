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

/** Frontend Routes */
Route::get('/', 'FrontendController@index')->name('homepage');
Route::get('/help-and-faq',function(){
    return view('home.faq');
})->name('help-faq');

Route::get('/about-us', function(){
    return view('home.about-us');
})->name('about-us');
Route::get('/contact-us', function(){
    return view('home.contact');
})->name('contact-us');

Route::post('/contact-us','FrontendController@submitFeedback')->name('submit-feedback');
Auth::routes();


Route::get('/register',function(){
    return view('home.register');
})->name('register');

Route::get('/product','ProductController@getAllProduct')->name('all-product-list');

Route::post('/register','UserController@registerUser')->name('register-user');
Route::get('/active/{token}','UserController@activateUser')->name('activate-user');
Route::get('/search', 'ProductController@getSearchResult')->name('search');
Route::get('/category/{slug}', 'CategoryController@getProductsBySlug')->name('category-list');
Route::get('/sub-category/{slug}','CategoryController@getProductByChildSlug')->name('child-cat-list');
Route::get('/product/{slug}', 'ProductController@getProductDetail')->name('product-detail');


Route::post('/cart/add', 'CartController@postCart');
Route::get('/cart/remove', 'CartController@removeFromCart');

Route::get('/cart', 'CartController@showCartList')->name('cart');
Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware(['auth','customer']);

Route::post('/review/{product_id}', 'ProductController@submitProductReview')->name('submit-review');

Route::group(['middleware'=>'auth'],  function(){
    Route::group(['prefix'=>'admin', 'middleware' => 'admin'], function(){
        Route::get('/', 'HomeController@admin')->name('admin');

        Route::resource('banner', 'BannerController');
        Route::resource('category', 'CategoryController');

        Route::resource('product','ProductController');
        Route::resource('user','UserController');

        Route::get('/profile','UserController@adminProfile')->name('admin-profile');
        Route::put('/profile/{id}', 'UserController@updateAdmin')->name('admin-update');

        Route::post('/category/child', 'CategoryController@getChildCategoryFromParent')->name('child-list');
    });


    Route::group(['prefix'=>'vendor', 'middleware' => 'vendor'], function(){
        Route::get('/', 'HomeController@vendor')->name('vendor');
        Route::get('/product','ProductController@getproductsByVendor')->name('vendor-product-list');
        
    });




    Route::group(['prefix'=>'user', 'middleware' => 'customer'], function(){
        Route::get('/', 'HomeController@customer')->name('user');
    });

});



Route::get('/home', 'HomeController@index')->name('home');
