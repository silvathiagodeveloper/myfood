<?php

use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/', [PlanController::class, 'index'])->name('admin.index');
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
