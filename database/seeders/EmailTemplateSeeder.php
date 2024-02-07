<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::create([
            'status_title' => 'Website is down',
            'title' => 'HTTP 500 Internal Server Error',
            'text' => 'Website home page is not accessible now. Back your website to 200 OK HTTP status code as fast as possible. Contact your hosting provider or web developer if you have no idea why this error happens.',
            'short_text' => 'This notification is sent to you as a part of your SiteDownDetector account from all project notifications',
        ]);
    }
}
