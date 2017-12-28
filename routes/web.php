<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('getCat','HomeController@getCat');

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


	// password reset
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')
			->name('admin.password.request');
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')
			->name('admin.password.email');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')
			->name('admin.password.reset');
});
