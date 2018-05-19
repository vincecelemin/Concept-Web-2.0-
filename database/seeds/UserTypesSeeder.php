<?php

use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'id' => '1',
            'type_name' => 'Store',
            'type_description' => 'Is able to add and manage products as well as the orders and sales generated from said products.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('user_types')->insert([
            'id' => '2',
            'type_name' => 'Customer',
            'type_description' => 'Can order and/or purchase products displayed by the Store Owners',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
