<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Help;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HelpController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['help-content']);
        $Help = Help::latest()->first();
        return view('dashboard.help', ['title' => 'Help', 'help' => $Help]);
    }

    public function HelpContent(Request $request)
    {
        addVendors(['HelpContent']);
        $Help = Help::latest()->first();
        return view('dashboard.help-content', ['title' => 'Help Content', 'help' => $Help]);
    }


    public function update(Request $request)
    {
        if (auth()->user()->role == 3 || auth()->user()->role == 1){

            $Help = Help::find($request->id);
            $Help->help_content = $request->help_content;
            $Help->save();
        }
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }


    public function help(Request $request)
    {
        $Help = Help::latest()->first();
        return view('dashboard.help-content', ['title' => 'Help', 'help' => $Help]);
    }

    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }

    public function languageSettings()
    {
        addVendors(['language-settings']);
        return view('dashboard.language-settings', ['title' => 'Language Settings']);
    }

    public function saveLanguage(Request $request)
    {

        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $user = User::find(Auth::user()->id);
            $user->default_language = $request->language;
        }
        $user->save();
    }
}
