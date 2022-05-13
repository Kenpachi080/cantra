<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexCotroller;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;

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

Route::get('/', [IndexCotroller::class, 'main']);
Route::get('/partner', [IndexCotroller::class, 'partner']);
Route::get('/fake', [IndexCotroller::class, 'fake']);
Route::post('/application', [IndexCotroller::class, 'application']);
Route::post('/applicationjob', [IndexCotroller::class, 'applicationjob']);


Route::post('/items', [ItemController::class, 'items']);
Route::post('/item/review', [ItemController::class, 'item_review']);

Route::group(['prefix' => 'order'], function () {
    Route::post('/create', [OrderController::class, 'create']);
});
