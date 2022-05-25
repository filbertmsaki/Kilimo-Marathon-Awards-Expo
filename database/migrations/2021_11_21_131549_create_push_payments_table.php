<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_payments', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('result')->nullable();
            $table->string('resultexplanation')->nullable();
            $table->string('transactiontoken')->nullable();
            $table->string('transactionref')->nullable();
            $table->string('customername')->nullable();
            $table->string('customercredit')->nullable();
            $table->string('customercredittype')->nullable();
            $table->string('transactionapproval')->nullable();
            $table->string('transactioncurrency')->nullable();
            $table->float('transactionamount',15,2)->nullable();
            $table->string('fraudalert')->nullable();
            $table->string('fraudexplnation')->nullable();
            $table->float('transactionnetamount',15,2)->nullable();
            $table->string('transactionsettlementdate')->nullable();
            $table->float('transactionrollingreserveamount',15,2)->nullable();
            $table->string('transactionrollingreservedate')->nullable();
            $table->string('customerphone')->nullable();
            $table->string('customercity')->nullable();
            $table->string('customercountry')->nullable();
            $table->string('customeraddress')->nullable();
            $table->string('customerzip')->nullable();
            $table->string('transactionfinalcurrency')->nullable();
            $table->float('transactionfinalamount',15,2)->nullable();
            $table->string('mobilepaymentrequest')->nullable();
            $table->string('accref')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('push_payments');
    }
}
