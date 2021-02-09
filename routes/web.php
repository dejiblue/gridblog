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

Route::get('/', 'PostController@index')->name('landing_page');

Route::get('/posts', 'PostController@index')->name('landing_page');

Route::get('/search', 'PostController@searchBlog')->name('search_blog');

Route::get('/post/{post_id}', 'PostController@viewPost')->name('view_post');

Route::post('/post/rate', 'PostController@rateBlog')->name('rate_post');



Auth::routes();

Route::get('/home', 'BlogController@index')->name('home');

Route::get('/registered/users', 'BlogController@getRegisteredUsers')->name('registered_users');

Route::get('/all/posts', 'BlogController@listPost')->name('all_posts');

Route::get('/create/post', 'BlogController@createPost')->name('create_post');

Route::post('/store/post', 'BlogController@storePost')->name('store_post');

Route::get('/edit/post/{post_id}', 'BlogController@editPost')->name('edit_post_form');

Route::put('/update/post/{post_id}', 'BlogController@updatePost')->name('update_post');

Route::delete('/delete/post/{post_id}', 'BlogController@deletePost')->name('delete_post');
