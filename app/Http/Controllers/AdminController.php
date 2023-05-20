<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Defect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function sendResponse($data, $message, $status = 200){
        $response =[
            'data' => $data,
            'message' => $message
        ];
        return response()->json($response, $status);
     }

    public function __construct(){
        $this->middleware('auth:api', ['except'=>['adminSignUp','adminLogin','userSignUp','selectInsurer', 'createNewDefects']]);
    }




    public function adminSignUp(Request $request){

        $validator = Validator::make($request-> all(),[
            'email' => ['bail','required','string','email:rfc,filter,dns','unique:admins'],
            'password'=> ['required','string',
            Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),'confirmed'],

        ]);

        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);

        }



        $user = Admin::create(array_merge(
                $validator-> validated(),
                 ['password'=>bcrypt($request->password)]

            ));

            if(!$token = auth()->guard('admin-api')->attempt($validator->validated())){
                return $this->sendResponse([
                    'success' => false,
                    'message' => 'Invalid login credentials'
                ], 400);


        }
        return $this-> createNewToken1($token);

}




public function adminLogin(Request $request){
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

    if(!$token = auth()->guard('admin-api')->attempt($validator->validated())){
        return $this->sendResponse([
            'success' => false,
            'data'=> $validator->errors(),
            'message' => 'Invalid login credentials'
        ], 400);

    }

     return $this-> createNewToken($token);
}



  //register  users
    public function userSignUp(Request $request){
        $validator = Validator::make($request->all(), [

            'email' => ['required','email','unique:users'],
            'password'=> ['required','string',
            Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),'confirmed'],


        ]);

        if($validator->stopOnFirstFailure()-> fails()){
            return $this->sendResponse([
                'success' => false,
                'data'=> $validator->errors(),
                'message' => 'Validation Error'
            ], 400);

        }
           User::create(array_merge(
                    $validator-> validated(),
                    ['password'=>bcrypt($request->password)]
                ));



                if(!$token = auth()->guard('api')->attempt($validator->validated())){
                    return $this->sendResponse([
                        'success' => false,
                        'data'=> $validator->errors(),
                        'message' => 'Invalid login credentials'
                    ], 400);


                }


                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60,//auth()->factory()->getTTL()* 60,
                     'user'=>auth()->guard('api')->user(),
                    'message' => "manager account created successfully"
                ],200);




}
// get all insurers
public function selectInsurer(){
    $result = DB::table('insurances')
    ->orderBy("insurances.created_at", 'desc')
    ->get(array(
              'id',
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

 public function createNewDefects(Request $request){
    $validator = Validator::make($request->all(), [

        'defect' => ['required','string','unique:defects']
    ]);

    if($validator->stopOnFirstFailure()-> fails()){
        return $this->sendResponse([
            'success' => false,
            'data'=> $validator->errors(),
            'message' => 'Validation Error'
        ], 400);
    }


    Defect::create(array_merge(
        $validator-> validated(),
    ));

    return $this ->sendResponse([
        'success' => true,
         'message' =>'New vehicle defect added successfully.'

       ],200);
 }




public function createNewToken1($token){
    return response()->json([
        // 'success'=>'true',
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => config('jwt.ttl') * 60,
        'user'=>auth()->guard('admin-api')->user(),
        'message'=>'Admin registered successfully.'
    ]);
}

public function createNewToken($token){
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => config('jwt.ttl') * 60,
        'user'=>auth()->guard('admin-api')->user(),
        'message'=>'Logged in successfully.'
    ]);
}



}
