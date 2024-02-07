<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }
    public function index(){
        addVendors(['email-template']);
        return view('dashboard.site-up-downmail-setting');
    }
}
