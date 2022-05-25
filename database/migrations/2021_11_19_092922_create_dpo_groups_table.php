<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpoGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpo_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('enable_dpo');
            $table->string('dpo_base_url');
            $table->string('dpo_company_token');
            $table->string('dpo_default_currency');
            $table->string('dpo_default_country');
            $table->string('dpo_default_service');
            $table->string('dpo_default_service_description');
            $table->boolean('dpo_sandbox')->default(false);
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
        Schema::dropIfExists('dpo_groups');
    }
}
