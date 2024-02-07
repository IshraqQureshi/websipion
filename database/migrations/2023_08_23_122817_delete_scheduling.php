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
        // delete_scheduling
        Schema::create('crawl_log_delete_scheduling', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('delete_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawl_log_delete_scheduling');
    }
};
