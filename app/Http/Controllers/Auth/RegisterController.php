<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ShopProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'store_name' => 'required|string|max:20',
            'store_description' => 'required|string',
            'store_location' => 'required|string|min:10'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $shop_user = new User;
        $shop_user->email = $data['email'];
        $shop_user->password = Hash::make($data['password']);
        $shop_user->user_type = '1';
        $shop_user->save();

        $shop_profile = new ShopProfile;
        $shop_profile->shop_name = $data['store_name'];
        $shop_profile->shop_description = $data['store_description'];
        $shop_profile->shop_location = $data['store_location'];
        $shop_profile->user_id = $shop_user->id;
        if($shop_profile->save()) {
            return $shop_user;
        } else {
            $delete_shop = User::find($shop_user->id);
            $delete_shop->delete();
        }
    }
}
