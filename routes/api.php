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


});


Route::group(['middleware'=>'api',
              'prefix'=>'user/v1'
],function($router){


     Route::post("manager-login","App\Http\Controllers\UserController@managerLogin");

     Route::post("register-insurance","App\Http\Controllers\UserController@saveInsurance");

     Route::post("register-defects","App\Http\Controllers\InsuranceController@caputureVihecleDefects");

     Route::post("search/{name}","App\Http\Controllers\InsuranceController@searchInsurer");


 });


 Route::group(['middleware'=>['auth:sanctum'],
              'prefix'=>'user/v1'
],function($router){

    Route::post("register-insurer","App\Http\Controllers\InsuranceController@captureInsurance");

});
