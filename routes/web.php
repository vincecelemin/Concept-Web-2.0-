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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::resource('/products', 'ProductsController');
Route::post('/products/{id}/restore', 'ProductsController@restore');
Route::put('/products/{id}/restock', 'ProductsController@restock');
Route::get('/orders', 'OrdersController@index');
Route::post('/orderinfo/{id}', 'OrderAjaxController@index');