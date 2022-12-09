<?php

use App\Http\Controllers\Api\V1\Auth\ClientController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\TenantController;
use App\Http\Controllers\Api\V1\TableController;
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

Route::middleware(['auth:sanctum'])
     ->group(function () {
         Route::get('/clients/auth', [ClientController::class, 'me']);
         Route::get('/clients/logout', [ClientController::class, 'logout']);

         Route::get('/tenants/{uuid}', [TenantController::class, 'show']);
         Route::get('/tenants', [TenantController::class, 'index']);

         Route::get('/my-orders', [OrderController::class, 'myOrders']);
     });

Route::middleware(['auth:sanctum', 'tenant.set', 'tenant.forget'])
     ->group(function () {       
      Route::get('/categories/{uuid}', [CategoryController::class, 'show']);
      Route::get('/categories',       [CategoryController::class, 'index']);

      Route::get('/tables/{uuid}', [TableController::class, 'show']);
      Route::get('/tables',       [TableController::class, 'index']);

      Route::get('/products/{uuid}', [ProductController::class, 'show']);
      Route::get('/products',       [ProductController::class, 'index']);

      Route::get('/categories/{uuid}/products', [ProductCategoryController::class, 'products']);

      Route::get('/orders', [OrderController::class, 'index']);
      Route::post('/orders', [OrderController::class, 'store']);
      Route::get('/orders/{uuid}', [OrderController::class, 'show']);
     });