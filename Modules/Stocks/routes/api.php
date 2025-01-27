<?php

use Illuminate\Support\Facades\Route;
use Modules\Stocks\Http\Controllers\StockTransferController;
use Modules\Stocks\Http\Controllers\StockReceivingController;
use Modules\Stocks\Http\Controllers\StockAdjustmentController;

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
    ['middleware' => 'siteuser', "prefix" => "stocks"],
    function () {

        Route::prefix('transfer')->group(function () {
            Route::get('list', [StockTransferController::class, 'list']);
            Route::post('create', [StockTransferController::class, 'create']);
            Route::post('update', [StockTransferController::class, 'update']);
        });

        Route::prefix('receiving')->group(function () {
            Route::get('list', [StockReceivingController::class, 'list']);
            Route::post('create', [StockReceivingController::class, 'create']);
            Route::post('update', [StockReceivingController::class, 'update']);
        });

        // Route::prefix('adjustment')->group(function () {
        //     Route::get('list', [StockAdjustmentController::class, 'list']);
        //     Route::post('create', [StockAdjustmentController::class, 'create']);
        //     Route::post('update', [StockAdjustmentController::class, 'update']);
        // });
    }
);