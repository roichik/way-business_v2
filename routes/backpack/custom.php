<?php

use App\Http\Controllers\Admin\CompanyStructure\CompanyCrudController;
use App\Http\Controllers\Admin\CompanyStructure\DivisionCrudController;
use App\Http\Controllers\Admin\CompanyStructure\PositionCrudController;
use App\Http\Controllers\Admin\Security\PermissionCrudController;
use App\Http\Controllers\Admin\Security\RoleCrudController;
use App\Http\Controllers\Admin\Security\AccessGroupCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Admin\CompanyStructureTypeCrudController;
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

    Route::crud('/users', UserCrudController::class);
    Route::crud('/permissions', PermissionCrudController::class);
    Route::crud('/roles', RoleCrudController::class);
    Route::crud('/access-group', AccessGroupCrudController::class);

    Route::crud('/companies', CompanyCrudController::class);
    Route::crud('/divisions', DivisionCrudController::class);
    Route::crud('/positions', PositionCrudController::class);

    //Route::crud('company-structure/types', CompanyStructureTypeCrudController::class);
    /*
    foreach(\App\Models\CompanyStructureType::get() as $companyStructure){
        Route::crud('company-structure/' . $companyStructure->slug, CompanyStructureCrudController::class);
    }
    */

});
