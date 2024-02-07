<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SMSSetting;
use Exception;
use Twilio\Rest\Client;

class SMSSettingController extends Controller
{
    public function index()
    {
        $smsSettings = SMSSetting::first();

        $title = 'SMS API Settings';
        addVendors(['global-dashboard-assets', 'sms-settings']);
        return view('dashboard.sms-setting-list', ['title' => $title, 'smsSettings' => $smsSettings]);
    }

    public function SmsSettingsUpdate(Request $request)
    {
        $request->validate([
            // 'twilio_on_off'=>'required',
            'key_id' =>'required',
            'key_secret' =>'required',
            'twilio_from' =>'required'
        ],[
            'key_id.required' => 'Enter Twilio Key',
            'key_secret.required' => 'Enter Twilio Key Secret',
            'twilio_from.required' =>'Enter Twilio From'
        ]);
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            SMSSetting::updateOrCreate(
                [
                    'id'   => $request->id ?? '',
                ],
                [
                    'twilio_on_off'     => $request->twilio_on_off ?? '',
                    'key_id'     => $request->key_id ?? '',
                    'key_secret'     => $request->key_secret ?? '',
                    'twilio_from' => $request->twilio_from ?? '',
                ],
            );
        }
    }

    public function sendNotification(Request $request)
    {
        $smsSettings = SMSSetting::first()->toArray();
        $receiverNumber = "+919519622121";
        $message = "This is testing from SiteDown Detector";

        try {
            $account_sid = $smsSettings['key_id'];
            $auth_token = $smsSettings['key_secret'];
            $twilio_number = $smsSettings['twilio_from'];

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message
            ]);

            dd('SMS Sent Successfully.');
        } catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    public function sendSms(Request $request)
    {
        // Account details
        $apiKey = urlencode('NzU2NTc5NGQ0OTcyNGYzNzYyNGQ2NzU5Nzk3NDM0Njc=');
        // Message details
        $numbers = array(917985216524, 919519622121);
        $sender = urlencode('600010');
        $message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. See how you can send effective SMS campaigns here: https://tx.gl/r/2nGVj/');
        $test = true;
        $numbers = implode(',', $numbers);
        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message . "&test=" . $test;
        // Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Process your response here
        echo $response;
    }
}
