<?php

use App\Http\Controllers\Education\StationeryController;
use App\Http\Controllers\Feeding\KitchenSetController;
use App\Http\Controllers\Health\MedicalToolsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Health\PatientController;
use App\Http\Controllers\Health\MedicineController;
use App\Http\Controllers\Feeding\FoodSectionController;
use App\Http\Controllers\Feeding\FoodParcelController;
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
//______________________________________________________________________________________________________________________
Route::post('/register',[UserController::class,'register'])->withoutMiddleware('auth:sanctum');
Route::post('/login',[UserController::class,'login'])->withoutMiddleware('auth:sanctum');
Route::post('/logout',[UserController::class,'logout']);
//______________________________________________________________________________________________________________________
Route::group(['prefix' => 'wallet'],function(){
    Route::get('show',[\App\Http\Controllers\WalletController::class,'show_wallet']);
    Route::post('charge',[\App\Http\Controllers\WalletController::class,'charge_wallet']);
});
//______________________________________________________________________________________________________________________
//Health

//patient
Route::group(['prefix' => 'patient'], function(){
    Route::get('/show' , [PatientController::class,'IncompletePatient']);
    Route::post('/donate/{patient}' , [PatientController::class, 'DonatePatient']);
});
//medicine
Route::group(['prefix' => 'medicine'], function(){
    Route::get('/show' , [MedicineController::class,'ShowIncomplete']);
    Route::post('/donate/{medicine}' , [MedicineController::class, 'Donate']);
});
//medical_tool:
Route::group(['prefix' => 'medical_tools'], function(){
    Route::get('/show' , [MedicalToolsController::class,'Incomplete_medical']);
    Route::post('/donate/{medicalTool}' , [MedicalToolsController::class, 'DonateMedicalTool']);
});
//______________________________________________________________________________________________________________________
//Feeding
//Food Parcel
Route::group(['prefix' => 'food_parcel'], function(){
    Route::get('/show' , [FoodParcelController::class,'show']);
    Route::post('/donate/{foodParcel}' , [FoodParcelController::class, 'Donate']);
});
//Food Section
Route::group(['prefix' => 'food_section'], function(){
    Route::get('/show' , [FoodSectionController::class,'ShowIncomplete']);
    Route::post('/donate/{foodSection}' , [FoodSectionController::class, 'Donate']);
});
//Kitchen set:
Route::group(['prefix' => 'kitchen_set'], function(){
    Route::get('/show' , [KitchenSetController::class,'Incomplete_kitchen_set']);
    Route::post('/donate/{kitchen_set}' , [KitchenSetController::class, 'Donate_kitchen_set']);
});
//--------------------------------------------------------------------------------------------------------------------------
//Stationery:
Route::group(['prefix' => 'stationery'], function(){
    Route::get('/show' , [StationeryController::class,'show_stationery']);
    Route::post('/donate/{stationery}' , [StationeryController::class, 'Donate_stationery']);
});
//--------------------------------------------------------------------------------------------------------------------------
//guarantee
    Route::group(['prefix'=>'guarantee'],function(){
        Route::get('/show',[\App\Http\Controllers\Education\GuaranteeController::class,'show_unguranteed']);
        Route::get('/sort/{method}',[\App\Http\Controllers\Education\GuaranteeController::class,'sort']);
        Route::post('/search',[\App\Http\Controllers\Education\GuaranteeController::class,'search']);
        Route::post('/donate/{guarantee}',[\App\Http\Controllers\Education\GuaranteeController::class,'donate']);
        Route::get('/user_guarantee',[\App\Http\Controllers\Education\GuaranteeController::class,'user_guarantee']);
    });
//--------------------------------------------------------------------------------------------------------------------------
Route::group(['prefix'=>'volunteer'],function (){
    Route::post('/submit',[\App\Http\Controllers\VolunteerController::class,'volunteer']);
});
Route::group(['prefix'=>'resignation'],function (){
    Route::post('/submit',[\App\Http\Controllers\VolunteerController::class,'SubmitResignation']);
});

Route::post('direct_donate',[\App\Http\Controllers\DonateController::class,'donate']);
    
    Route::group(['prefix'=>'email'],function (){
        Route::post('/random_code',[\App\Http\Controllers\UserController::class,'random_code'])->withoutMiddleware(['auth:sanctum']);
        Route::post('/check_code',[\App\Http\Controllers\UserController::class,'check_code'])->withoutMiddleware(['auth:sanctum']);
        Route::post('/reset_password',[\App\Http\Controllers\UserController::class,'reset_password'])->withoutMiddleware(['auth:sanctum']);
//    Route::get('/email_verify/{id}',[\App\Http\Controllers\UserController::class,'email_verify']);
    
    });
