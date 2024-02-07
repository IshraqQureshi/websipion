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
        if (Schema::hasTable('Packages')) {
            Schema::table('Packages', function (Blueprint $table) {
                // Modify the 'webStatus' column
                $table->enum('webStatus', ['0', '1'])->default('1')->comment('(0,1) - 0 hide, 1 show')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('Packages')) {
            Schema::table('Packages', function (Blueprint $table) {
                // Revert the column changes if needed
                $table->string('webStatus')->default('1')->comment('(0,1) - 0 hide, 1 show')->change();
            });
        }
    }
};
