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
            $table->enum('site_up_mail',[0,1])->default(0)->comments('0 is mail not send, 1 is send mail');
            $table->enum('site_down_mail',[0,1])->default(0)->comments('0 is mail not send, 1 is send mail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Websites', function (Blueprint $table) {
            //
        });
    }
};
