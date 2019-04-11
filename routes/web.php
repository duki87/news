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

Route::get('/', 'IndexController@index')->name('start');

Auth::routes();

//FRONT ROUTES
Route::get('/home', 'HomeController@index')->name('index');
//User auth routes
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

//Category routes
// Route::get('/{parent_url}', 'IndexController@get_parent_category')->name('front.parent');
// Route::get('/{parent_url}/{child_url}', 'IndexController@get_child_category')->name('front.child');

//ADMIN ROUTES
Route::prefix('admin')->group(function() {

  //Admin auth routes
  Route::get('/', 'AdminController@index')->name('admin.index');
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login-form');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login-submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  //Super admin routes
  Route::get('/add-admin', 'AdminController@create')->name('admin.add-admin');
  Route::get('/admins', 'AdminController@admins')->name('admin.admins');
  Route::post('/add-admin', 'AdminController@store')->name('admin.store-admin');
  Route::get('/edit-admin/{id}', 'AdminController@edit')->name('admin.edit-admin');
  Route::get('/remove-admin/{id}', 'AdminController@remove')->name('admin.remove-admin');
  Route::get('/change-admin-status/{id}', 'AdminController@change_status')->name('admin.change-admin-status');

  //Admin reset password routes
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

  //Category routes
  Route::get('/categories', 'CategoryController@index')->name('admin.categories');
  Route::post('/create-category', 'CategoryController@store')->name('admin.create-category');
  Route::get('/remove-category/{id}', 'CategoryController@destroy')->name('admin.remove-category');
  Route::get('/edit-category/{id}', 'CategoryController@edit')->name('admin.edit-category');
  Route::post('/update-category', 'CategoryController@update')->name('admin.update-category');
});
