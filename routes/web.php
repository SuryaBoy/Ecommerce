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

// admin panel route

Route::view('/admin', 'admin.dashboard')->name('adminpanel')->middleware('auth');

Route::resource('categories','CategoriesController');
Route::get('categories/destroy/{id}','CategoriesController@destroy');
Route::resource('subcategories','SubCategoriesController');
Route::get('subcategories/destroy/{id}','SubCategoriesController@destroy');

Route::resource('brand','BrandController');
Route::get('brand/destroy/{id}','BrandController@destroy');

Route::resource('product','ProductController');
Route::get('product/destroy/{id}','ProductController@destroy');

Route::get('admin/dashboard','AdminController@index')->name('admin.index');
