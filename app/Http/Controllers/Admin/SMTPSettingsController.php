<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SMTPDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SMTPSettingsController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        addVendors(['mail-settings']);
        $smtp = SMTPDetails::first();
        return view('dashboard.smtp-settings', ['title'=> 'SMTP Settings', 'smtp'=>$smtp]);
    }

    public function UpdateSMTP(Request $request){

        $validator = Validator::make($request->all(), [
            'driver' => ['required'],
            'encryption' => ['required'],
            'username' => ['required'],
            'smtp_host' => ['required'],
            'smtp_from_email' => ['required'],
            'smtp_from_name' => ['required'],
            'smtp_pass' => ['required'],
        ]);


        $customMessages = [
            'smtp_pass.required' => 'The password field is required.',
        ];

        $validator->setCustomMessages($customMessages);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        if (auth()->user()->role == '1' || auth()->user()->role == '3'){

        SMTPDetails::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all(),
        );

        return response()->json(['status' => 200, 'msg' => 'SMTP Updated successfully']);
    }

    public function UpdateAWS(Request $request){
        $validator = Validator::make($request->all(), [
            'driver' => ['required'],
            'awsAccessKey' => ['required'],
            'awsSecretKey' => ['required'],
            'awsDefaultRegion' => ['required'],
            'awsBucket' => ['required'],
            'from_email' => ['required'],
            'from_name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            SMTPDetails::updateOrCreate(
                [
                    'id'   => $request->id ?? '',
                ],
                $request->all(),
            );
        }

        return response()->json(['status' => 200, 'msg' => 'AWS Updated successfully']);
    }
}
