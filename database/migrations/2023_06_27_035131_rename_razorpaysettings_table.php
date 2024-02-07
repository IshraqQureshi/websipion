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
        if (Schema::hasTable('razorpaysettings')) {
            Schema::rename('razorpaysettings', 'settings');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('razorpaysettings')) {
            Schema::rename('settings', 'razorpaysettings');
        }
    }
};
