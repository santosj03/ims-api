<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchases\Http\Controllers\PurchasesController;

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
    ['middleware' => 'siteuser', "prefix" => "purchases"],
    function () {
        Route::get('list', [PurchasesController::class, 'list']);
        Route::post('create', [PurchasesController::class, 'create']);
        Route::post('update', [PurchasesController::class, 'update']);
    }
);