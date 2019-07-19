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

Route::get('/', 'FrontendController@index');
Route::get('/san-pham-landing2', 'FrontendController@landing2');
Route::get('/san-pham-landing1', 'FrontendController@landing1');
Route::post('/saveContact', 'FrontendController@saveContact');
