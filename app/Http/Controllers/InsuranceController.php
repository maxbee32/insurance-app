<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\VehicleDefects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    public function sendResponse($data, $message, $status = 200){
        $response =[
            'data' => $data,
            'message' => $message
        ];
        return response()->json($response, $status);
     }

    public function __construct(){
        $this->middleware('auth:api', ['except'=>['captureInsurance','caputureVihecleDefects']]);
    }
    //
    public function captureInsurance(Request $request){
        $validator = Validator::make($request->all(), [
            'insurance_company'=> ['required','string'],
            'name_of_insurer' => ['required','string'],
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
            'vehicle_identification_number'=>['required'],
            'record_of_past_ownership'=>['required'],
            'vehicle_chassis_number'=>['required'],
            'phone_number'=>['required'],
            'vehicle_number' => ['required','string'],
            'vehicle_type' => ['required','string'],
            'use_of_vehicle' => ['required','string'],
            'cover_type' => ['required','string'],
            'inception_date' => ['required',],
            'expiring_date' => ['required',],
            'premium' => ['required','string'],


        ]);

        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);
        }

        Insurance::create(array_merge(
            $validator-> validated(),

        ));

        return $this ->sendResponse([
            'success' => true,
             'message' =>'Insurer registered successfully.'

           ],200);
     }




   public function caputureVihecleDefects(Request $request){
    $validator = Validator::make($request->all(), [
        'vehicle_registration_number'=>['required','string'],
        'vehicle_make'=>['required','string'],
        'contact_number'=>['required','string'],
        'vehicle_number'=>['required','string'],
        'vehicle_type'=>['required','string'],
        'use_of_vehicle'=>['required','string'],
    ]);


    if($validator->stopOnFirstFailure()-> fails()){
        return $this->sendResponse([
            'success' => false,
            'data'=> $validator->errors(),
            'message' => 'Validation Error'
        ], 400);
    }

    VehicleDefects::create(array_merge(
        $validator-> validated(),

    ));

    return $this ->sendResponse([
        'success' => true,
         'message' =>'Vehicle Defects registered successfully.'

       ],200);
 }

  }

