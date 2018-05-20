<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopProfile extends Model
{
    public $table = 'shop_profiles';
    public $primaryKey = 'id';

    public function products(){
        return $this->hasMany('App\Product');
    }
}
