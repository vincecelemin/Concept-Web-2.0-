<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    public $table = 'product_pictures';
    public $primaryKey = 'id';

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
