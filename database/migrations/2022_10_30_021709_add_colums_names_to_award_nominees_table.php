<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsNamesToAwardNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_nominees', function (Blueprint $table) {
            $table->integer('entry')->after('category_id');
            $table->string('service_name')->nullable()->after('company_name');
            $table->string('company_email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('company_individual')->nullable()->change();


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
