<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SSLCertificateCheck;
use App\Mail\SiteDownMail;
use App\Models\CrawlingLog;
use App\Models\Package;
use App\Models\Settings;
use App\Models\SMSSetting;
use App\Models\User;
use App\Models\Websites;
use App\Notifications\EmailNotification;
use App\Notifications\SSLCertificateExpiry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Twilio\Rest\Client;
use App\Mail\SiteUpMail;
use Illuminate\Support\Facades\Mail;

class PackagesController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['select2', 'dataTables', 'package']);
        return view('dashboard.packages-list', ['title' => 'Packages List']);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'packageName' => ['required', 'string', Rule::unique('Packages', 'packageName')->ignore($request->id, 'id')],
            'crawlFrequency' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'type' => ['required'],
        ]);

        $customMessages = [
            'paymentType.required' => 'The payment type field is required.',
        ];

        $validator->setCustomMessages($customMessages);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $msg = $request->id == '' ? 'Created successfully' : 'Updated successfully';

        if (empty($request->paymentType)) {
            $request['paymentType'] = 'Fixed';
        }

        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            Package::updateOrCreate(
                ['id' => $request->id ?? ''], // Unique identifier for updateOrCreate
                [
                    'packageName' => $request->packageName,
                    'crawlFrequency' => $request->crawlFrequency,
                    'type' => $request->type,
                    'paymentType' => $request->paymentType,
                    'price' => $request->price,
                ]
            );
        }
        return response()->json(['status' => 200, 'msg' => $msg]);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('paymentType', function ($row) {
                    if ($row->paymentType == 'monthly') {
                        $paymentType = '<span class="badge bg-info fw-bold px-3 py-1">Monthly</span>';
                    } elseif ($row->paymentType == 'yearly') {
                        $paymentType = '<span class="badge bg-success fw-bold px-3 py-1">Yearly</span>';
                    } elseif ($row->paymentType == 'Fixed') {
                        $paymentType = '<span class="badge bg-warning fw-bold px-3 py-1">Fixed</span>';
                    }
                    return $paymentType;
                })

                ->editColumn('webStatus', function ($row) {
                    if ($row->webStatus == 1) {
                        $status = "<span name='$row->id' class='badge bg-success package-status fw-bold px-3 py-1'>Active</span>";
                    } elseif ($row->webStatus == 0) {
                        $status = "<span name='$row->id' class='badge bg-danger package-status fw-bold px-3 py-1'>Inactive</span>";
                    }
                    return $status;
                })


                ->addColumn('action', function ($row) {
                    return "<div class='btn-group' role='group'>
                            <a href='javascript:vaid(0)' data-id='$row->id'  data-packageName='$row->packageName'  data-crawlFrequency	='$row->crawlFrequency' data-type='$row->type' data-paymentType='$row->paymentType' data-price='$row->price' class='btn btn-primary PackageEdit rounded'>
                                <i class='bi bi-pencil-square'></i>
                            </a>

                            <button type='button' class='btn btn-danger client-delete ms-2 rounded' id='$row->id'>
                                <i id='$row->id' class='bi bi-trash3-fill client-delete'></i>
                            </button>
                        </div>
                    ";
                })
                ->rawColumns(['packageName', 'crawlFrequency', 'type', 'paymentType', 'price', 'webStatus', 'action'])
                ->make(true);
        }
    }


    public function delete(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            $Package = Package::find($request->id);
            $Package->delete();
        }
        return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
    }

    public function status(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {

            $Package = Package::find($request->id);
            $Package->webStatus = $request->statusValue == 'Active' ? '0' : '1';
            $Package->save();
        }
        return response()->json(['msg' => $request->statusValue == 'Active' ? 'Inactive' : 'Active']);
    }


    public function PackageList(Request $request)
    {
        addVendors(['package-details']);
        $data = Package::where('webStatus', '1')->latest()->get();
        $arraySettings = Settings::latest()->first()->toArray();
        return view('dashboard.packages', ['title' => 'Package', 'package' => $data, 'arraySettings' => $arraySettings]);
    }


    public function crawl($frequency)
    {
        $websites = Websites::where('frequency', '=', $frequency)->where('status', '=', '1')->get()->unique('domainName');
        $settings= Settings::latest()->first()->toArray();
        foreach ($websites as $website) {
            $status = checkSiteStatus($website->domainName);
            // $status = 0;
            Log::info($status ."Current Status");
            if ($status == 1) {
                $statusCode = "1";
                if($website->site_up_mail == '0'){
                    $domain = $website->domainName;
                    $website_id = $website->websiteID;
                    $emails = $website->email_cc_recipients;
                    $emails = explode(',',$emails);

                    //$data = $websites->toArray();
                    foreach($emails as $email){
                        Log::info($email);
                        $app = App::getInstance();
                        $app->register('App\Providers\MailConfigProvider');
                        Mail::to($email)->send(new SiteUpMail($domain,$website_id));
                    }
                    $website->site_up_mail = '1';

                    $website->site_down_mail = '0';

                    $res = $website->save();
                    Log::info($res."_insert");
                };
            } else {
                $statusCode = "0";
                $user = User::find($website->ownerID);

                if (!empty($user->mobile) && $website->sms_notification == 1) {
                    $this->sendNotification($user->mobile);
                }
                if($settings['site_up_on_off'] == '1'){
                    if($website->site_down_mail == '0'){


                        $app = App::getInstance();
                        $app->register('App\Providers\MailConfigProvider');
                        //Log::info($website->email_cc_recipients);
                        $user->notify(new EmailNotification($website->domainName, $website->email_cc_recipients));
                        $website->site_down_mail = '1';
                        $website->site_up_mail = '0';

                        $website->save();
                    };
                }

            }

            $domain = withouthttpsDomain($website->domainName);
            $domains = ["$domain"];

            $SSLCertificateCheck = new SSLCertificateCheck();
            $data =  $SSLCertificateCheck->handle($domains);
            // Log::info($data);
            $user = User::find($website->ownerID);
            $Expiry  = $data[0]['days_left'] ?? null;
            if ($Expiry == 0 || $Expiry == '') {
                $app = App::getInstance();
                $app->register('App\Providers\MailConfigProvider');
                if (!empty($website->ssl_check)) {
                    $user->notify(new SSLCertificateExpiry($website->domainName, 'Your SSL certificate for domain ' . $domain . ' has been expired.', $user->name));
                }
            }

            $siteLog = new CrawlingLog();
            $siteLog->websiteID = $website->websiteID;
            $siteLog->crawlTime = date('Y-m-d h:i:s A');
            $siteLog->status = $statusCode;
            $siteLog->save();
            Log::info($siteLog->status . ' ' . \Carbon\Carbon::now());
        }
    }

    public function sendNotification($mobile)
    {
        $smsSettings = SMSSetting::first()->toArray();
        $receiverNumber = "+91$mobile";
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
}
