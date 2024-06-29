<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgriTourismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agri_tourisms', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender');
            $table->string('address')->nullable();
            $table->json('activities');
            $table->string('emergency_contact');
            $table->string('emergency_phone');
            $table->text('additional_info')->nullable();
            $table->boolean('agree_checkbox')->default(false);
            $table->string('transactionref')->nullable();
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
        Schema::dropIfExists('agri_tourisms');
    }
}
