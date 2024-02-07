<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
             HelpContentSeeder::class,
             LogoSeeder::class,
             PaymentGatewaySeeder::class,
             SmtpSeeder::class,
             EmailTemplateSeeder::class,
             CountrySeeder::class,
            //SuperAdminSeeder::class,
        ]);
    }
}
