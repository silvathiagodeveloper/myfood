<?php

use App\Http\Controllers\Api\V1\Auth\ClientController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TenantController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/clients/auth', [ClientController::class, 'auth']);
Route::post('/clients', [ClientController::class, 'store']);

Route::middleware('auth:sanctum')
     ->group(function () {
        Route::get('/clients/auth', [ClientController::class, 'me']);
        Route::get('/clients/logout', [ClientController::class, 'logout']);

        Route::get('/tenants/{uuid}', [TenantController::class, 'show']);
        Route::get('/tenants', [TenantController::class, 'index']);
        
        Route::get('/categories/{url}', [CategoryController::class, 'show']);
        Route::get('/categories', [CategoryController::class, 'index']);
     });