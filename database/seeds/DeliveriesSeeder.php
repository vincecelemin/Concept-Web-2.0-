<?php

use Illuminate\Database\Seeder;

class DeliveriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('deliveries')->insertGetId([
            'customer_profile_id' => '1',
            'contact_person' => 'JC Cristobal',
            'location' => 'Lipa City',
            'contact_number' => '09151234567',
            'payment_type' => '1',
            'added' => '2018-06-01 18:16:52',
            'arrival_date' => '2018-06-04 11:23:10'
        ]);

        DB::table('delivery_items')->insert([
            'delivery_id' => $id,
            'product_id' => '2',
            'quantity' => '2',
            'price' => '499.00',
            'status' => '1'
        ]);

        DB::table('delivery_items')->insert([
            'delivery_id' => $id,
            'product_id' => '3',
            'quantity' => '1',
            'price' => '250.00',
            'status' => '1'
        ]);

        DB::table('delivery_items')->insert([
            'delivery_id' => $id,
            'product_id' => '3',
            'quantity' => '1',
            'price' => '250.00',
            'status' => '2'
        ]);
        
        $id = DB::table('deliveries')->insertGetId([
            'customer_profile_id' => '1',
            'contact_person' => 'JC Cristobal',
            'location' => 'Lipa City',
            'contact_number' => '09151234567',
            'payment_type' => '1',
            'added' => '2018-06-09 18:16:52',
            'arrival_date' => '2018-06-13 18:16:52'
        ]);

        DB::table('delivery_items')->insert([
            'delivery_id' => $id,
            'product_id' => '3',
            'quantity' => '1',
            'price' => '250.00',
            'status' => '0'
        ]);
    }
}
