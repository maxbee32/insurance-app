<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Models\VehicleDefects;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('auth:api',['except'=>['captureInsurance','updateInsurance','searchInsurer']]);
    }
    //
       public function captureInsurance(Request $request){
         $validator = Validator::make($request->all(),[
            'insurance_company'=> ['required','string'],
            'surname' => ['required','string'],
            'othername' => ['required','string'],
            'vehicle_make'=>['required','string'],
            'vehicle_chassis_number'=>['required','string'],
            'phone_number'=>['required','regex:/^(\+\d{1,3}[- ]?)?\d{10}$/','min:10'],
            'vehicle_number' => ['required','string'],
            'use_of_vehicle' => ['required','string'],
            'cover_type' => ['required','string'],
            'inception_date' => ['required'],
            'expiring_date' => ['required'],
            'premium' => ['required']



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


        return $this ->sendResponse([
            'success' => true,
            'access_token' =>$token,
            'token_type'=>'bearer',
             'message' =>'Insurer registered successfully.'

           ],200);
     }

     public function updateInsurance(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'insurance_company' => ['required','string'],
            'surname' => ['required','string'],
            'othername' => ['required','string'],
            'vehicle_make'=>['required','string'],
            'vehicle_chassis_number'=>['required','string'],
            'phone_number'=>['required','regex:/^(\+\d{1,3}[- ]?)?\d{10}$/','min:10'],
            'vehicle_number' => ['required','string'],
            'use_of_vehicle' => ['required','string'],
            'cover_type' => ['required','string'],
            'inception_date' => ['required','date'],
            'expiring_date' => ['required','date'],
            'premium' => ['required']
        ]);

        if($validator->stopOnFirstFailure()->fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);
}

         DB::table('insurances')
        ->where('id', $id)
        ->update(['insurance_company' => $request->insurance_company,
                  'surname'=> $request->surname,
                  'othername'=>$request->othername,
                  'vehicle_make'=> $request->vehicle_make,
                  'vehicle_chassis_number'=>$request->vehicle_chassis_number,
                  'phone_number'=>$request->phone_number,
                  'vehicle_number'=>$request->vehicle_number,
                  'use_of_vehicle'=>$request->use_of_vehicle,
                  'cover_type'=>$request->cover_type,
                  'inception_date' => $request->inception_date,
                  'expiring_date' => $request->expiring_date,
                  'premium' => $request->premium

                ]);

                return $this ->sendResponse([
                    'success' => true,
                      'message' => 'Insurer info updated successfully.',

                   ],200);
     }


     public function searchInsurer(){
        $result = DB::table('insurances')
        ->get(array(
                  'registrationid',
                  'insurance_company',
                  'surname',
                  'othername',
                  'phone_number',
                  'vehicle_number',
                  'vehicle_make',
                  'vehicle_chassis_number',
                  'use_of_vehicle',
                  'cover_type',
                  'inception_date',
                  'expiring_date',
                  'premium'

        ));
        return $this ->sendResponse([
            'success' => true,
             'message' => $result,

           ],200);


     }

  }

