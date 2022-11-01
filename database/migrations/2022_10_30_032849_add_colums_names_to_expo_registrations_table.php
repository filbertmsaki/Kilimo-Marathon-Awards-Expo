<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsNamesToExpoRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expo_registrations', function (Blueprint $table) {
            $table->integer('entry')->after('slug');
            $table->string('company_phone')->after('company_name');
            $table->string('company_email')->after('company_phone');
            $table->string('contact_person_email')->nullable()->change();
            $table->string('address')->nullable()->after('contact_person_email');
            $table->boolean('active')->default(0)->after('company_details');
            $table->boolean('paid')->default(0)->after('active');
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
