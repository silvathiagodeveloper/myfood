<?php

use App\Http\Controllers\Admin\ACL\PlanProfileController;
use App\Http\Controllers\Admin\ACL\ProfilePermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetailPlanController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth', 'verified'])
    ->middleware(['password.confirm'])
    ->group(function () {
    /**
     * Home
     */
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    
    /**
     * Plans Routes
     */
    Route::any('plans/search',      [PlanController::class, 'search']   )->name('plans.search');
    Route::get('plans',             [PlanController::class, 'index']    )->name('plans.index');
    Route::get('plans/create',      [PlanController::class, 'create']   )->name('plans.create');
    Route::post('plans',            [PlanController::class, 'store']    )->name('plans.store');
    Route::put('plans/{url}',       [PlanController::class, 'update']   )->name('plans.update');
    Route::get('plans/{url}',       [PlanController::class, 'show']     )->name('plans.show');
    Route::get('plans/{url}/edit',  [PlanController::class, 'edit']     )->name('plans.edit');
    Route::delete('plans/{id}',     [PlanController::class, 'destroy']  )->name('plans.destroy');

    /**
     * DetailPlans Routes
     */
    Route::any('plans/{url}/search',            [DetailPlanController::class, 'search'] )->name('details.plans.search');
    Route::get('plans/{url}/details',           [DetailPlanController::class, 'index']  )->name('details.plans.index');
    Route::get('plans/{url}/details/create',    [DetailPlanController::class, 'create'] )->name('details.plans.create');
    Route::post('plans/{url}/details',          [DetailPlanController::class, 'store']  )->name('details.plans.store');
    Route::put('plans/{url}/details/{id}',      [DetailPlanController::class, 'update'] )->name('details.plans.update');
    Route::get('plans/{url}/details/{id}',      [DetailPlanController::class, 'show']   )->name('details.plans.show');
    Route::get('plans/{url}/details/{id}/edit', [DetailPlanController::class, 'edit']   )->name('details.plans.edit');
    Route::delete('plans/{url}/details/{id}',   [DetailPlanController::class, 'destroy'])->name('details.plans.destroy');

    /**
     * Profiles Routes
     */
    Route::any('profiles/search',           [ProfileController::class, 'search']    )->name('profiles.search');
    Route::get('profiles',                  [ProfileController::class, 'index']     )->name('profiles.index');
    Route::get('profiles/create',           [ProfileController::class, 'create']    )->name('profiles.create');
    Route::post('profiles',                 [ProfileController::class, 'store']     )->name('profiles.store');
    Route::put('profiles/{url}',            [ProfileController::class, 'update']    )->name('profiles.update');
    Route::get('profiles/{url}',            [ProfileController::class, 'show']      )->name('profiles.show');
    Route::get('profiles/{url}/edit',       [ProfileController::class, 'edit']      )->name('profiles.edit');
    Route::delete('profiles/{id}',          [ProfileController::class, 'destroy']   )->name('profiles.destroy');

    /**
     * Permissions Routes
     */
    Route::any('permissions/search',        [PermissionController::class, 'search']    )->name('permissions.search');
    Route::get('permissions',               [PermissionController::class, 'index']     )->name('permissions.index');
    Route::get('permissions/create',        [PermissionController::class, 'create']    )->name('permissions.create');
    Route::post('permissions',              [PermissionController::class, 'store']     )->name('permissions.store');
    Route::put('permissions/{url}',         [PermissionController::class, 'update']    )->name('permissions.update');
    Route::get('permissions/{url}',         [PermissionController::class, 'show']      )->name('permissions.show');
    Route::get('permissions/{url}/edit',    [PermissionController::class, 'edit']      )->name('permissions.edit');
    Route::delete('permissions/{id}',       [PermissionController::class, 'destroy']   )->name('permissions.destroy');

    /**
     * Profiles X Permissions Routes
     */
    Route::any('profiles/{id}/permissions/search', [ProfilePermissionController::class, 'searchPermissions']    )->name('profiles.permissions.search');
    Route::get('profiles/{id}/permissions',        [ProfilePermissionController::class, 'permissions']          )->name('profiles.permissions');
    Route::any('profiles/{id}/permissions/create', [ProfilePermissionController::class, 'permissionsAvailable'] )->name('profiles.permissions.create');
    Route::post('profiles/{id}/permissions',       [ProfilePermissionController::class, 'permissionsAttach']    )->name('profiles.permissions.attach');
    Route::get('profiles/{id}/permissions/{permission}/detach', [ProfilePermissionController::class, 'permissionsDetach'])->name('profiles.permissions.detach');
    Route::any('permissions/{id}/profiles/search', [ProfilePermissionController::class, 'searchProfiles']       )->name('permissions.profiles.search');
    Route::get('permissions/{id}/profiles',        [ProfilePermissionController::class, 'profiles']             )->name('permissions.profiles');

    /**
     * Plans X Profiles Routes
     */
    Route::any('plans/{id}/profiles/search', [PlanProfileController::class, 'searchProfiles']    )->name('plans.profiles.search');
    Route::get('plans/{id}/profiles',        [PlanProfileController::class, 'profiles']          )->name('plans.profiles');
    Route::any('plans/{id}/profiles/create', [PlanProfileController::class, 'profilesAvailable'] )->name('plans.profiles.create');
    Route::post('plans/{id}/profiles',       [PlanProfileController::class, 'profilesAttach']    )->name('plans.profiles.attach');
    Route::get('plans/{id}/profiles/{permission}/detach', [PlanProfileController::class, 'profilesDetach'])->name('plans.profiles.detach');
    Route::any('profiles/{id}/plans/search', [PlanProfileController::class, 'searchPlans']       )->name('profiles.plans.search');
    Route::get('profiles/{id}/plans',        [PlanProfileController::class, 'plans']             )->name('profiles.plans');
});

    Route::get('/', [SiteController::class, 'index']             )->name('site.home');

require __DIR__.'/auth.php';