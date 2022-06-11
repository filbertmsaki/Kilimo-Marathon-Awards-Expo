<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardMarathonSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_marathon_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('marathon_registration')->default(false);
            $table->timestamp('marathon_registration_time_start')->nullable();
            $table->timestamp('marathon_registration_time_remain')->nullable();
            $table->boolean('vote')->default(false);
            $table->timestamp('vote_time_start')->nullable();
            $table->timestamp('vote_time_remain')->nullable();
            $table->boolean('awards_registration')->default(false);
            $table->timestamp('awards_registration_time_start')->nullable();
            $table->timestamp('awards_registration_time_remain')->nullable();
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
        Schema::dropIfExists('award_marathon_settings');
    }
}
