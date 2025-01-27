<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\OrdersController;

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
    ['middleware' => 'siteuser', "prefix" => "orders"],
    function () {
        Route::get('list', [OrdersController::class, 'list']);
        Route::post('create', [OrdersController::class, 'create']);
        Route::post('update', [OrdersController::class, 'update']);

        Route::get('rts/list', [OrdersController::class, 'list_rts']);
        Route::post('rts/create', [OrdersController::class, 'create_rts']);
        Route::post('rts/update', [OrdersController::class, 'update_rts']);
    }
);