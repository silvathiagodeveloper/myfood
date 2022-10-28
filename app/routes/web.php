<?php

use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('plans/{url}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
    Route::delete('plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');
});

Route::get('/', function () {
    return view('welcome');
});
