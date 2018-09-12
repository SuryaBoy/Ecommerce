<?php

Route::domain('ok.ecommerce.dev')->group(function () {
    Route::get('/', function () {
        return "ok";
    });
});

Route::get('/', function () {
    return view('index');
})->name('index.page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout'); 

// admin panel route

//Route::view('/admin', 'admin.dashboard')->name('adminpanel')->middleware('auth');
Route::middleware(['auth:admin'])->group(function(){

	Route::resource('categories','CategoriesController');
	Route::resource('subcategories','SubCategoriesController');
	Route::resource('brand','BrandController');
	Route::resource('product','ProductController');
	Route::get('product/create/{brand}','ProductController@create_with_brand')->name('product.create.with.brand');

	Route::get('ajax/subcategories/{category}','AjaxController@subcategories')->name('ajax.subcategories');

	Route::prefix('order')->group(function(){
		Route::get('/showProcessingOrders','OrderController@showProcessingOrders')->name('order.showProcessingOrders');
		Route::get('/showShippingOrders','OrderController@showShippingOrders')->name('order.showShippingOrders');
		Route::get('/showDeliveredOrders','OrderController@showDeliveredOrders')->name('order.showDeliveredOrders');
		Route::get('/showOrderDetails/{order_id}','OrderController@showOrderDetails')->name('order.showOrderDetails');
		Route::put('/{order_id}','OrderController@updateOrder')->name('order.update');
		Route::delete('/{order_id}','OrderController@destroy')->name('order.destroy');
	});

	Route::put('payment/{payment}','PaymentController@update')->name('payment.update');

	Route::get('/search','SearchController@index')->name('search');
	Route::get('/search/suggest','SearchController@suggest')->name('search.suggest');

});

// admin routes
Route::prefix('admin')->group(function(){

	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');	
	Route::post('/logout','Auth\AdminLoginController@adminLogout')->name('admin.logout');

	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/create', 'AdminController@create')->name('admin.create');
	Route::post('/', 'AdminController@store')->name('admin.store');
	Route::get('/show', 'AdminController@show_admins')->name('admin.show');
	Route::delete('/destroy/{id}', 'AdminController@destroy')->name('admin.destroy');
	Route::get('/{admin}/edit', 'AdminController@edit')->name('admin.edit');
	Route::put('/{admin}', 'AdminController@update')->name('admin.update');

	// password reset
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')
			->name('admin.password.request');
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')
			->name('admin.password.email');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')
			->name('admin.password.reset');

	Route::resource('roles', 'RoleController');

	Route::resource('permissions', 'PermissionController');

});

//paypal payment
Route::post('api/paypal','Api\PaypalApiController@postPaymentWithpaypal')
	->name('api.post.paypal');
Route::get('api/paypal','Api\PaypalApiController@getPaymentStatus')->name('api.payment.status');


Route::view('/facebook','facebook');

Route::get('/paywithpaypal','PaypalController@payWithPaypal')->name('payWithPaypal');
Route::post('/paypal','PaypalController@postPaymentWithpaypal')->name('post.paypal');
Route::get('/paypal','PaypalController@getPaymentStatus')->name('payment.status');