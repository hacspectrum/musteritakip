<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controller('/auth', 'UsersController');

Route::get('/', function () {
    return view('login');
});

Route::group(['before' => 'auth'], function () {
    Route::controller('/customers', 'CustomersController');
	Route::controller('/orders', 'OrdersController');
	Route::controller('/products', 'ProductsController');
	Route::controller('/areas', 'AreasController');
	Route::controller('/transactions', 'TransactionsController');
	Route::controller('/reports', 'ReportsController');
});

Route::controller('/data', 'DatatableController');
Route::controller('/company', 'CompanyController');