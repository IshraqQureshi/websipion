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
        Schema::table('Websites', function (Blueprint $table) {
            $table->text('email_cc_recipients')->nullable()->after('sms_notification');
            $table->text('ssl_check')->nullable()->after('email_cc_recipients');
            $table->text('tags')->nullable()->after('ssl_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
