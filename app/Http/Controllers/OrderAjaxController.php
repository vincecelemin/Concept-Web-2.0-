<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DeliveryItem;
use Illuminate\Support\Facades\DB;

class OrderAjaxController extends Controller
{
    public function index($id) {
        $delivery_item = DB::table('delivery_items')
        ->join('products', 'delivery_items.product_id', '=', 'products.id')
        ->join('deliveries', 'delivery_items.delivery_id', '=', 'deliveries.id')
        ->where('delivery_items.id', '=', $id)
        ->where('products.shop_profile_id', '=', Auth::user()->shop_profile->id)
        ->select('delivery_items.*', 'deliveries.*', 'products.id as product_id', 'products.name', 'delivery_items.id as order_id')
        ->orderBy('delivery_items.id', 'desc')
        ->get();
        return response()->json(array('order' => $delivery_item), 200);
    }
}
