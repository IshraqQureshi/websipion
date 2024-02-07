<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['1', '2'])->default('1')->comment('active, inactive')->change();

            if (!Schema::hasColumn('users', 'coins')) {
                $table->string('coins')->nullable();
            }
            if (!Schema::hasColumn('users', 'default_language')) {
                $table->string('default_language')->nullable();
            }

        });


        if (Schema::hasColumn('users', 'device_token', 'companyName', 'loginSource', 'social_id', 'membershipType')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['device_token', 'companyName', 'loginSource', 'social_id', 'membershipType']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
