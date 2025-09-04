<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\PermissionCrudController;
use App\Http\Controllers\Admin\RoleCrudController;
use App\Http\Controllers\Admin\CompanyStructureTypeCrudController;
//use App\Http\Controllers\Admin\CompanyStructureCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    if (config('backpack.base.setup_dashboard_routes')) {
        Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
    }

    Route::crud('users', UserCrudController::class);
    Route::crud('permissions', PermissionCrudController::class);
    Route::crud('roles', RoleCrudController::class);

    Route::crud('company-structure/types', CompanyStructureTypeCrudController::class);
    /*
    foreach(\App\Models\CompanyStructureType::get() as $companyStructure){
        Route::crud('company-structure/' . $companyStructure->slug, CompanyStructureCrudController::class);
    }
    */

});
