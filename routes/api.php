<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'section'],function(){
    Route::get('/show',[CategoryController::class,'show']);
    Route::post('/add',[CategoryController::class,'Add']);
    Route::post('/update/{category}' , [CategoryController::class,'update']);
    Route::delete('/delete/{category}' , [CategoryController::class,'delete']);
});
