<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'api',
              'prefix'=>'v1'
],function($router){


    Route::post("admin-signup","App\Http\Controllers\AdminController@adminSignUp");

    Route::post("admin-login", "App\Http\Controllers\AdminController@adminLogin");

    Route::post("user-signup","App\Http\Controllers\AdminController@userSignUp");

    Route::post("select-insurer","App\Http\Controllers\AdminController@selectInsurer");

    Route::post("add-defect","App\Http\Controllers\AdminController@createNewDefects");


});


Route::group(['middleware'=>'api',
              'prefix'=>'user/v1'
],function($router){


     Route::post("manager-login","App\Http\Controllers\UserController@managerLogin");

     Route::post("register-insurer","App\Http\Controllers\InsuranceController@captureInsurance");

     Route::post("update-insurer/{id}","App\Http\Controllers\InsuranceController@updateInsurance");

     Route::post("search","App\Http\Controllers\InsuranceController@searchInsurer");

     Route::post("register-roadworth","App\Http\Controllers\RoadWorthController@captureRoadWorth");

     Route::post("register-defects","App\Http\Controllers\RoadWorthController@caputureVihecleDefects");


 });


