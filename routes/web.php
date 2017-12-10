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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout'); 

// admin panel route

//Route::view('/admin', 'admin.dashboard')->name('adminpanel')->middleware('auth');

Route::resource('categories','CategoriesController');
Route::get('categories/destroy/{id}','CategoriesController@destroy');
Route::resource('subcategories','SubCategoriesController');
Route::get('subcategories/destroy/{id}','SubCategoriesController@destroy');

Route::resource('brand','BrandController');
Route::get('brand/destroy/{id}','BrandController@destroy');

Route::resource('product','ProductController');
Route::get('product/destroy/{id}','ProductController@destroy');


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
