<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
class SMSauth extends Controller
{

    public function index(Request $request){
        $from = '+201154765066';
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        $code = rand(1000, 9999);
        $client->messages->create(
            $request->phone_number,
            array(
                'from' => '+1 434 404 6863',
                'body' => 'Your authentication code is: ' . $code
            )
        );
        return "done";
    }
}
//4uB_3teXIWneYvLDQT7KPtg8ZsVgBXptVyBWhGUC
