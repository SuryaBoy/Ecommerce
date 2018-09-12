<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/category','Api\CategoriesApiController@index')->name('Api.Category');
Route::get('/subcategory','Api\SubCategoriesApiController@index')->name('Api.SubCategory');
Route::get('/product/show/{product}','Api\ProductApiController@show')->name('Api.Product.Show');
Route::get('/product/search/','Api\ProductApiController@search')->name('Api.Product.Search');
Route::get('/product/{sub_cat}','Api\ProductApiController@index')->name('Api.Product');

Route::prefix('review')->group(function () {
	Route::post('commentstore','Api\ReviewApiController@storeComment')->name('Api.Review.Comment.Store')->middleware('auth:api');
	Route::get('/{product}','Api\ReviewApiController@index')->name('Api.Review');
});


Route::post('/accessToken','Api\UserApiController@accessToken')->name('Api.AccessToken');

Route::prefix('order')->group(function() {
	Route::post('store','Api\OrderApiController@store')->name('Api.Order.Store')->middleware('auth:api');
	Route::get('orderDetails/{order_id}','Api\OrderApiController@getOrderDetails')->name('Api.OrderDetails');
	Route::get('/{user_id}','Api\OrderApiController@getOrders')->name('Api.Orders')->middleware('auth:api');
});
Route::post('orderProduct/store','Api\OrderApiController@storeOrderProduct')->name('Api.OrderProduct.Store')->middleware('auth:api');
Route::post('payment/store','Api\PaymentApiController@store')->name('Api.Payment.Store')->middleware('auth:api');


//the below route is not needed
Route::post('cart/addItem','Api\CartApiController@addItem')->name('Api.Cart.AddItem');
Route::post('cart/updateItem','Api\CartApiController@updateItem')->name('Api.Cart.UpdateItem');
Route::post('cart/removeItem','Api\CartApiController@removeItem')->name('Api.Cart.RemoveItem');

