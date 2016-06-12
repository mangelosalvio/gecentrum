<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Facades\Inventory;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    // Authentication routes...
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // Registration routes...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::get('products/search','ProductsController@search');
    Route::resource('products','ProductsController');


    Route::resource('categories','CategoriesController');
    Route::resource('warehouses','WarehousesController');
    Route::resource('suppliers','SuppliersController');
    Route::resource('customers','CustomersController');

    /**
     * Stocks Receiving
     */

    Route::resource('rr','StocksReceivingController');
    Route::post('rr/po','StocksReceivingController@searchPO');
    Route::post('rr/{id}/receivePO','StocksReceivingController@receivePO');

    Route::post('rr/{id}','StocksReceivingController@addProduct');
    Route::get('rr/{id}/detail/delete','StocksReceivingController@deleteDetail');


    /**
     * Purchase Order
     */

    Route::resource('po','PurchaseOrderController');
    Route::post('po/{id}','PurchaseOrderController@addProduct');
    Route::get('po/{id}/receive','PurchaseOrderController@receivePO');
    Route::post('po/{id}/receive','PurchaseOrderController@receive');
    Route::get('po/{id}/detail/delete','PurchaseOrderController@deleteDetail');
    Route::get('po/{id}/print','PurchaseOrderController@printTransaction');


    /**
     * Purchase Returns
     */

    Route::resource('purchase_returns','PurchaseReturnsController');
    Route::post('purchase_returns/{id}','PurchaseReturnsController@addProduct');
    Route::get('purchase_returns/{id}/detail/delete','PurchaseReturnsController@deleteDetail');

    /**
     * Warehouse Releases
     */

    Route::resource('warehouse_releases','WarehouseReleasesController');
    Route::post('warehouse_releases/{id}','WarehouseReleasesController@addProduct');
    Route::get('warehouse_releases/{id}/detail/delete','WarehouseReleasesController@deleteDetail');

    /**
     * Warehouse Releases
     */

    Route::resource('physical_counts','PhysicalCountsController');
    Route::post('physical_counts/{id}','PhysicalCountsController@addProduct');
    Route::get('physical_counts/{id}/detail/delete','PhysicalCountsController@deleteDetail');

    Route::controller('reports','ReportsController');

    /**
     * Delivery Receipts
     */

    Route::resource('delivery_receipts','DeliveryReceiptController');
    Route::post('delivery_receipts/{id}','DeliveryReceiptController@addProduct');
    Route::get('delivery_receipts/{id}/detail/delete','DeliveryReceiptController@deleteDetail');


});
