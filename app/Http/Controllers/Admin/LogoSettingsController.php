<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LogoSettingsController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        addVendors(['logo-settings']);
        $Logo = Logo::latest()->first();
        return view('dashboard.logo-settings', ['title' => 'Logo Settings', 'Logo' => $Logo]);
    }


    public function LogoUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favicon' => 'nullable|image|mimes:png,svg|max:2048',
            'logo' => 'nullable|image|mimes:png,svg|max:2048',
            'logo_dark' => 'nullable|image|mimes:png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $folder = public_path("upload/logo/");
        is_dir($folder) or mkdir($folder, 0777, true);

        $logo = Logo::find($request->id);
        if (!empty($request->favicon)) {
            File::delete(public_path('upload/logo' . $logo->favicon));
            $filenameFavicon = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('upload/logo'), $filenameFavicon);
        }

        if (!empty($request->logo)) {
            File::delete(public_path('upload/logo/' . $logo->logo));
            $filename = time() . 'logo.' . $request->logo->extension();
            $request->logo->move(public_path('upload/logo'), $filename);
        }

        if (!empty($request->dark_logo)) {
            File::delete(public_path('upload/logo/' . $logo->dark_logo));
            $filenameDark_logo = time() . 'dark_logo.' . $request->dark_logo->extension();
            $request->dark_logo->move(public_path('upload/logo'), $filenameDark_logo);
        }
        if (auth()->user()->role == 3 || auth()->user()->role == 1) {
            // Update the favicon and logo fields
            $logo->update([
                'favicon' => $filenameFavicon ?? $logo->favicon,
                'logo' => $filename ??  $logo->logo,
                'dark_logo' => $filenameDark_logo ??  $logo->dark_logo,
            ]);
        }

        return response()->json(['status' => 200, 'msg' => 'Updated successfully', 'url' => route('LogoSettingsView')]);
    }
}
