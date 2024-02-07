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
        if (!Schema::hasTable('Packages')) {
            Schema::create('Packages', function (Blueprint $table) {
                $table->id();
                $table->string('packageName')->nullable();
                $table->string('crawlFrequency')->nullable();
                $table->string('type')->nullable();
                $table->string('paymentType')->nullable();
                $table->string('price')->nullable();
                $table->enum('webStatus', ['0', '1'])->default(1)->comment('(0,1) - 0 hide , 1 show');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Packages');
    }
};
