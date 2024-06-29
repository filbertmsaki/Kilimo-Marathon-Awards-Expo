<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToExpoRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expo_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('expo_registrations', 'transactionref')) {
                $table->string('transactionref')->after('slug')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expo_registrations', function (Blueprint $table) {
            //
        });
    }
}
