<?php

use App\Http\Controllers\PixController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'pix'], function () {
    Route::get('/', [PixController::class, 'index']);
    Route::get('/{id}', [PixController::class, 'find']);
    Route::patch('/{id}', [PixController::class, 'update']);
    Route::post('/', [PixController::class, 'create']);
});