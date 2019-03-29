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
    return view('index');
});

Auth::routes();

//FRONT ROUTES
Route::get('/home', 'HomeController@index')->name('index');
//User auth routes
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

//ADMIN ROUTES
Route::prefix('admin')->group(function() {

  //Admin auth routes
  Route::get('/', 'AdminController@index')->name('admin.index');
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login-form');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login-submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  //Super admin routes
  //Route::get('/add-admin', 'Auth\AdminLoginController@logout')->name('admin.add-admin');

  //Category routes
  Route::get('/categories', 'CategoryController@index')->name('admin.categories');
  Route::get('/add-category', 'CategoryController@create')->name('admin.add-category');
});
