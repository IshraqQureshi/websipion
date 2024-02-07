<?php

namespace App\Providers;

use App\Models\SocialSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class SocialSettinsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $social_settings = SocialSetting::first();

            if (!is_null($social_settings)) {
                if ($social_settings->google_on_off == 'on' || $social_settings->linkedin_on_off == 'on') {
                    Config::set('services.google.client_id', $social_settings->google_client_id);
                    Config::set('services.google.client_secret', $social_settings->google_client_secret);
                    Config::set('services.google.redirect', $social_settings->google_redirect);
                    Config::set('services.linkedin.client_id', $social_settings->linkedin_client_id);
                    Config::set('services.linkedin.client_secret', $social_settings->linkedin_client_secret);
                    Config::set('services.linkedin.redirect', $social_settings->linkedin_redirect);
                    
                } 
            }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
