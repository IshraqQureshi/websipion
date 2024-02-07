<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SSLCertificateCheck;
use App\Models\User;
use App\Models\Websites;
use App\Models\CrawlingLog;
use App\Models\PaymentDetails;
use App\Models\Package;
use App\Models\SMSSetting;
use App\Models\Tag;
use App\Notifications\EmailNotification;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use App\Events\WebsiteAddEvent;
use App\Mail\WebsiteAddMail;
use Mail;
use App\Models\Settings;

class WebsitesController extends Controller
{

    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $label = '';
        $is_add_website = false;
        $dropdown_data = array();

        if (Auth::user()->role == 1 || Auth::user()->role == 3) {
            $label = 'Client';
            $dropdown_data = User::latest()->select('id', 'name', DB::raw("'' as frequency"))->get();
            $is_add_website = true;
        } else {
            $label = 'Package';
            $dropdown_data = Package::whereHas('payment', function ($query) use ($user_id) {
                $query->where('userID', $user_id);
            })
                ->latest()
                ->select('id', 'packageName as name', 'crawlFrequency as frequency')
                ->distinct()
                ->get();

            $is_add_website = $this->check_user_website_limit($user_id);
        }
        if (Auth::user()->role == 1|| Auth::user()->role== 3) {
            $uniqueTags = Websites::latest()->pluck('tags')->unique()->toArray();
        } else {
            $uniqueTags = Websites::where('ownerID', auth()->user()->id)->latest()->pluck('tags')->unique()->toArray();
        }

        $mergedTags = implode(',', array_unique(array_filter(array_map('trim', $uniqueTags), 'strlen')));

        $data = array(
            'title'             => 'Website List',
            'label'             => $label,
            'client'            => $dropdown_data,
            'is_add_website'    => $is_add_website,
            'tagSearch'    => $mergedTags,
        );
        $smsSettings = SMSSetting::first();

