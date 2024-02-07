<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthPageSettings;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        addVendors(['auth-page-settings']);
        return view('dashboard.auth-page-settings', ['title' => 'Auth Page Settings', 'data' => AuthPageSettings::latest()->first()]);
    }

    public function saveUpdate(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            AuthPageSettings::updateOrCreate(
                [
                    'id'   => $request->id ?? '',
                ],
                [
                    'signup_on_off' => $request->signup_on_off,
                    'password_on_off' => $request->password_on_off,
                ],
            );
        }
    }
}
