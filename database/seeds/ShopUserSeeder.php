<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class ShopUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email = 'conceptstore@test.biz';
        $user->password = Hash::make('password');
        $user->user_type = '1';
        $user->save();

        DB::table('shop_profiles')->insert([
            'shop_name' => 'Concept Store',
            'shop_description' => 'Store made, store distributed',
            'shop_location' => 'Lipa City',
            'user_id' => $user->id
        ]);
    }
}
