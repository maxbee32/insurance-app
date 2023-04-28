<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
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
        $this->middleware('auth:api', ['except'=>['captureInsurance']]);
    }
    //
    public function captureInsurance(Request $request){
        $validator = Validator::make($request->all(), [
            'insurance_company'=> ['required','string'],
            'name_of_insurer' => ['required','string'],
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

//      public function createNewToken1($regtoken){
//         return response()->json([
//             'access_token' => $regtoken,
//             'token_type' => 'bearer',
//             'expires_in' => config('jwt.ttl') * 60,
//             'user'=>auth()->user(),
//             'message'=>'Insurer registered successfully.'
//         ]);
//     }
 }
