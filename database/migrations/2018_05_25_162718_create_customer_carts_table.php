<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'customer_profile_id', ['unsigned' => true, 'length' => 10]);
            $table->addColumn('integer', 'product_id', ['unsigned' => true, 'length' => 10]);
            $table->addColumn('integer', 'quantity', ['length'=>10]);
            $table->addColumn('string', 'isActive', ['length' => 1])->default('1');
            $table->addColumn('string', 'isProcessed', ['length' => 1])->default('0');
            $table->timestamp('addedIn');
            $table->timestamp('processedIn')->nullable();
            
            $table->index(['customer_profile_id', 'product_id']);
            $table->foreign('customer_profile_id')->references('id')->on('customer_profiles');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_carts');
    }
}
