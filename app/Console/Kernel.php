<?php

namespace App\Console;

use App\Http\Controllers\Admin\CrawlingController;
use App\Http\Controllers\Admin\PackagesController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $websites = DB::table('Websites')->where('status', '1')->orderBy('websiteID', 'DESC')->distinct()->groupBy('frequency')->get();
        foreach ($websites as $key => $value) {
            $frequency = $value->frequency;
            $schedule->call(function () use ($frequency) {
                $callweb = new PackagesController();
                $callweb->crawl($frequency);
            })->$frequency();
        }

        $deleteLog = DB::table('crawl_log_delete_scheduling')->get();
        foreach ($deleteLog as $key => $value) {
            if(!empty($value->delete_type)){
                $frequency = $value->delete_type;
                $user_id = $value->user_id;
                $schedule->call(function () use ($frequency, $user_id) {
                    $Crawling =  new CrawlingController();
                    $Crawling->delete_scheduling($user_id);
                })->$frequency();
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
