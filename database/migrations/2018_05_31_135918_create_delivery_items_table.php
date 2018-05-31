<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_items', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'delivery_id', ['length' => 10, 'unsigned' => true]);
            $table->addColumn('integer', 'product_id', ['length' => 10, 'unsigned' => true]);
            $table->addColumn('integer', 'quantity', ['unsigned' => true]);
            $table->decimal('price',7,2);

            $table->index('delivery_id');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_items');
    }
}
