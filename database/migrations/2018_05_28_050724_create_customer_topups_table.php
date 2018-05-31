<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_topups', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'customer_profile_id', ['length'=>10, 'unsigned'=>true]);
            $table->decimal('balance', 7, 2)->default(0.00);
            $table->timestamps();

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
        Schema::dropIfExists('customer_topups');
    }
}
