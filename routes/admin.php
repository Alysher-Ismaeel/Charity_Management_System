<?php

    use App\Http\Controllers\Education\StationeryController;
    use App\Http\Controllers\Feeding\KitchenSetController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\Health\PatientController;
    use App\Http\Controllers\Health\MedicalToolsController;
    use App\Http\Controllers\Health\MedicineController;
    use App\Http\Controllers\Feeding\FoodSectionController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\Feeding\FoodParcelController;
    use App\Http\Controllers\Education\GuaranteeController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register ADMIN routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "auth:admin" middleware group.
    |
    */

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Auth
    Route::post('/register',[AdminController::class,'register'])->withoutMiddleware('auth:admin_api');
    Route::post('/login',[AdminController::class,'login'])->withoutMiddleware('auth:admin_api');
    Route::get('/logout',[AdminController::class,'logout']);
//______________________________________________________________________________________________________________________
    Route::post('section/add' , [CategoryController::class, 'Add']);
//______________________________________________________________________________________________________________________
//Health
    Route::group(['prefix' => 'patient'], function(){
        Route::post('/add' , [PatientController::class,'add_patient']);
        Route::get('/show' , [PatientController::class,'IncompletePatient']);
        Route::get('/complete' , [PatientController::class,'CompletePatient']);
        Route::post('/update/{patient}', [PatientController::class,'updatepatient']);
        Route::delete('/delete/{patient}',[PatientController::class,'delete']);
        Route::delete('/deleteComplete',[PatientController::class,'DeleteCompletePatient']);
    });
    Route::group(['prefix' => 'medicine'], function(){
        Route::post('/add' , [MedicineController::class,'add']);
        Route::get('/show' , [MedicineController::class,'ShowIncomplete']);
        Route::get('/complete' , [MedicineController::class,'ShowComplete']);
        Route::post('/update/{medicine}', [MedicineController::class,'update']);
        Route::delete('/delete/{medicine}',[PatientController::class,'delete']);
        Route::delete('/deleteComplete',[MedicineController::class,'DeleteComplete']);
    });
    Route::group(['prefix' => 'medical_tools'], function(){
        Route::post('/add' , [MedicalToolsController::class,'add_medical_tool']);
        Route::get('/show' , [MedicalToolsController::class,'Incomplete_medical']);
        Route::get('/complete' , [MedicalToolsController::class,'Complete_medical']);
        Route::post('/update/{medicalTool}', [MedicalToolsController::class,'update_medical']);
        Route::delete('/delete/{medicalTool}',[MedicalToolsController::class,'Delete_medical']);
        Route::delete('/deleteComplete',[MedicalToolsController::class,'DeleteComplete_medical']);
    });
//______________________________________________________________________________________________________________________
//feeding
    Route::group(['prefix' => 'food_parcel'],function(){
        Route::post('/add' , [FoodParcelController::class,'add']);
        Route::get('/show' , [FoodParcelController::class,'Show']);
        Route::post('/update/{foodParcel}', [FoodParcelController::class,'update']);
        Route::delete('/delete/{foodParcel}',[FoodParcelController::class,'delete']);
    });
    Route::group(['prefix' => 'food_section'],function(){
        Route::post('/add' , [FoodSectionController::class,'add']);
        Route::get('/show' , [FoodSectionController::class,'ShowIncomplete']);
        Route::get('/complete' , [FoodSectionController::class,'ShowComplete']);
        Route::post('/update/{foodParcel}', [FoodSectionController::class,'update']);
        Route::delete('/delete/{foodParcel}',[FoodSectionController::class,'delete']);
        Route::delete('/deleteComplete',[FoodSectionController::class,'DeleteComplete']);
    });
    Route::group(['prefix' => 'kitchen_set'], function(){
        Route::post('/add' , [KitchenSetController::class,'add_Kitchen_Set']);
        Route::get('/show' , [KitchenSetController::class,'Incomplete_kitchen_set']);
        Route::get('/complete' , [KitchenSetController::class,'Complete_kitchen_set']);
        Route::post('/update/{kitchen_set}', [KitchenSetController::class,'update_kitchen_set']);
        Route::delete('/delete/{kitchen_set}',[KitchenSetController::class,'Delete_kitchen_set']);
        Route::delete('/deleteComplete',[KitchenSetController::class,'DeleteComplete_kitchen_set']);
    });
//______________________________________________________________________________________________________________________
//Education:
    Route::group(['prefix' => 'guarantee'] , function(){
        Route::post('/add' , [GuaranteeController::class,'add']);
        Route::get('/show' , [GuaranteeController::class,'showAll']);
        Route::get('/show/guaranteed' , [GuaranteeController::class , 'show_guaranteed']);
        Route::get('/show/not_guaranteed' ,[GuaranteeController::class , 'show_unguranteed']);
        Route::post('/update/{guarantee}',[GuaranteeController::class,'update']);
        Route::delete('/delete/{guarantee}' , [GuaranteeController::class,'delete']);
        Route::post('/search' , [GuaranteeController::class,'search']);
        Route::get('/sort/{method}' , [GuaranteeController::class, 'sort']);
    });

    Route::group(['prefix' => 'stationery'], function(){
        Route::post('/add' , [StationeryController::class,'add_stationery']);
        Route::get('/show' , [StationeryController::class,'show_stationery']);
        Route::post('/update/{stationery}', [StationeryController::class,'update_stationery']);
        Route::delete('/delete/{stationery}',[StationeryController::class,'Delete_stationery']);
    });
//______________________________________________________________________________________________________________________
    Route::group(['prefix'=>'volunteer'],function (){
        Route::get('/requests',[\App\Http\Controllers\VolunteerController::class,'VolunteerRequests']);
        Route::get('/accept/{volunteer}',[\App\Http\Controllers\VolunteerController::class,'AcceptedRequests']);
        Route::delete('/reject/{volunteer}',[\App\Http\Controllers\VolunteerController::class,'RejectedRequests']);
        Route::get('/medical_team',[\App\Http\Controllers\VolunteerController::class,'MedicalTeam']);
        Route::get('/educational_team',[\App\Http\Controllers\VolunteerController::class,'EducationalTeam']);
        Route::get('/food_service_team',[\App\Http\Controllers\VolunteerController::class,'FoodServiceTeam']);
        Route::delete('/dismissal/{volunteer}',[\App\Http\Controllers\VolunteerController::class,'StaffDismissal']);
    });
    Route::group(['prefix'=>'resignation'],function (){
        Route::get('/requests',[\App\Http\Controllers\VolunteerController::class,'ResignationRequests']);
        Route::get('/accept/{resignation}',[\App\Http\Controllers\VolunteerController::class,'Accepted_resignation_requests']);
        Route::delete('/reject/{resignation}',[\App\Http\Controllers\VolunteerController::class,'Rejected_resignation_Requests']);
    
    });
//______________________________________________________________________________________________________________________
    Route::post('takeout',[\App\Http\Controllers\TakeoutController::class,'takeout']);
    Route::get('donate',[\App\Http\Controllers\DonateController::class,'show']);
    Route::group(['prefix'=>'charity_box'],function(){
        Route::post('/set_password',[\App\Http\Controllers\CharityBoxController::class,'set_password']);
        Route::get('/show',[\App\Http\Controllers\CharityBoxController::class,'show']);
        Route::post('/create',[\App\Http\Controllers\CharityBoxController::class,'create']);
    });
    
    



