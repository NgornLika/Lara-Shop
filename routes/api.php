<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\frontend\HomeController;
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


Route::post('/login',       [ApiController::class, 'userLogin']);



Route::middleware('auth:sanctum')->group( function () {
    
    Route::get('/logo',           [ApiController::class, 'GetWebSiteLogo']);
    Route::post('/add-logo',      [ApiController::class, 'AddWebSiteLogo']);
    Route::post('/update-logo',   [ApiController::class, 'UpdateWebSiteLogo']);
    Route::post('/remove-logo',   [ApiController::class, 'RemoveLogo']);

    Route::post('/add-product',      [ApiController::class, 'addProduct']);
    Route::get('/products',          [ApiController::class, 'listProducts']);
    Route::post('/update-product',   [ApiController::class, 'UpdateProduct']);
    Route::post('/remove-product',   [ApiController::class, 'RemoveProduct']);
    Route::get('/product/{slug}',    [ApiController::class, 'productDetail']);

    Route::post('/add-news',       [ApiController::class, 'addNews']);
    Route::get('/list-news',       [ApiController::class, 'listNews']);
    Route::post('/update-news',    [ApiController::class, 'updateNews']);   
    Route::post('/remove-news',    [ApiController::class, 'RemoveNews']);
    Route::get('/news/{slug}',    [ApiController::class, 'newsDetail']);

    Route::get('/get-category',         [ApiController::class, 'getCategory']);
    Route::get('/get-attribute/{type}', [ApiController::class, 'getAttribute']);

});


