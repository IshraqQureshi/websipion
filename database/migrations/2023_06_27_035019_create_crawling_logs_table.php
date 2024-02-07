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
        if (!Schema::hasTable('CrawlingLog')) {
            Schema::create('CrawlingLog', function (Blueprint $table) {
                $table->id();
                $table->integer('websiteID');
                $table->string('crawlTime');
                $table->enum('status', ['0', '1', '2'])->default(1)->comment('(0,1,2) - 0 down, 1 up, 2 failed');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CrawlingLog');
    }
};
