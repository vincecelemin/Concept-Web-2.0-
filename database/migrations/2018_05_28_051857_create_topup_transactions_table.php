<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopupTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'customer_profile_id', ['length'=>10, 'unsigned'=>true]);
            $table->decimal('amount', 7, 2);
            $table->addColumn('string', 'type', ['length'=>1]);
            $table->timestamp('transaction_date');

            $table->index('customer_profile_id');
            $table->foreign('customer_profile_id')->on('customer_profiles')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topup_transactions');
    }
}
