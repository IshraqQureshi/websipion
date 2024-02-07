<?php

namespace Database\Seeders;

use App\Models\Help;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HelpContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $html = '<p class="mb-10 fs-4">Welcome to the Help page for SitedownDetector! This page provides detailed information on how to use the app and troubleshoot any issues you may encounter.</p>

        <h3>Getting Started</h3>
        <p>To get started with SitedownDetector, you will first need to login into the dashboard or you can download and install the app on your device. The app is available for download from the App Store and Google Play Store. Once you have installed the app, you can open it and begin using its features.</p>
        <h3>Adding Websites to Monitor</h3>
        <p>To monitor a website with SitedownDetector, you will need to add it to the list of monitored websites. To do this, simply tap the "Add Website" button on the dashboard or navigate to Add Website in Websites menu in the sidebar and enter the websites URL. You can also specify how often the app should check the websites availability and how you would like to be notified if the website goes down.</p>
        <h3>Monitoring Websites</h3>
        <p>Once you have added a website to SitedownDetector, it will begin monitoring your websites availability. You can view the status of each monitored website on the dashboard and in the Websites List. If a website goes down, you will receive a notification via email, push notification, or SMS (depending on your notification settings).</p>
        <h3>Troubleshooting Issues</h3>
        <p>If you encounter any issues with SitedownDetector, the following troubleshooting tips may help:</p>
        <ol>
            <li>Check your internet connection: SitedownDetector requires an active internet connection to monitor websites. If you are having trouble with the Site/App, make sure you have a stable internet connection.</li>

            <li>Verify website URL: Make sure that you have entered the correct website URL when adding a website to the app.</li>
            <li>Check notification settings: If you are not receiving notifications when a website goes down, check your notification settings to make sure they are configured correctly.</li>
            <li>Contact support: If you are still having trouble with the app, please contact our support team for further assistance. You can reach our support team by email or through the apps contact form.</li>
        </ol>
        <h3>Conclusion</h3>
        <p>SitedownDetector is a powerful tool for monitoring website availability and ensuring that your website is always up and running. By following the instructions above, you can get started with the app and troubleshoot any issues you may encounter. If you have any questions or need further assistance, please dont hesitate to contact our support team.</p>';

        Help::create([
            'help_content' => $html,
        ]);
    }
}
