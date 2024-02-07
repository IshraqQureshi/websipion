<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Websites;
use App\Models\CrawlingLog;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public  function index()
    {
        $frequency = frequency();
        $overview = array();

        if (Auth::user()->role == 1 || Auth::user()->role == 3) {

            foreach( $frequency as $key=>$fr ){
                $data = Websites::where('frequency', $key)
                            ->select('domainName', 'favicon_name')->orderBy('websiteID', 'DESC')->take(6)->get();
                $count = Websites::where('frequency', $key)->count();
                $overview[] = array(
                    'title'     => $fr,
                    'checked'   => $data,
                    'count'     => $count,
                );
            }

            $WebsitesActive = CrawlingLog::with('website')->where('status', '=', '1')
                ->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID');
            $TotalDomainsActive = CrawlingLog::where('status', '=', '1')->orderBy('websiteID', 'DESC')->get()->unique('websiteID')->count();
            $WebsitesDown = CrawlingLog::with('website')->where('status', '=', '0')->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID');
            $TotalDomainsDown = CrawlingLog::where('status', '=', '0')->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID')->count();
            $Websites = Websites::orderBy('websiteID', 'DESC')->take(9)->get();
        } else {
            $user_id = Auth::user()->id;
            foreach( $frequency as $key=>$fr ){
                $data = Websites::where(['frequency' => $key, 'ownerID' => $user_id])
                            ->select('domainName', 'favicon_name')->orderBy('websiteID', 'DESC')->take(6)->get();
                $count = Websites::where(['frequency' => $key, 'ownerID' => $user_id])->count();
                $overview[] = array(
                    'title'     => $fr,
                    'checked'   => $data,
                    'count'     => $count,
                );
            }

            $WebsitesActive = CrawlingLog::whereHas('website', function ($query) use ($user_id) {
                $query->where('ownerID', $user_id);
            })->with('website')->where('status', '=', '1')->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID');

            $TotalDomainsActive = CrawlingLog::whereHas('website', function ($query) use ($user_id) {
                $query->where('ownerID', $user_id);
            })->where('status', '=', '1')->orderBy('websiteID', 'DESC')->get()->unique('websiteID')->count();

            $WebsitesDown = CrawlingLog::whereHas('website', function ($query) use ($user_id) {
                $query->where('ownerID', $user_id);
            })->with('website')->where('status', '=', '0')->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID');

            $TotalDomainsDown = CrawlingLog::whereHas('website', function ($query) use ($user_id) {
                $query->where('ownerID', $user_id);
            })->where('status', '=', '0')->orderBy('websiteID', 'DESC')->take(6)->get()->unique('websiteID')->count();

            $Websites = Websites::where('ownerID', Auth::user()->id)->orderBy('websiteID', 'DESC')->take(9)->get();
        }


        $overview[] = array(
                'title'     => __('dashboard.active_website'),
                'checked'   => $WebsitesActive,
                'count'    => $TotalDomainsActive
            );
        $overview[] = array(
                'title'     => __('dashboard.website_down'),
                'checked'   => $WebsitesDown,
                'count'     => $TotalDomainsDown
            );

        $data = array(
            'title'             => __('dashboard.dashboard'),
            'overview'          => $overview,
            'websites'          => $Websites
        );
        return view('dashboard.home', $data);
    }
}
