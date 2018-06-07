<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index() {
        $orders = DB::table('delivery_items')
        ->join('products', 'delivery_items.product_id', '=', 'products.id')
        ->join('product_pictures', 'products.id', '=', 'product_pictures.product_id')
        ->join('deliveries', 'delivery_items.delivery_id', '=', 'deliveries.id')
        ->where('product_pictures.image_location', 'like', '%_0%')
        ->select('delivery_items.*', 'deliveries.*', 'product_pictures.image_location', 'products.name', 'delivery_items.id as order_id')
        ->orderBy('delivery_items.id', 'desc')
        ->get();

        return view('orders.index')->with('orders', $orders);
    }
}
