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
            $table->string('reference');
            $table->float('amount', 15, 4)->nullable();
            $table->string('currency');
            $table->float('charged_amount', 15, 4)->nullable();
            $table->string('charged_currency')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('flw_reference')->nullable();
            $table->string('order_reference')->nullable();
            $table->string('payment_plan')->nullable();
            $table->string('payment_page')->nullable();
            $table->timestamp('payent_created_at')->nullable();
            $table->decimal('appfee', 15, 2)->nullable();
            $table->decimal('merchantfee', 15, 2)->nullable();
            $table->boolean('merchantbearsfee')->nullable();
            $table->string('charge_type')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_full_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_accountId')->nullable();
            $table->string('entity_card6')->nullable();
            $table->string('entity_card_last4')->nullable();
            $table->string('entity_card_country_iso')->nullable();
            $table->string('event_type')->nullable();
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
