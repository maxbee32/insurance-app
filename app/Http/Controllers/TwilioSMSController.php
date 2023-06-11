<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TwilioSMSController extends Controller
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
        $this->middleware('auth:api', ['except'=>['sendSMS']]);
    }

   public function sendSMS(){

    /*select all expiring date from insurance table in the db*/
    $saveEndDate = Insurance::pluck('expiring_date');


    /*We loop through date to get all expiry within the next 3 month */
    foreach($saveEndDate as $key=> $saveEndDate){

      $date = Carbon::parse($saveEndDate)->subMonth(3);

      if( $date > Carbon::now()){

      $result1 = DB::table('insurances')
      ->whereDate('expiring_date','>=',[$date])
      ->select(array('phone_number'))
      ->pluck('phone_number');



    /*Integrate Mnotify api to send sms to all users whose insurance is about to expire*/
    $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'm36tB83trsrUqa1VerKbXa3Dy';
    $url = $endPoint . '?key=' . $apiKey;

    $data = [
        'recipient' => $result1,
        'sender' => 'Gglsms',
        'message' => 'Hello, your insurance is about to expire. Please try and renew your insurance package. Thank you.',
        'is_schedule' => 'false',
        'schedule_date' => ''
      ];

      $ch = curl_init();
      $headers = array();
      $headers[] = "Content-Type: application/json";
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      $result = curl_exec($ch);
      $result = json_decode($result, TRUE);
      curl_close($ch);


    return $this ->sendResponse([
            'success' => true,
             'message' => $result,

           ],200);
        }

  }

}
}





