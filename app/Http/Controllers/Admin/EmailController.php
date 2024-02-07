<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use App\Models\Websites;
use App\Models\Settings;

use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['email-template']);
        $Email = EmailTemplate::latest()->first();
        return view('dashboard.email-template', ['title' => 'Email Template', 'email' => $Email]);
    }


    public function save(Request $request)
    {

        $validate = $request->validate([

            'status_title' =>'required',
            'title'=>'required',
            'text'=>'required',
            'short_text' => 'required',
        ],[
            'status_title.required' => 'The title field is required',
            'title' => ' The Status Title field is required',
            'text' => ' The Email Body field is required',
            'short_text' => 'Footer Text The Footer Text field is required'
        ]);
        $email = new EmailTemplate();

        if (isset($request->id)) {
            $email = EmailTemplate::find($request->id);
        }
        $email->status_title = $request->status_title;
        $email->title =  $request->title;
        $email->text =  $request->text;
        $email->short_text =  $request->short_text;
        $email->save();
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }


    public function testEmail(Request $request){
        $validate = $request->validate(['emailTest' => 'email']);
        if(empty($request->emailTest)){
            return response()->json(['status' => 201]);
        }else{
            Mail::to($request->emailTest)->send(new SendEmail());
            return response()->json(['status' => 200]);
        }
    }


    public function upmail(){
        addVendors(['site-up-down']);
        $settings = Settings::latest()->first();
        // dd($settings);
        return view('dashboard.site-up-downmail-setting',compact('settings'));
    }

    public function updownsave(Request $request){
        $data = [];
        $site_add_mail = $request->add_mail ? '1': '0';
        $site_up_down_mail = $request->up_down_mail? '1': '0';
        // Website::where('owner')
        $data['site_up_on_off'] = $site_up_down_mail;
        $data['site_add_on_off']=$site_add_mail;
        // dd($data);
        $setting = Settings::updateOrCreate(['id' => $request->id],$data);
        if($setting){
            return response()->json(['status' => 'success','message'=>'Setting updated successfully']);
        }
        // else{
        //     return back()->with(['error','You are not authroized for this action']);
        // }


    }
}
