<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'shop_profile_id' => 1,
            'name' => "White Men's Shirt",
            'description' => "A white shirt for men",
            'gender' => 'M',
            'price' => 199.00,
            'stock' => 10
        ]);
        DB::table('products')->insert([
            'shop_profile_id' => 1,
            'name' => "Blue Longsleeves",
            'description' => "A blue longsleeve shirt for men",
            'gender' => 'M',
            'price' => 499.00,
            'stock' => 5
        ]);
        DB::table('products')->insert([
            'shop_profile_id' => 1,
            'name' => "White Slippers",
            'description' => "Slippers for home use",
            'gender' => 'U',
            'price' => 250.00,
            'stock' => 5
        ]);
        DB::table('products')->insert([
            'shop_profile_id' => 1,
            'name' => "Women's Jeans",
            'description' => "Jeans for her",
            'gender' => 'F',
            'price' => 1299.00,
            'stock' => 5
        ]);
        DB::table('products')->insert([
            'shop_profile_id' => 1,
            'name' => "Stripped Blue Longsleeves",
            'description' => "Blue longsleeves for women",
            'gender' => 'F',
            'price' => 700.00,
            'stock' => 5
        ]);

        DB::table('product_pictures')->insert([
            'product_id' => 1,
            'image_location' => '1_0.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 1,
            'image_location' => '1_1.jpeg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 2,
            'image_location' => '2_0.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 2,
            'image_location' => '2_1.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 3,
            'image_location' => '3_0.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 4,
            'image_location' => '4_0.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 4,
            'image_location' => '4_1.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 5,
            'image_location' => '5_0.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 5,
            'image_location' => '5_1.jpg'
        ]);
        DB::table('product_pictures')->insert([
            'product_id' => 5,
            'image_location' => '5_2.jpg'
        ]);
    }
}
