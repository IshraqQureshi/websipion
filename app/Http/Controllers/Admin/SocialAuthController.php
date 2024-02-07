<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialSetting;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{

    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        addVendors(['social-settings']);
        $social_settings = SocialSetting::latest()->first();
        return view('dashboard.social-auth-settings', ['title' => 'Social Auth Settings', 'social_settings' => $social_settings]);
    }

    public function update(Request $request)
    {

        if (empty($request->linkedin_on_off)) {
            $request['linkedin_on_off'] = '';
        }else{
            $validate = $request->validate([
                'google_client_id'=>'required',
                'google_client_secret' => 'required',
                'google_redirect' => 'required',
            ]);
        }

        if (empty($request->google_on_off)) {

            $request['google_on_off'] = '';
        }else{
            $validate = $request->validate([
            'linkedin_client_id' => 'required',
            'linkedin_client_secret' => 'required',
            'linkedin_redirect' => 'required',
            ]);
        }

        if (auth()->user()->role == 3 || auth()->user()->role == 1) {

            SocialSetting::updateOrCreate(
                [
                    'id'   => $request->id ?? '',
                ],
                $request->all(),
            );
        }
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }
}
