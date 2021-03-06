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

//Comments and likes
Route::post('/add-comment', 'CommentController@create')->name('front.add-comment');
Route::post('/like-comment', 'LikeController@create')->name('front.like-comment');

//Reads and shares
Route::get('/add-read', 'ReadController@create')->name('front.add-read');

//Polls and Votes
Route::post('/add-vote', 'VoteController@store')->name('front.add-vote');
Route::get('/get-poll-results/{id}', 'VoteController@show')->name('front.get-poll-results');

//Category routes
//Route::get('/{parent_url}', 'IndexController@get_parent_category')->name('front.parent');
//Route::get('/{parent_url}/{child_url}', 'IndexController@get_child_category')->name('front.child');

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
  Route::get('/reset-cat-table', 'CategoryController@reset_table')->name('admin.reset-cat-table');
  Route::post('/create-category', 'CategoryController@store')->name('admin.create-category');
  Route::get('/remove-category/{id}', 'CategoryController@destroy')->name('admin.remove-category');
  Route::get('/edit-category/{id}', 'CategoryController@edit')->name('admin.edit-category');
  Route::post('/update-category', 'CategoryController@update')->name('admin.update-category');

  //News routes
  Route::get('/news', 'NewsController@index')->name('admin.all-news');
  //Route::get('/news', 'NewsController@index')->name('admin.all-news');
  Route::get('/news/{unique}', 'NewsController@single_news')->name('admin.single-news');
  Route::get('/news/edit/{unique}', 'NewsController@edit')->name('admin.edit-news');
  Route::put('/news/update/{id}', 'NewsController@update')->name('admin.update-news');
  Route::post('/update-cover', 'NewsController@update_cover')->name('admin.update-cover');
  Route::delete('/delete-news/{id}', 'NewsController@destroy')->name('admin.delete-news');
  Route::get('/add-news', 'NewsController@create')->name('admin.add-news');
  Route::get('/add-images-to-news/{id}', 'NewsImageController@add_images_page')->name('admin.add-images-to-news');
  Route::post('/add-news-images', 'NewsImageController@store')->name('admin.add-news-images');
  Route::post('/add-news', 'NewsController@store')->name('admin.store-news');
  Route::post('/upload-news-photo', 'NewsImageController@create')->name('admin.upload-news-photo');
  Route::get('/edit-news-photos/{unique}', 'NewsImageController@edit')->name('admin.edit-news-photos');
  Route::delete('/delete-news-photo/{folder}/{image}/{id}', 'NewsImageController@destroy')->name('admin.delete-news-photo');
  Route::delete('/delete-news-photo-folder/{folder}/{news_id}', 'NewsImageController@destroyFolder')->name('admin.delete-news-photo-folder');
  Route::put('/news/update-news-images/{id}', 'NewsImageController@update')->name('admin.update-news-images');

  //Admin profiles
  Route::get('/profiles/{id}', 'AdminController@profile')->name('admin.admin-profile');

  //Poll routes
  Route::get('/polls', 'PollController@index')->name('admin.all-polls');
  Route::get('/add-poll', 'PollController@create')->name('admin.add-poll');
  Route::post('/add-poll', 'PollController@store')->name('admin.create-poll');
  Route::post('/populate-news', 'PollController@populate_news')->name('admin.populate-news');
});

// Front Category routes
Route::get('/{parent_url}', 'IndexController@get_parent_category')->name('front.parent');
Route::get('/{parent_url}/{child_url}', 'IndexController@get_child_category')->name('front.child');

//Route::get('/{parent_url}/{child_url}/{url}', 'IndexController@show_news')->name('front.show-news');

Route::get('/{parent_url}/{child_url}/{url}', 'IndexController@show_news');
Route::get('/{child_url}/{url}', 'IndexController@show_news');
