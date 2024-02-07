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
            $table->enum('sms_notification', ['0', '1'])->after('status')->default('0')->comment('1 Active , 0 Deactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Websites', function (Blueprint $table) {
            $table->dropColumn('sms_notification');
        });
    }
};
