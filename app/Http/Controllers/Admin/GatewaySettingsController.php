<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentGatewayRequest;

class GatewaySettingsController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        addVendors(['gateway-settings']);
        $PaymentSettings = Settings::latest()->first();
        return view('dashboard.gateway-settings', ['title' => 'Payment Gateway Settings', 'PaymentSettings' => $PaymentSettings]);
    }


    public function GatewaySettingsUpdate(Request $request)
    {

        if ($request->razorpay_on_off){
            $validate = $request->validate([
            'key_id' => 'required',
            'key_secret'=>'required',
            ]);
        }
        if ($request->stripe_on_off){
            $validate = $request->validate([
                'stripe_client_id'=>'required',
                'stripe_client_secret' => 'required'
            ]);
        }
        if ($request->paypal_on_off){
            $validate = $request->validate([
                'paypal_type' => 'required',
                'paypal_client_id' => 'required',
                'paypal_client_secret' => 'required',
            ]);
        }


        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            Settings::updateOrCreate(
                [
                    'id'   => $request->id ?? '',
                ],
                $request->all(),
            );
        }
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }
}
