<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class UserController extends Controller
{

    //

    public function sendResponse($data, $message, $status = 200){
        $response =[
            'data' => $data,
            'message' => $message
        ];
        return response()->json($response, $status);
     }

    public function __construct(){
        $this->middleware('auth:api', ['except'=>['managerLogin','captureInsuranceParty']]);
    }

    public function managerLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=> ['required','string'],
            'password' => ['required','string',
             Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);
        }

        if(!$token = auth()->attempt($validator->validated())){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Invalid login credentials'
            ], 400);

        }

         return $this-> createNewToken($token);
    }



    public function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user'=>auth()->user(),
            'message'=>'Logged in successfully.'
        ]);
    }


    public function captureInsuranceParty(Request $request){
        $validator = Validator::make($request->all(),[
           'insurance_company'=> ['required','string'],
           'surname' => ['required','string'],
           'othername' => ['required','string'],
           'gender'=>['required','string'],
           'dob'=>['required'],
           'vehicle_model'=>['required','string'],
           'vehicle_make'=>['required','string'],
           'vehicle_color'=>['required','string'],
           'vehicle_fuel_type'=>['required','string'],
           'vehicle_mileage'=>['required','string'],
           'vehicle_registered_date'=>['required'],
           'vehicle_no_seat'=>['required'],
           'vehicle_no_doors'=>['required'],
           'vehicle_transmission'=>['required'],
           'vehicle_engine_type'=>['required'],
           'vehicle_identification_number'=>['nullable','string'],
           'record_of_past_ownership'=>['required','string'],
           'vehicle_chassis_number'=>['required','string'],
           'phone_number'=>['required'],
           'vehicle_number' => ['required','string'],
           'vehicle_type' => ['required','string'],
           'use_of_vehicle' => ['required','string'],
           'cover_type' => ['required','string'],
           'inception_date' => ['required'],
           'expiring_date' => ['required']



       ]);

       if($validator->stopOnFirstFailure()->fails()){
           return $this->sendResponse([
               'success' => false,
               'data'=> $validator->errors(),
               'message' => 'Validation Error'
           ], 400);
       }

       $Id =IdGenerator::generate(['table'=>'insurances','field'=>'registrationId','length'=>10,'prefix'=>'RGHA-']);

    //   $insurance =
      Insurance::create(array_merge(
           ['registrationId'=>$Id],
           $validator-> validated()));

    //    $token = $insurance->createToken('token')->plainTextToken;


       return $this ->sendResponse([
           'success' => true,
        //    'access_token' =>$token,
        //    'token_type'=>'bearer',
            'message' =>'Insurer registered successfully.'

          ],200);
    }



}
