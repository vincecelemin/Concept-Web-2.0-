<?php

use Illuminate\Database\Seeder;
use App\CustomerProfile;
use App\User;

class CustomerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_user = new User;
        $customer_user->email = 'customer@concept.biz';
        $customer_user->password = hash("sha256", "password");
        $customer_user->user_type = '2';
        $customer_user->save();

        $customer_profile = new CustomerProfile;
        $customer_profile->first_name = 'JC';
        $customer_profile->last_name = 'Cristobal';
        $customer_profile->gender = 1;
        $customer_profile->address = 'Lipa City';
        $customer_profile->user_id = $customer_user->id;

        $customer_profile->save();
    }
}
