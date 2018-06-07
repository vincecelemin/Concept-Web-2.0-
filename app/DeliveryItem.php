<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    public $table = 'delivery_items';
    public $primaryKey = 'id';
    public $timestamps = false;

    public function product(){
        return $this->hasOne('App\Product');
    }
}
