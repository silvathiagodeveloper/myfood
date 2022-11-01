<?php

use App\Http\Controllers\Admin\DetailPlanController;
use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    /**
     * Home
     */
    Route::get('/', [PlanController::class, 'index'])->name('admin.index');
    
    /**
     * DetailPlans Routes
     */
    Route::get('plans/{url}/details', [DetailPlanController::class, 'index'])->name('details.plans.index');
    Route::get('plans/{url}/details/create', [DetailPlanController::class, 'create'])->name('details.plans.create');
    Route::post('plans/{url}/details', [DetailPlanController::class, 'store'])->name('details.plans.store');
    Route::put('plans/{url}/details/{id}', [DetailPlanController::class, 'update'])->name('details.plans.update');
    Route::get('plans/{url}/details/{id}', [DetailPlanController::class, 'show'])->name('details.plans.show');
    Route::get('plans/{url}/details/{id}/edit', [DetailPlanController::class, 'edit'])->name('details.plans.edit');
    Route::delete('plans/{url}/details/{id}', [DetailPlanController::class, 'destroy'])->name('details.plans.destroy');


    /**
     * Plans Routes
     */
    Route::any('plans/search', [PlanController::class, 'search'])->name('plans.search');
    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
    Route::put('plans/{url}', [PlanController::class, 'update'])->name('plans.update');
    Route::get('plans/{url}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('plans/{url}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::delete('plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');
});

Route::get('/', function () {
    return view('welcome');
});
