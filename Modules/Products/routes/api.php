<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\BranchController;
use Modules\Products\Http\Controllers\CategoryController;
use Modules\Products\Http\Controllers\ProductsController;
use Modules\Products\Http\Controllers\SupplierController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::group(
    ['middleware' => 'siteuser', "prefix" => "products"],
    function () {
        Route::get('list', [ProductsController::class, 'list']);
        Route::post('create', [ProductsController::class, 'create']);
        Route::post('insert/items', [ProductsController::class, 'insertItems']);
    }
);

Route::group(
    ['middleware' => 'siteuser', "prefix" => "categories"],
    function () {
        Route::get('list', [CategoryController::class, 'list']);
        Route::post('create', [CategoryController::class, 'create']);
    }
);

Route::group(
    ['middleware' => 'siteuser', "prefix" => "branches"],
    function () {
        Route::get('list', [BranchController::class, 'list']);
        Route::post('create', [BranchController::class, 'create']);
    }
);

Route::group(
    ['middleware' => 'siteuser', "prefix" => "suppliers"],
    function () {
        Route::get('list', [SupplierController::class, 'list']);
        Route::post('create', [SupplierController::class, 'create']);
    }
);