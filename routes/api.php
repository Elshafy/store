<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::get('customer/{id}', [ReportController::class, 'customerRecord'])->whereNumber('id');
// Route::get('supplier/{id}', [ReportController::class, 'supplierRecord'])->whereNumber('id');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('customer/{id}', [ReportController::class, 'customerRecord'])->whereNumber('id');
    Route::get('supplier/{id}', [ReportController::class, 'supplierRecord'])->whereNumber('id');
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});