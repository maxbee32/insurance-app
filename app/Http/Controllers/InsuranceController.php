<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\RoadWorth;
use Illuminate\Http\Request;
use App\Models\VehicleDefects;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
        $this->middleware('auth:api',['except'=>['captureInsurance','searchInsurer','caputureVihecleDefects']]);
    }
    //
       public function captureInsurance(Request $request){
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

        $Id =IdGenerator::generate(['table'=>'insurances','field'=>'registrationid','length'=>10,'prefix'=>'RGHA-']);

      $insurance = Insurance::create(array_merge(
            ['registrationid'=>$Id],
            $validator-> validated()));

        $token = $insurance->createToken('token')->plainTextToken;
    echo($insurance);

        return $this ->sendResponse([
            'success' => true,
            // 'access_token' =>$token,
            // 'token_type'=>'bearer',
             'message' =>'Insurer registered successfully.'

           ],200);
     }




     public function searchInsurer($name){
        $result = Insurance::where('surname', 'LIKE', '%'. $name . '%')
        ->orWhere('othername','LIKE','%'.$name.'%')
        ->orWhere('vehicle_number','LIKE','%'.$name.'%')
        ->get(array('registrationId','surname','othername',
        'vehicle_number','expiring_date','vehicle_chassis_number','vehicle_model'));



        if (count($result)){
            return $this ->sendResponse([
                'success' => true,
                'data'=>$result,
                 'message' =>'Insurer found.'

               ],200);
        }
        else {
            return $this ->sendResponse([
                'success' => false,
                 'message' =>'No Data found.'

               ],200);
        }

     }




    public function captureRoadWorth(Request $request){
        $validator = Validator::make($request->all(), [
         'brakes'=>['required','string'],
         'coupling_devices'=>['required','string'],
         'lights'=>['required','string'],
         'horn'=>['required','string'],
         'mirrors'=>['required','string'],
         'seatbelts'=>['required', 'string'],
         'steering_mechanism'=>['required', 'string'],
         'tyres'=>['required', 'string'],
         'windsheild_wipers'=>['required', 'string'],
         'engine_oil_level'=>['required', 'string'],
         'first_aid_kit'=>['required', 'string'],
         'flashlight'=>['required', 'string'],
         'spare_fuses'=>['required', 'string'],
         'jack'=>['required', 'string'],
         'warning_triangles'=>['required', 'string'],
         'spare_tyre'=>['required', 'string'],
        ]);



        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);
        }

        RoadWorth::create(array_merge(
            ['insurance_id'=> optional(Auth()->insurances)->id],
            $validator-> validated(),

        ));

        return $this ->sendResponse([
            'success' => true,
             'message' =>'Road worth completed successfully.'

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