        addVendors(['select2', 'dataTables', 'website']);
        return view('dashboard.website-list', $data, ['smsSettings' => $smsSettings]);
    }

    public function cc_email_list()
    {
        $email_cc = Websites::where('ownerID', auth()->user()->id)->select('email_cc_recipients')->latest()->get();
        $cc_emails = [];

        foreach ($email_cc as $val) {
            $cc_emails = array_merge($cc_emails, explode(',', $val->email_cc_recipients));
        }

        // Remove duplicate email addresses
        $unique_cc_emails = array_unique($cc_emails);

        $html = '';
        foreach ($unique_cc_emails as $email) {
            $html .= "<option>$email</option>";
        }

        echo $html;
    }

    public function tag_list()
    {
        $Tag = Tag::where('user_id', auth()->user()->id)->latest()->get();
        $html = '';
        foreach ($Tag as $val) {
            $html .= "<option>$val->name</option>";
        }
        echo $html;
    }


    private function check_user_website_limit(int $user_id, int $package_id = null)
    {
        if ($package_id) {
            $total = PaymentDetails::where(['userID' => $user_id, 'packagesID' => $package_id])->sum('totalWebsite');
            $created = Websites::where(['ownerID' => $user_id, 'package_id' => $package_id])->count();
        } else {
            $total = PaymentDetails::where('userID', $user_id)->sum('totalWebsite');
            $created = Websites::where('ownerID', $user_id)->count();
        }
        if ($created < $total) {
            return true;
        }
        return false;
    }

    public function save(Request $request)
    {

        if (empty($request->id)) {
            $validator = Validator::make($request->all(), [
                'ownerID' => ['required', 'numeric'],
                'domainName' => ['required', 'url', 'unique:Websites,domainName'],
                'frequency' => ['required'],
            ]);

            $customMessages = [
                'ownerID.required' => 'The clients field is required.',
                'domainName.required' => 'The domain field is required.',
                'frequency.required' => 'The crawl frequency field is required.',
            ];

            $validator->setCustomMessages($customMessages);

            if ($validator->fails()) {
                return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
            }

        if (Auth::user()->role == 2){
            if (!$this->check_user_website_limit(Auth::user()->id, $request->ownerID)) {
                return response()->json(['status' => 201, 'msg' => 'Your account limit has been reached. please update your package.']);
            }
            $request->merge([
                'ownerID' => Auth::user()->id,
                'package_id' => $request->ownerID
            ]);
        }

        if ($request->domainName == 'https://') {
            $request['domainName'] = '';
        }


        }


        if (empty($request->sms_notification)) {
            $request['sms_notification'] = '0';
        }

        if (empty($request->ssl_check)) {
            $request['ssl_check'] = '';
        }

        $domainName = Domainfilter($request->domainName);

        $folder = public_path("upload/favicon/");
        is_dir($folder) or mkdir($folder, 0777, true);

        $url  = "https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=" . $domainName . "&size=32";
        $contents = @file_get_contents($url);

        // upload/favicon/
        if (empty($contents)) {
            $favicon_name = 'favicon.png';
        } else {
            $favicon_name = Str::slug($domainName) . '.jpeg';
            file_put_contents($folder . $favicon_name, $contents, LOCK_EX);
        }

        // insert tag with check tag
        foreach ($request->tags as $tag) {
            $tagData = Tag::where('name', $tag)->first();
            if (empty($tagData->name)) {
                Tag::create(['name' => $tag, 'user_id' => auth()->user()->id]);
            }
        }

        $request['favicon_name'] = $favicon_name;
        $request['domainName'] = $domainName;
        $request['tags'] = $request->tags == '' ? '' : implode(',', $request->tags);
        $request['email_cc_recipients'] = $request->email_cc_recipients == '' ? '' : implode(',', $request->email_cc_recipients);
        $website =  Websites::updateOrCreate(
            [
                'websiteID'   => $request->id ?? '',
            ],
            $request->all(),
        );
        // dd($website);
        $settings = Settings::latest()->get();
        // dd($settings[0]->site_add_on_off);
        if ($settings[0]->site_add_on_off == '1'){
            if($request->id == ''){
                // event(new WebsiteAddEvent($website));

                $data = $website;
                // dd($data);
                $emails = explode(',', $data->email_cc_recipients);
                $domain = $data->domainName;
                $website_id = $data->websiteID;
                foreach($emails as $email){
                    Mail::to($email)->send(new WebsiteAddMail($domain,$website_id));
                }


            }
        }

        $this->crawlManually($website->websiteID);
        return response()->json(['status' => 200, 'msg' => 'Successfully added the website']);
    }

    public function update(Request $request)
    {

        if ($request->domainName == 'https://') {
            $request['domainName'] = '';
        }

        $validator = Validator::make($request->all(), [
            'domainName' => [
                'required',
                Rule::unique('Websites', 'domainName')->ignore($request->id, 'websiteID'),
            ],
            'id' => ['required'],
        ]);


        $customMessages = [
            'domainName.required' => 'The domain field is required.',
        ];
        $validator->setCustomMessages($customMessages);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }
        $domainName = Domainfilter($request->domainName);
        $folder = public_path("upload/favicon/");
        $url  = "https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=" . $domainName . "&size=32";
        $contents = @file_get_contents($url);
        // upload/favicon/
        if (empty($contents)) {
            $favicon_name = 'favicon.png';
        } else {
            $favicon_name = Str::slug($domainName) . '.jpeg';
            file_put_contents($folder . $favicon_name, $contents, LOCK_EX);
        }

        if (empty($request->ssl_check)) {
            $request['ssl_check'] = '';
        }

        // insert tag with check tag
        foreach ($request->tags as $tag) {
            $tagData = Tag::where('name', $tag)->first();
            if (empty($tagData->name)) {
                Tag::create(['name' => $tag, 'user_id' => auth()->user()->id]);
            }
        }

        $request['favicon_name'] = $favicon_name;
        $request['domainName'] = $domainName;
        $request['tags'] = $request->tags == '' ? '' : implode(',', $request->tags);
        $request['email_cc_recipients'] = $request->email_cc_recipients == '' ? '' : implode(',', $request->email_cc_recipients);
        $website =  Websites::updateOrCreate(
            [
                'websiteID'   => $request->id ?? '',
            ],
            $request->all(),
        );

        $this->crawlManually($website->websiteID);
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {

            $data = Websites::with('GetUser')->latest();
            // Role-based filtering
            if (Auth::user()->role ==2) {

                $data->where('ownerID', Auth::user()->id);
            }

            // Custom tag search filtering
            if ($request->has('tagSearch') && !empty($request->input('tagSearch'))) {
                $tags = $request->input('tagSearch');
                $data->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        if (!empty($tag)) {
                            $query->orWhere('tags', 'like', '%' . $tag . '%');
                        }
                    }
                });
            }
            // Get the filtered data
            $filteredData = $data->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()

                ->editColumn('domainName', function ($row) {

                    $img = asset('upload/favicon/' . $row->favicon_name);
                    $domain = withouthttpsDomain($row->domainName);
                    $name = $row->GetUser->name;
                    $url = route('CrawlDetails', $domain);

                    if ($row->favicon_name == 'favicon.png') {
                        $img = "<i class='bi bi-globe fs-2'></i>";
                    } else {
                        $img =  "<img src='$img'>";
                    }

                    return "
                            <div class='d-flex align-items-center'>
                            <div class='me-2 position-relative'>
                                <div class='symbol symbol-35px symbol-circle'>
                                 $img
                                </div>
                            </div>
                            <div class='d-flex flex-column justify-content-center'>
                                <a href='$url'
                                    class='mb-1 text-gray-800 text-hover-primary'>$domain</a>
                                <div class='fw-semibold fs-6 text-black-400'>$name</div>
                            </div>
                        </div>
                    ";
                })

                ->editColumn('ssl_check', function ($row) {
                    if (!empty($row->ssl_check)) {
                        $domain = withouthttpsDomain($row->domainName);
                        $domains = ["$domain"];
                        $SSLCertificateCheck = new SSLCertificateCheck();
                        $data =  $SSLCertificateCheck->handle($domains);

                        $start  = $data[0]['valid_from'] ?? null;
                        $Expiry  = $data[0]['valid_to'] ?? null;
                    }else{
                        $start  =  'Null';
                        $Expiry  =  'Null';
                    }

                    return "
                            <div class='d-flex align-items-center'>
                                <div class='d-flex flex-column justify-content-center'>
                                    <div class='fw-semibold fs-6 text-black-400'>(Start Date) $start</div>
                                    <div class='fw-semibold fs-6 text-black-400'>(Expiry Date) $Expiry</div>
                                </div>
                             </div>
                    ";
                })

                ->editColumn('tags', function ($row) {
                    $html = '';  // Initialize the $html variable outside the loop
                    foreach (explode(',', $row->tags) as $key => $value) {
                        if (!empty($value) && $value !== ',') {  // Corrected condition
                            $html .= "<span class='badge bg-info fw-bold px-3 py-1'>$value</span> ";
                        }
                    }
                    return $html;  // Moved the return statement outside the loop
                })


                ->editColumn('frequency', function ($row) {
                    return "<span class='badge bg-info  fw-bold px-3 py-1'>$row->frequency</span>";
                })

                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        $status = "<span name='$row->websiteID' class='badge bg-danger website-status fw-bold px-3 py-1'>Inactive</span>";
                    } elseif ($row->status == 1) {
                        $status = "<span name='$row->websiteID' class='badge bg-success website-status fw-bold px-3 py-1'>Active</span>";
                    }
                    return $status;
                })

                ->addColumn('action', function ($row) {
                    return "<div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='javascript:void(0)' class='btn btn-primary EditWebsite rounded' data-email_cc_recipients='$row->email_cc_recipients' data-domain='$row->domainName' data-id='$row->websiteID' data-tags='$row->tags' data-ssl_check='$row->ssl_check' data-email_cc_recipients='$row->email_cc_recipients'>
                                <i class='bi bi-pencil-square'></i>
                            </a>

                            <button type='button' class='btn btn-danger client-delete ms-2 rounded' id='$row->websiteID'>
                                <i id='$row->websiteID' class='bi bi-trash3-fill client-delete'></i>
                            </button>
                        </div>
                    ";
                })

                ->rawColumns(['domainName', 'tags', 'ssl_check', 'frequency', 'status', 'action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $CrawlingLog = CrawlingLog::where('websiteID', $request->id);
            $CrawlingLog->delete();

            $Websites = Websites::find($request->id);
            $Websites->delete();
        }
            return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
    }

    public function status(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $Websites = Websites::find($request->id);
            $Websites->status = $request->statusValue == 'Inactive' ? '1' : '0';
            $Websites->save();
        }
        return response()->json(['msg' => $request->statusValue == 'Active' ? 'Inactive' : 'Active']);
    }

    public function crawlManually($id)
    {
        $websites =  Websites::find($id);
        $status = checkSiteStatus($websites->domainName);
        if ($status == 1) {
            $statusCode = "1";
        } else {
            $statusCode = "0";
            $user = User::find($websites->ownerID);
            $app = App::getInstance();
            $app->register('App\Providers\MailConfigProvider');
            $user->notify(new EmailNotification($websites->domainName, $websites->email_cc_recipients));
            $websites->site_down_mail = '1';
            $websites->site_up_mail = '0';
            $websites->save();
        }
        $siteLog = new CrawlingLog();
        $siteLog->websiteID = $websites->websiteID;
        $siteLog->crawlTime = date('Y-m-d h:i:s A');
        $siteLog->status = $statusCode;
        $siteLog->save();
    }
}
