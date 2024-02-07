<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrawlDeleteScheduling;
use App\Models\CrawlingLog;
use App\Models\User;
use App\Models\Websites;
use App\Notifications\EmailNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\App;

class CrawlingController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['dataTables', 'website-crawl-details']);
        return view('dashboard.website-crawl-details', ['title' => $request->name . ' ' . __('site.crawl-details.title')]);
    }

    public function datatable(Request $request)
    {
        $website = Websites::where('domainName', 'https://' . $request->name)->first();

        if (empty($website)) {
            return false;
        }

        if ($request->ajax()) {

            $data = CrawlingLog::where('websiteID', $website->websiteID)->with('GetDomain')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('websiteID', function ($row) {
                    $img = asset('upload/favicon/' . $row->GetDomain->favicon_name);
                    $domain = withouthttpsDomain($row->GetDomain->domainName);

                    if ($row->GetDomain->favicon_name == 'favicon.png') {
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
                                <a
                                    class='mb-1 text-gray-800 text-hover-primary'>$domain</a>
                            </div>
                        </div>
                    ";
                })


                ->editColumn('crawlTime', function ($row) {
                    return DateTimeChange($row->crawlTime);
                })

                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        $status = '<span class="badge bg-danger px-3 py-1 website-status">Down</span>';
                    } elseif ($row->status == 1) {
                        $status = '<span class="badge bg-success px-3 py-1 website-status">UP</span>';
                    } elseif ($row->status == 2) {
                        $status = '<span class="badge bg-danger px-3 py-1 website-status">Failed</span>';
                    }
                    return  $status;
                })

                ->editColumn('frequency', function ($row) {
                    $frequency = $row->GetDomain->frequency;
                    return "<span  class='badge bg-success fw-bold px-3 py-1'>$frequency</span>";
                })



                ->rawColumns(['websiteID', 'frequency', 'crawlTime', 'status'])
                ->make(true);
        }
    }

    public function crawlLog(Request $request)
    {
        addVendors(['dataTables', 'select2', 'website-crawl-log']);

        return view('dashboard.website-crawl-log', ['title' => 'Crawl Log', 'crawldeletescheduling' => CrawlDeleteScheduling::where('user_id', '=', auth()->user()->id)->first()]);
    }

    public function crawlLogDatatable(Request $request)
    {
        if ($request->ajax()) {

            if (auth()->user()->role == 1 || auth()->user()->role == 3) {
                $data = CrawlingLog::with('GetDomain')->latest()->get();
            } else {
                $user_id = auth()->user()->id;
                $data = CrawlingLog::whereHas('GetDomain', function ($query) use ($user_id) {
                    $query->where('ownerID', $user_id);
                })->latest()->get();
            }


            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('websiteID', function ($row) {
                    $img = asset('upload/favicon/' . $row->GetDomain->favicon_name);
                    $domain = withouthttpsDomain($row->GetDomain->domainName);
                    $img = $img ?? 'favicon.png';

                    if (($row->GetDomain->favicon_name ?? '') == 'favicon.png') {
                        $img = "<i class='bi bi-globe fs-2'></i>";
                    } else {
                        $img =  "<img src='$img'>";
                    }

                    $domainUrl =  $row->GetDomain->domainName;

                    return "
                            <div class='d-flex align-items-center'>
                            <div class='me-2 position-relative'>
                                <div class='symbol symbol-35px symbol-circle'>
                                    $img
                                </div>
                            </div>
                            <div class='d-flex flex-column justify-content-center'>
                                <a href='$domainUrl' target='_blank'
                                    class='mb-1 text-gray-800 text-hover-primary'>$domain</a>
                            </div>
                        </div>
                    ";
                })


                ->editColumn('crawlTime', function ($row) {
                    return DateTimeChange($row->crawlTime);
                })

                ->editColumn('status', function ($row) {
                    if ($row->status == 0) {
                        $status = '<span class="badge bg-danger px-3 py-1 website-status">Down</span>';
                    } elseif ($row->status == 1) {
                        $status = '<span class="badge bg-success px-3 py-1 website-status">UP</span>';
                    } elseif ($row->status == 2) {
                        $status = '<span class="badge bg-danger px-3 py-1 website-status">Failed</span>';
                    }
                    return  $status;
                })

                ->editColumn('frequency', function ($row) {
                    $frequency = $row->GetDomain->frequency;
                    return "<span  class='badge bg-success fw-bold px-3 py-1'>$frequency</span>";
                })


                ->rawColumns(['websiteID', 'frequency', 'crawlTime', 'status'])
                ->make(true);
        }
    }

    public function crawlManually(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3){
            $websites =  Websites::all();
        } else {
            $websites =  Websites::where('ownerID', auth()->user()->id)->get();
        }

        foreach ($websites as $website) {
            $status = checkSiteStatus($website->domainName);
            if ($status == 1) {
                $statusCode = "1";
            } else {
                $statusCode = "0";
                $user = User::find($website->ownerID);
                $app = App::getInstance();
                $app->register('App\Providers\MailConfigProvider');
                $user->notify(new EmailNotification($website->domainName, $website->email_cc_recipients));
            }
            $siteLog = new CrawlingLog();
            $siteLog->websiteID = $website->websiteID;
            $siteLog->crawlTime = date('Y-m-d h:i:s A');
            $siteLog->status = $statusCode;
            $siteLog->save();
        }
    }

    public function deleteAllLogs(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            CrawlingLog::query()->delete();
        } else {
            $user_id = auth()->user()->id;

            CrawlingLog::whereHas('GetDomain', function ($query) use ($user_id) {
                $query->where('ownerID', $user_id);
            })->delete();
        }
        return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
    }


    public function CrawlDeleteScheduling(Request $request)
    {
        CrawlDeleteScheduling::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            [
                'user_id' => auth()->user()->id,
                'delete_type' => $request->delete_type,
            ],
        );

        if (empty($request->id)) {
            $msg = 'Schedule successfully';
        } else {
            $msg = 'Schedule updated successfully';
        }
        return response()->json(['msg' => $msg, 'url' => route('crawlLog')]);
    }

    public function delete_scheduling($user_id)
    {
        // Get the IDs of websites owned by the user
        $websiteIds = Websites::where('ownerID', $user_id)->pluck('websiteID');
        // Delete CrawlingLog records for the user's websites
        CrawlingLog::whereIn('websiteID', $websiteIds)->delete();
    }
}
