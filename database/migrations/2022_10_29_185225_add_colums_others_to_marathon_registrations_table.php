<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsOthersToMarathonRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marathon_registrations', function (Blueprint $table) {
            $table->string('last_name')->after('first_name');
            $table->char('gender')->nullable()->after('last_name');
            $table->integer('age')->nullable()->after('gender');
            $table->string('t_shirt_size')->nullable()->after('event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marathon_registrations', function (Blueprint $table) {
            //
        });
    }
}
