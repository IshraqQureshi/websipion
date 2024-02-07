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
        if (!Schema::hasTable('Websites')) {
            Schema::create('Websites', function (Blueprint $table) {
                $table->id('websiteID');
                $table->unsignedBigInteger('ownerID');
                $table->string('domainName');
                $table->string('favicon_name')->nullable();
                $table->integer('package_id')->nullable();
                $table->string('frequency');
                $table->enum('status', ['0', '1'])->default(1)->comment('0 disabled, 1 enabled (default)');
                $table->foreign('ownerID')->references('id')->on('users');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Websites');
    }
};
