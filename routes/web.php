<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('products/index', 'API\ProductController@index');
Route::get('products/{product}/edit', 'API\ProductController@edit')->where('product', '[0-9]+');
Route::get('products/index/personal', 'API\ProductController@personalIndex');
Route::get('products/index/available', 'API\ProductController@availableIndex');
Route::get('products/index/takenByMe', 'API\ProductController@takenByMeIndex');
Route::patch('products/{product}/update', 'API\ProductController@update')->where('product', '[0-9]+');
Route::patch('products/{product}/take', 'API\ProductController@takeProduct')->where('product', '[0-9]+');
Route::post('products/post', 'API\ProductController@store');
Route::delete('products/{product}/destroy', 'API\ProductController@destroy')->where('product', '[0-9]+');