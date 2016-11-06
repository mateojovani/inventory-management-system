<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'MainController@showHome');

#Auth
Route::get('/register', 'AuthController@getRegister');
Route::post('/register', 'AuthController@postRegister');
Route::get('/login', 'AuthController@getLogin');
Route::post('/login', 'AuthController@postLogin');
Route::get('/logout', 'AuthController@getLogout');

#Config
Route::get('/configure', 'ConfigController@show');
Route::get('/configure/items', 'ConfigController@getItems');
Route::post('/grid/categories', 'ConfigController@showCatGrid');
Route::post('/configure/category/delete', 'ConfigController@deleteCategory');
Route::post('/configure/category/add', 'ConfigController@addCategory');
Route::post('/configure/category/edit', 'ConfigController@editCategory');

#RawMaterials
Route::get('/raw-materials', 'RawMaterialsController@show');
Route::get('/raw-materials/add', 'RawMaterialsController@showAdd');
Route::post('/raw-materials/add', 'RawMaterialsController@postAdd');
Route::post('/raw-materials/edit', 'RawMaterialsController@edit');
Route::post('/raw-materials/delete', 'RawMaterialsController@delete');
Route::post('/grid/raw-materials', 'RawMaterialsController@showGrid');
Route::post('/item-compound/add', 'RawMaterialsController@addToItemCompound');

Route::get('/raw-materials/categories', 'RawMaterialsController@getCategories');
Route::get('/raw-materials/unities', 'RawMaterialsController@getUnities');
Route::get('/raw-materials/types', 'RawMaterialsController@getTypes');
Route::get('/raw-materials/vat', 'RawMaterialsController@getVAT');

#Products
Route::get('/products', 'ProductsController@show');
Route::get('/products/add', 'ProductsController@showAdd');
Route::post('/products/add', 'ProductsController@postAdd');
Route::post('/products/edit', 'ProductsController@edit');
Route::post('/products/delete', 'ProductsController@delete');
Route::post('/grid/products', 'ProductsController@showGrid');
Route::post('/grid/product/raw-materials', 'ProductsController@showGridForProduct');
Route::post('/product/raw-materials/delete', 'ProductsController@deleteRawMaterials');

Route::get('/products/categories', 'ProductsController@getCategories');
Route::get('/products/unities', 'ProductsController@getUnities');
Route::get('/products/types', 'ProductsController@getTypes');
Route::get('/products/vat', 'ProductsController@getVAT');
