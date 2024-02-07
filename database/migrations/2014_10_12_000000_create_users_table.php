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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->enum('role', ['1', '2'])->default('2')->comment('1 admin, 2 user')->nullable();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('mobile')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('status', ['1', '2'])->default('1')->comment('active, inactive');
                $table->string('coins')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->default('101')->nullable();
                $table->string('zipCode')->nullable();
                $table->string('gstNumber')->nullable();
                $table->string('default_language')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
