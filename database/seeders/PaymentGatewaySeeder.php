<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'key_id'=> '',
            'key_secret'=> '',
            'razorpay_on_off' => '',
            'paypal_on_off' => '',
            'paypal_type' => '',
            'paypal_client_id' => '',
            'paypal_client_secret' => '',
            'stripe_on_off' => '',
            'stripe_client_id' => '',
            'stripe_client_secret' => '',
        ]);
    }
}
