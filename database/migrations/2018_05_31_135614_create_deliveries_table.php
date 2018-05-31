<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'customer_profile_id', ['length' => 10, 'unsigned' => true]);
            $table->string('contact_person');
            $table->string('location');
            $table->string('contact_number');
            $table->addColumn('string', 'payment_type', ['length' => 1]);
            $table->timestamp('added')->nullable();
            $table->timestamp('arrival_date')->nullable();

            $table->index('customer_profile_id');
            $table->foreign('customer_profile_id')->references('id')->on('customer_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
