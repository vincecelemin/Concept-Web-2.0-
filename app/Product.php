<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    public $primaryKey = 'id';
    
    public function shop_profile() {
        return $this->belongsTo('App\ShopProfile');
    }

    public function pictures(){
        return $this->hasMany('App\ProductPicture');
    }

    public function delivery_items(){
        return $this->belongsTo('App\DeliveryItem');
    }
}
