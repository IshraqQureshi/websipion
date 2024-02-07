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
        if (!Schema::hasTable('PaymentDetails')) {
            Schema::create('PaymentDetails', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userID');
                $table->integer('packagesID');
                $table->integer('totalWebsite')->default(1);
                $table->string('invoiceNumber');
                $table->string('transactionID');
                $table->string('subscriptionID')->nullable();
                $table->string('paymentMode')->nullable();
                $table->bigInteger('totalPayment');
                $table->string('transactionTime')->nullable();
                $table->string('expiryDate')->nullable();
                $table->foreign('userID')->references('id')->on('users');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PaymentDetails');
    }
};
