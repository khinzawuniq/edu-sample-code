<?php
namespace App\Traits;
use Illuminate\Support\Facades\Config;
trait SendOtp{


    public function sendOtp($phone,$message)
    {
        $phone = "+95".$phone;
        if (Config::get('app.env') === 'production' || Config::get('app.env') === 'development') {

            $data = array("to" => $phone,"body"=>$message);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://triplesms.com/api/v1/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer MjgzNjc0M2NiZGIwOTQxYzY4NzVkOGQ0MGUzM2FiYjEzOWIwYTE3ZjcyYTEyZmY3',
                'Content-Type: application/json',
                'Cookie: __cfduid=d03bdaf918d9ca22e4c101962a498d3fc1612105204'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        else{
            return "SMS Cannot sent from local server";
        }


    }
}