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
Route::get('/marketingHasEmployees/create/{id}', ['uses' => 'MarketingHasEmployeeController@create']);
Route::get('/prospects/prospectSpk/{id}', ['as' => 'prospects.prospectSpk', 'uses' => 'ProspectController@prospectSpk']);
Route::get('/prospects/prospectDo/{id}', ['as' => 'prospects.prospectDo', 'uses' => 'ProspectController@prospectDo']);
Route::get('/prospects/spk/', ['as' => 'prospects.spk', 'uses' => 'ProspectController@spk']);
Route::get('/prospects/do/', ['as' => 'prospects.do', 'uses' => 'ProspectController@doo']);
Route::get('/sales/salesperleasing', ['as' => 'sales.salesperleasing', 'uses' => 'ProspectController@salesperleasing']);
Route::get('/sales/salespercolor', ['as' => 'sales.salespercolor', 'uses' => 'ProspectController@salespercolor']);
Route::get('/sales/salespermodel', ['as' => 'sales.salespermodel', 'uses' => 'ProspectController@salespermodel']);
Route::get('/sales/salesperformance', ['as' => 'sales.salesperformance', 'uses' => 'ProspectController@salesperformance']);
Route::get('/sales/salesactivity', ['as' => 'sales.salesactivity', 'uses' => 'ProspectController@salesactivity']);
Route::get('/marketingHasEmployees/formula/', ['as' => 'marketingHasEmployees.formula', 'uses' => 'MarketingHasEmployeeController@formula']);
// Route::get('/stocks/getChassis/{unitid}/{colorid}', ['as' => 'stocks.getChassis', 'uses' => 'StockController@getChassis']);
// Route::get('/stocks/getChassis', function(){
//     $unitid = Input::get('unitid');
//     $colorid = Input::get('colorid');
//
//     $stocks = Stock::where('unit_id', '=', $unitid)->get();
//
//     return Response::json($stocks);
// });
Route::put('/prospects/{id}/updateDo', ['as' => 'prospects.updateDo', 'uses' => 'ProspectController@updateDo']);
Route::put('/marketingHasEmployees/setformula/', ['as' => 'marketingHasEmployees.setformula', 'uses' => 'MarketingHasEmployeeController@setformula']);

Route::post('/stocks/getChassis/', ['as'=>'stocks.getChassis','uses'=>'StockController@getChassis']);
Route::post('/prospects/show/', ['as'=>'prospects.show','uses'=>'ProspectController@show']);
Route::post('/sales/salesperleasingajax', ['as' => 'sales.salesperleasingajax', 'uses' => 'ProspectController@salesperleasingajax']);
Route::post('/sales/salespercolorajax', ['as' => 'sales.salespercolorajax', 'uses' => 'ProspectController@salespercolorajax']);
Route::post('/sales/salespermodelajax', ['as' => 'sales.salespermodelajax', 'uses' => 'ProspectController@salespermodelajax']);
Route::post('/sales/salesperformanceajax', ['as' => 'sales.salesperformanceajax', 'uses' => 'ProspectController@salesperformanceajax']);
Route::post('/sales/salesactivityajax', ['as' => 'sales.salesactivityajax', 'uses' => 'ProspectController@salesactivityajax']);

Route::resource('branches', 'BranchController');
Route::resource('subBranches', 'SubBranchController');
Route::resource('positions', 'PositionController');
Route::resource('locations', 'LocationController');
Route::resource('pendors', 'PendorController');
Route::resource('unitModels', 'UnitModelController');
Route::resource('colors', 'ColorController');
Route::resource('units', 'UnitController');
Route::resource('leasings', 'LeasingController');
Route::resource('departements', 'DepartementController');
Route::resource('employees', 'EmployeeController');
Route::resource('marketingGroups', 'MarketingGroupController');
Route::resource('marketingHasEmployees', 'MarketingHasEmployeeController');
Route::resource('stocks', 'StockController');
Route::resource('statusStocks', 'StatusStockController');
Route::resource('statusProspects', 'StatusProspectController');
Route::resource('prospects', 'ProspectController');
Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
