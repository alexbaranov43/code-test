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
Route::get('products/index/personal', 'API\ProductController@personalIndex');
Route::get('products/index/personal', 'API\ProductController@personalIndex');
Route::post('products/post', 'API\ProductController@store');
Route::delete('products/{product}/destroy', 'API\ProductController@destroy')->where('product', '[0-9]+');