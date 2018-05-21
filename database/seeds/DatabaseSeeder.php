<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypesSeeder::class);
        $this->call(ShopUserSeeder::class);
        $this->call(CustomerAccountSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
