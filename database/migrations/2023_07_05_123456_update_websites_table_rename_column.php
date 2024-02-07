<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWebsitesTableRenameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('Websites', 'packagesID') && !Schema::hasColumn('Websites', 'package_id')) {
            Schema::table('Websites', function (Blueprint $table) {
                // Rename the column 'packagesID' to 'package_id'
                $table->renameColumn('packagesID', 'package_id');

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

    }
}
