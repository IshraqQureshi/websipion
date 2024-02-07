<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWebsitesTableModifyFrequencyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('Websites', 'frequency')) {
            Schema::table('Websites', function (Blueprint $table) {
                // Modify the 'frequency' column data type from enum to string
                $table->string('frequency')->change();
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
        if (Schema::hasColumn('Websites', 'frequency')) {
            Schema::table('Websites', function (Blueprint $table) {
                // Revert the changes by modifying the 'frequency' column data type back to enum
                $table->enum('frequency', ['1', '2'])->default(1)->comment('1 - Daily, 2 => Hourly')->change();
            });
        }
    }
}
