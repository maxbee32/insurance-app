<?php

namespace App\Http\Controllers;

use App\Models\Defect;
use App\Models\RoadWorth;
use Illuminate\Http\Request;
use App\Models\VehicleDefects;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RoadWorthController extends Controller
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
        $this->middleware('auth:api',['except'=>['captureRoadWorth','caputureVihecleDefects']]);
    }



       public function captureRoadWorth(Request $request){
        $validator = Validator::make($request->all(), [
         'vehicle_registration_number'=>['required','string'],
         'owner_surname'=>['required','string'],
         'owner_othername'=>['required','string'],
         'vehicle_cc'=>['required','string'],
         'vehicle_make'=>['required','string'],
         'phone_number'=>['required','regex:/^(\+\d{1,3}[- ]?)?\d{10}$/','min:10'],
         'use_of_vehicle'=>['required', 'string'],
         'date_of_inspection'=>['required', 'date'],
         'next_inspection_date'=>['required', 'date'],
         'amount'=>['required', 'numeric'],
        ]);



        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);
        }

        $Id =IdGenerator::generate(['table'=>'road_worths','field'=>'roadworth_id','length'=>10,'prefix'=>'RWGH-']);

        $rw = RoadWorth::create(array_merge(
            ['roadworth_id'=>$Id],
            $validator-> validated(),

        ));
        $token = $rw->createToken('token')->plainTextToken;


        return $this ->sendResponse([
            'success' => true,
            'access_token' =>$token,
            'token_type'=>'bearer',
             'message' =>'Road worth info captured successfully.'

           ],200);
    }




   public function caputureVihecleDefects(Request $request){
    $token = auth('sanctum')->user();
    $validator = Validator::make($request->all(), [
                'vehicle_defects'=>['required','string'],
                'number'=>['nullable','string'],
                'remarks'=>['nullable','string']
            ]);

            if($validator->stopOnFirstFailure()->fails()){
                return $this->sendResponse([
                    'success' => false,
                    'data'=> $validator->errors(),
                    'message' => 'Validation Error'
                ], 400);
            }

            VehicleDefects::create(array_merge(
                ['r_id' => $token->id],
                $validator-> validated(),
            ));



    return $this ->sendResponse([
        'success' => true,
         'message' =>'Vehicle Defects registered successfully.'

       ],200);
 }
 // $s = Defect::all();
    // $id = $s->pluck('defect');

    // echo($id);

    // // foreach ($id as $key =>$value) {
    // //     echo($value);
}
