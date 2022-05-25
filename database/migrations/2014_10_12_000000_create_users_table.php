<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
           
            $date = Carbon::now()->format('Y');
            $ip = request()->getClientIp();

            $id = $date.rand(00000,999999);
            $table->bigIncrements('id')->from($id);
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('first_name')->nullable();;
            $table->string('last_name')->nullable();;
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->string('last_login_ip')->default($ip);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
