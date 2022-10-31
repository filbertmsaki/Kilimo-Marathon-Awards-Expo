<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPhonecodeToExpoRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expo_registrations', function (Blueprint $table) {
            $table->string('service_business_name')->after('company_name');

            $table->bigInteger('phonecode')->default(255)->after('contact_person_name');
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
