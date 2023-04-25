<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
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
        $this->middleware('auth:api', ['except'=>['adminSignUp',]]);
    }




    public function adminSignUp(Request $request){

        $validator = Validator::make($request-> all(),[
            'email' => ['bail','required','string','email:rfc,filter,dns','unique:admins'],
            'username'=>['required','string','unique:admins'],
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

}
