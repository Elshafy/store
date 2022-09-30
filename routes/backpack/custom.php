<?php

use App\Http\Controllers\Api\ReportController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
//  api route
Route::get('api/customer/{id}', [ReportController::class, 'customerRecord']);
Route::get('api/supplier/{id}', [ReportController::class, 'supplierRecord']);

// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('category', 'CategoryCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('export', 'ExportCrudController');
    Route::crud('import', 'ImportCrudController');
    Route::middleware(['can:editItem,App\Models\Item'])->group(function () {
        Route::crud('item', 'ItemCrudController');
    });
    Route::get('item/{id}/changeState', 'ItemCrudController@changeState')->can('activeItem', Item::class);
    Route::crud('supplier', 'SupplierCrudController');
    Route::crud('user', 'UserCrudController');
}); // this should be the absolute last line of this file
