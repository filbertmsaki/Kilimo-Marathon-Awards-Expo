<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlutterwaveModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flutterwaves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('payable');  // For polymorphic relations
            $table->string('transaction_id')->nullable();
            $table->string('reference');
            $table->string('flw_reference')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->float('amount', 15, 4)->nullable();
            $table->string('currency');
            $table->float('charged_amount', 15, 4)->nullable();
            $table->string('charged_currency')->nullable();
            $table->decimal('app_fee', 15, 2)->nullable();
            $table->decimal('merchant_fee', 15, 2)->nullable();
            $table->string('processor_response')->nullable();
            $table->string('auth_model')->nullable();
            $table->string('ip')->nullable();
            $table->string('narration')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_type')->nullable();
            $table->timestamp('payent_created_at')->nullable();
            $table->string('customer_phone_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('card_first_6digits')->nullable();
            $table->string('card_last_4digits')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_country')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_expiry')->nullable();
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
        Schema::dropIfExists('flutterwaves');
    }
}
