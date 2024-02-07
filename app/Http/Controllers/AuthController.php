<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;



use App\Library\activecampaign\ActiveCampaign;
use App\Library\sendlane\Sendlane;
use App\Library\mailchimp\Mailchimp;
use App\Library\campaignmoniter\Campaignmoniter;
use App\Library\convertkit\ConvertKitApi;
use App\Library\icontact\iContactApi;
use App\Library\getdrip\GetDrip;
use App\Library\sendinblue\Sendinblue;
use App\Models\AuthPageSettings;
use App\Models\Responders;
use App\Models\SocialSetting;
use App\Notifications\ForgotPassword;
use MailerLiteApi\MailerLite;

use App\Notifications\UserVerifyEmail;
use App\Notifications\ForgotPasswordOTP;

use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }



    public function crawlDomainFormHeader(Request $request)
    {
        try {
            $response = checkSiteStatus($request->crawlDomainUrl);
            if ($response == 1) {
                $status = 'UP';
                $statusCode = 200;
            } else {
                $status = 'Down';
                $statusCode = 201;
            }
        } catch (\Exception $e) {
            $status = 'Invalid Domain!';
            $statusCode = 404;
        }

        return response()->json(['status' => $status, 'statusCode' => $statusCode]);
    }


    public function LoginView(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        $googleLinkedin = SocialSetting::latest()->first();
        $AuthPageSettings = AuthPageSettings::latest()->first();
        addVendors(['loginRegister']);
        return view('auth.login', ['title' => 'Login', 'googleLinkedin' => $googleLinkedin, 'AuthPageSettings' => $AuthPageSettings]);
    }




    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => [
                'required',
                'string',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $email = User::where('email', $request->email)->where('status', '1')->first();

        if (empty($email->email) && empty($email->status)) {
            return response()->json(['status' => 201, 'msg' =>  'Account is temporarily locked']);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Session::put('applocale', Auth::user()->default_language);
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            Auth::login($user, $request->remember);
            return response()->json(['status' => 200, 'msg' => 'Login successfully', 'url' => route('home')]);
        } else {
            return response()->json(['status' => 201, 'msg' =>  'Invalid credentials']);
        }
    }

    public function RegisterView(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        $AuthPageSettings = AuthPageSettings::latest()->first();

        if (!$AuthPageSettings->signup_on_off ?? ''  == '') {
            return redirect(route('LoginView'));
            die();
        }

        addVendors(['loginRegister']);
        return view('auth.register', ['title' => 'Register']);
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'not_regex:/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }


        $data = $request->all();
        $user = $this->create($data);
        $user->notify(new UserVerifyEmail(route('verifyEmail', encode($user->id))));
        $Responders = Responders::where('set', 'yes')->latest()->get();
        if (!empty($Responders->key) && !empty($Responders->campaign_id)) {
            $this->ResponderEmailSave($request->email, $request->name);
        }
        return response()->json(['status' => 200, 'msg' =>  'Register successfully', 'url' => route('LoginView')]);
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => '2',
        ]);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect(route('LoginView'));
    }

    public function verify(Request $request)
    {
        $id = decode($request->id);
        $user = User::find($id);

        if ($user->status == '2') {

            $user->status = '1';
            $user->save();

            Session::flash('success', 'Your account has been verified successfully!');
            return redirect('/');
        } else {
            Session::flash('error', 'Your account has been already verified!');
            return redirect('/');
        }
    }

    public function forgotPassword(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        $AuthPageSettings = AuthPageSettings::latest()->first();
        if (!$AuthPageSettings->password_on_off ?? ''  == '') {
            return redirect(route('LoginView'));
            die();
        }

        addVendors(['loginRegister']);
        return view('auth.forgot-password', ['title' => 'Forgot password']);
    }


    public function forgotPasswordSendLink(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user) || empty($user->email)) {
            return response()->json(['status' => 201, 'errors' => ['email' => ['Please enter a valid email address']]]);
        } else {
            $user->notify(new ForgotPassword(route('passwordChange', encode($user->id))));
            return response()->json(['status' => 200, 'msg' => 'Successfully send link', 'url' => route('LoginView')]);
        }
    }

    public function passwordChange(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }
        if (empty(decode($request->id))) {
            Session::flash('error', 'Account recovery try again!');
            return redirect('/');
        }
        addVendors(['loginRegister']);
        return view('auth.password-change', ['title' => 'Password Change', 'id' => $request->id]);
    }

    public function passwordChangeSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'min:6',
            'NewPassword' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $id = decode($request->id);
        $user = User::find($id);

        if (empty($user->email) && empty($user->id)) {
            return response()->json(['status' => 201, 'errors' => ['password' => ['Account Not found']], 'msg' => 'Account Not found']);
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['status' => 200, 'msg' => 'Your password has been reset successfully', 'url' => route('LoginView')]);
        }
    }

    public function ResponderEmailSave($email, $first_name = '')
    {
        $Responders = Responders::where('set', 'yes')->latest()->first();
        $api = $this->apiGet($Responders->key);
        if ($Responders->key == 'activecampaign') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';
                $data = array(
                    "contact" => array(
                        "email" => $email,
                        "firstName" => $first_name,
                        "lastName" => $last_name,
                        "phone" => "",
                    )
                );
                $activecampaign = new ActiveCampaign();
                return $activecampaign->addContactActiveCampaign($api['api_access_url'], $api['api_access_key'], $data, $Responders->campaign_id);
            }
        } else if ($Responders->key == 'sendlane') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';
                $Sendlane = new Sendlane();
                $Sendlane->AddContactInSendlane($api["api_key"], $Responders->campaign_id, $first_name, $last_name, $email);
            }
        } else if ($Responders->key == 'mailchimp') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';

                $mailchimp = new Mailchimp($api['api_key']);
                $mergeFields = array('FNAME' => $first_name, 'LNAME' => $last_name);
                return $mailchimp->MailChimpAddContact($email, 'subscribed', $Responders->campaign_id, $api['api_key'], $mergeFields);
            }
        } else if ($Responders->key == 'campaignmonitor') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';

                $data = array(
                    'EmailAddress' => $email,
                    'Name' => $first_name . ' ' . $last_name,
                    'MobileNumber' => '',
                    'Resubscribe' => true,
                    'RestartSubscriptionBasedAutoresponders' => true,
                    'ConsentToTrack' => 'Yes'
                );
                $campaignmoniter = new Campaignmoniter($api['api_key']);
                return $campaignmoniter->addContactInCampaignmoniter($api["api_client_id"], $api["api_key"], $data, $Responders->campaign_id);
            }
        } else if ($Responders->key == 'convertkit') {

            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';

                $convertkit = new ConvertKitApi();

                $data = array(
                    'api_secret' => $api['api_secret'],
                    'email' => $email,
                    'first_name' => $first_name
                );
                return  $convertkit->subscribeToAForm($api['api_key'], $data, $Responders->campaign_id);
            }
        } else if ($Responders->key == 'icontact') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';

                iContactApi::getInstance()->setConfig(array(
                    'appId' => $api['api_id'],
                    'apiPassword' => $api['app_password'],
                    'apiUsername' => $api['user_name'],
                ));

                $iContactApi = iContactApi::getInstance();
                $contactIds = $iContactApi->addContact($email, '', '', $first_name, $last_name);
                return   $iContactApi->subscribeContactToList($contactIds, $Responders->campaign_id);
            }
        } else if ($Responders->key == 'getdrip') {
            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';

                $data = array(
                    "subscribers" => array(
                        array(
                            "email" => $email,
                            "first_name" => $first_name,
                            "last_name" => $last_name,
                            "tags" => array($Responders->campaign_id),
                        )
                    )
                );
                $DripApi = new GetDrip();
                return  $DripApi->AddContactInGetDrip($api["api_token"], $api["account_id"], $data);
            }
        } else if ($Responders->key == 'sendinblue') {

            if ($Responders->campaign_id != "" && $email != "") {
                $last_name = '';
                $data = array(
                    "email" => $email,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "list_id" => $Responders->campaign_id
                );

                $sendinblue = new Sendinblue();
                return $sendinblue->AddContactInSendinblue($api["api_key"], $data);
            }
        } else if ($Responders->key == 'mailerlite') {
            $last_name = '';
            $mailerliteClient = (new \MailerLiteApi\MailerLite($api["api_key"]))->groups();
            $subscriber = array('email' => $email, 'name' => $first_name . ' ' . $last_name);
            return $mailerliteClient->addSubscriber($Responders->campaign_id, $subscriber, 1);
        }
    }
}
