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
        if (!Schema::hasTable('emailTemplate')) {
            Schema::create('emailTemplate', function (Blueprint $table) {
                $table->id();
                $table->longText('status_title');
                $table->longText('title');
                $table->longText('text');
                $table->longText('short_text');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emailTemplate');
    }
};
