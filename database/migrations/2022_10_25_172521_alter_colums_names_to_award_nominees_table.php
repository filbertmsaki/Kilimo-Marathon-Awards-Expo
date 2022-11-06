<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumsNamesToAwardNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_nominees', function (Blueprint $table) {
            $table->renameColumn('full_name', 'company_name');
            $table->renameColumn('email', 'contact_person_email');
            $table->renameColumn('mobile', 'contact_person_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('award_nominees', function (Blueprint $table) {
            //
        });
    }
}
