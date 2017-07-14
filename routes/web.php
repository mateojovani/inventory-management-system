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
Route::get('/profile', 'MainController@showProfile');
Route::post('/profile', 'MainController@editProfile');

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

Route::post('/grid/unity', 'ConfigController@showUnityGrid');
Route::post('/configure/unity/delete', 'ConfigController@deleteUnity');
Route::post('/configure/unity/add', 'ConfigController@addUnity');
Route::post('/configure/unity/edit', 'ConfigController@editUnity');

Route::post('/grid/type', 'ConfigController@showTypeGrid');
Route::post('/configure/type/delete', 'ConfigController@deleteType');
Route::post('/configure/type/add', 'ConfigController@addType');
Route::post('/configure/type/edit', 'ConfigController@editType');

Route::post('/grid/vat', 'ConfigController@showVATGrid');
Route::post('/configure/vat/delete', 'ConfigController@deleteVAT');
Route::post('/configure/vat/add', 'ConfigController@addVAT');
Route::post('/configure/vat/edit', 'ConfigController@editVAT');


#RawMaterials
Route::get('/raw-materials', 'RawMaterialsController@show');
Route::get('/raw-materials/add', 'RawMaterialsController@showAdd');
Route::post('/raw-materials/add', 'RawMaterialsController@postAdd');
Route::post('/raw-materials/edit', 'RawMaterialsController@edit');
Route::post('/raw-materials/delete', 'RawMaterialsController@delete');
Route::post('/grid/raw-materials', 'RawMaterialsController@showGrid');
Route::post('/item-compound/add', 'RawMaterialsController@addToItemCompound');
Route::post('/item-compound/edit', 'RawMaterialsController@editItemCompound');

Route::get('/raw-materials/categories', 'RawMaterialsController@getCategories');
Route::get('/raw-materials/unities', 'RawMaterialsController@getUnities');
Route::get('/raw-materials/types', 'RawMaterialsController@getTypes');
Route::get('/raw-materials/vat', 'RawMaterialsController@getVAT');

#Products
Route::get('/products', 'ProductsController@show');
Route::get('/products/add', 'ProductsController@showAdd');
Route::get('/products/config/{id}', 'ProductsController@showConfig');
Route::post('/products/add', 'ProductsController@postAdd');
Route::post('/products/edit', 'ProductsController@edit');
Route::post('/products/delete', 'ProductsController@delete');
Route::post('/grid/products', 'ProductsController@showGrid');
Route::post('/grid/product/raw-materials', 'ProductsController@showGridForProduct');
Route::post('/product/raw-materials/get', 'ProductsController@getRawMaterials');
Route::post('/product/raw-materials/delete', 'ProductsController@deleteRawMaterials');

Route::get('/products/categories', 'ProductsController@getCategories');
Route::get('/products/unities', 'ProductsController@getUnities');
Route::get('/products/types', 'ProductsController@getTypes');
Route::get('/products/vat', 'ProductsController@getVAT');

/*
#Clients
Route::get('/clients', 'ClientsController@show');
Route::post('/grid/clients', 'ClientsController@showGrid');
Route::post('/clients/add', 'ClientsController@add');
Route::post('/clients/delete', 'ClientsController@delete');
Route::post('/clients/edit', 'ClientsController@edit');

#Furnishers
Route::get('/furnishers', 'FurnishersController@show');
Route::post('/grid/furnishers', 'FurnishersController@showGrid');
Route::post('/furnishers/add', 'FurnishersController@add');
Route::post('/furnishers/delete', 'FurnishersController@delete');
Route::post('/furnishers/edit', 'FurnishersController@edit');
*/

#Entrysheet
Route::get('/entrysheet', 'EntryController@show');
Route::get('/entrysheet/grid', 'EntryController@showGRID');
Route::post('/entrysheet/add', 'EntryController@addEntry');
Route::post('/entrysheet/grid', 'EntryController@grid');
Route::post('/entrysheet/delete', 'EntryController@delete');

#Outputsheet
Route::get('/outputsheet', 'OutController@show');
Route::get('/outputsheet/grid', 'OutController@showGRID');
Route::post('/outputsheet/add', 'OutController@addOut');
Route::post('/outputsheet/grid', 'OutController@grid');
Route::post('/outputsheet/control', 'OutController@control');
Route::post('/outputsheet/delete', 'OutController@delete');

#Report
Route::get('/report/entrysheets', 'ReportController@showEntrysReport');
Route::post('/report/entrysheets', 'ReportController@entrysReport');
Route::get('/report/entrysheet/{id}', 'ReportController@showEntryReport');
Route::post('/report/entrysheet', 'ReportController@entryReport');

Route::get('/report/outsheets', 'ReportController@showOutsReport');
Route::post('/report/outsheets', 'ReportController@outsReport');
Route::get('/report/outputsheet/{id}', 'ReportController@showOutReport');
Route::post('/report/outputsheet', 'ReportController@outReport');

#Files
Route::get('/file/report/entrysheet/{file}', 'MainController@getEntryReport');
Route::get('/file/report/outputsheet/{file}', 'MainController@getOutReport');