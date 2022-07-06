<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarathonRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marathon_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('event');
            $table->string('region')->nullable();
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('marathon_registrations');
    }
}
