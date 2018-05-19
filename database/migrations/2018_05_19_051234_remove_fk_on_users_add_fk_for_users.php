<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFkOnUsersAddFkForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });

        Schema::table('shop_profiles', function(Blueprint $table){
            $table->addColumn('integer', 'user_id', ['unsigned' => true, 'length' => '10'])->unique();
            $table->foreign('user_id')->on('users')->references('id');
        });

        Schema::table('customer_profiles', function(Blueprint $table){
            $table->addColumn('integer', 'user_id', ['unsigned' => true, 'length' => '10'])->unique();
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_profiles', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        
        Schema::table('customer_profiles', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
