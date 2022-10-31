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
            $table->string('first_name');
            $table->string('last_name');
            $table->char('gender')->nullable();
            $table->integer('age')->nullable();
            $table->bigInteger('phonecode')->default(255);
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('event');
            $table->string('t_shirt_size')->nullable();
            $table->string('address')->nullable();
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
