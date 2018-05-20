<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('integer', 'shop_id', ['unsigned' => true, 'length' => 10]);
            $table->addColumn('string', 'name', ['length'=>35]);
            $table->text('description');
            $table->decimal('price', '7', '2');
            $table->integer('stock');
            $table->timestamps();

            $table->index('shop_id');
            $table->foreign('shop_id')->on('shop_profiles')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
