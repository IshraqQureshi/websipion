<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key_id')->nullable();
                $table->string('key_secret')->nullable();
                $table->string('razorpay_on_off')->nullable();
                $table->string('paypal_on_off')->nullable();
                $table->string('paypal_type')->nullable();
                $table->string('paypal_client_id')->nullable();
                $table->string('paypal_client_secret')->nullable();
                $table->string('stripe_on_off')->nullable();
                $table->string('stripe_client_id')->nullable();
                $table->string('stripe_client_secret')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
