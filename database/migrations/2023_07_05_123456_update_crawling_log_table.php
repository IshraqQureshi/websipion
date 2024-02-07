<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCrawlingLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('CrawlingLog', 'ownerID', 'serverIP')) {
            Schema::table('CrawlingLog', function (Blueprint $table) {
                // Drop the foreign key constraint
                $table->dropForeign('crawlinglog_ownerid_foreign');

                // Modify the columns
                $table->unsignedBigInteger('websiteID')->change();
                $table->string('crawlTime')->change();
                $table->enum('status', ['0', '1', '2'])->default(1)->comment('(0,1,2) - 0 down, 1 up, 2 failed')->change();
                // Drop the 'ownerID' and 'serverIP' columns
                $table->dropColumn('ownerID');
                $table->dropColumn('serverIP');
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
        // Revert the changes if needed
    }
}
