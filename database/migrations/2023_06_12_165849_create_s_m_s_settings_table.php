<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key_id')->nullable();
            $table->string('key_secret')->nullable();
            $table->string('twilio_from')->nullable();
            $table->string('twilio_on_off')->nullable();
            $table->string('nexom_on_off')->nullable();
            $table->string('nexom_key')->nullable();
            $table->string('nexom_secret')->nullable();
            $table->string('aws_on_off')->nullable();
            $table->string('aws_key')->nullable();
            $table->string('aws_secret')->nullable();
            $table->string('aws_region')->nullable();
            $table->string('aws_topic_arn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_settings');
    }
};
