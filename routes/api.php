<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexCotroller;
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

Route::post('/', [IndexCotroller::class, 'main']);

Route::post('/application', [IndexCotroller::class, 'application']);
Route::post('/applicationjob', [IndexCotroller::class, 'applicationjob']);

Route::post('/items', [IndexCotroller::class, 'items']);
