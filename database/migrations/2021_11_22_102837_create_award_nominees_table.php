<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_nominees', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('full_name');
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('company_individual');
            $table->string('company_details')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('vote')->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('award_categories')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('award_nominees');
    }
}
