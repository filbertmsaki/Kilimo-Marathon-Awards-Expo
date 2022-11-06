<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumsNamesToExpoRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('expo_registrations');
        Schema::create('expo_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('entry');
            $table->bigInteger('phonecode')->default(255);
            $table->string('company_name');
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('service_name')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('company_details');
            $table->string('address')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('paid')->default(0);
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
        Schema::table('expo_registrations', function (Blueprint $table) {
            //
        });
    }
}
