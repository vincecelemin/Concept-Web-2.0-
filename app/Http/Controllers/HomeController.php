<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop_products = Auth::user()->shop_profile->products;

        $delivery_items = DB::table('delivery_items')
        ->join('products', 'delivery_items.product_id', '=', 'products.id')
        ->join('deliveries', 'delivery_items.delivery_id', '=', 'deliveries.id')
        ->join('product_pictures', 'products.id', '=', 'product_pictures.product_id')
        ->where('products.shop_profile_id', '=', Auth::user()->shop_profile->id)
        ->where('product_pictures.image_location', 'like', '%_0%')
        ->select('products.name', 'products.id', 'delivery_items.*', 'deliveries.added', 'deliveries.arrival_date', 'deliveries.contact_person', 'product_pictures.image_location')
        ->orderBy('delivery_items.id', 'desc')
        ->get();

        $data = array(
            'products' => $shop_products,
            'delivery_items' => $delivery_items,
        );
        return view('home')->with($data);
    }
}
