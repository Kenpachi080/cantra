<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController as Articles;
use App\Http\Controllers\PortfolioController as PortfolioController;
use App\Http\Controllers\QuestionController as QuestionController;
use App\Http\Controllers\ApiController as ApiController;


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


Route::get('/article', [Articles::class, 'viewArticle']);
Route::get('/comment', [Articles::class, 'viewComment']);
Route::get('/portfolio', [PortfolioController::class, 'view']);
Route::get('/categoryes', [PortfolioController::class, 'categoryes']);
Route::post('/comment', [Articles::class, 'commentAdd']);
Route::get('/mainquestion', [QuestionController::class, 'main']);
Route::get('/childquestion', [QuestionController::class, 'child']);

Route::post('/callback', [ApiController::class, 'callback']);

Route::group(['prefix' => 'vacancy'], function () {
    Route::get('/type', [ApiController::class, 'typejobs']);
    Route::get('/simplejob', [ApiController::class, 'simplejob']);
    Route::post('/job', [ApiController::class, 'job']);
});

Route::get('/reviews', [ApiController::class, 'reviews']);
