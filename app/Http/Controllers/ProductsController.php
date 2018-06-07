<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\DeliveryItem;
use App\ProductPicture;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index')->with('products', Auth::user()->shop_profile->products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required|string|min:5|max:35',
            'product_description' => 'required|string',
            'genderRadio' => 'required|in:male,female,unisex',
            'product_category' => 'required|in:shirt,pants,jacket,shoes,accessory',
            'product_price' => 'required|between:0.00,9999999.99',
            'product_stock' => 'required|numeric',
            'product_logo' => 'required|image|max:1999',
            'additional_p' => 'nullable',
            'additional_p.*' => 'image|max:1999'
        ]);
        $gender_array = array('male' => 'M', 'female' => 'F', 'unisex' => 'U');
        $categories_array = array('shirt' => '1', 'pants' => '2', 'jacket' => '3', 'shoes' => '4','accessory' => '5');

        $product = new Product;
        $product->name = $request['product_name'];
        $product->description = trim($request['product_description']);
        $product->gender = $gender_array[$request['genderRadio']];
        $product->category = $categories_array[$request['product_category']];
        $product->price = $request['product_price'];
        $product->stock = $request['product_stock'];
        $product->shop_profile_id = Auth::user()->shop_profile->id;
        $ctr = 0;

        if($product->save()){
            // Get file name with the extension
            $filenameWithExt = $request->file('product_logo')->getClientOriginalName();
    
            //Get just the file name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    
            // Get just the extension
            $extension = $request->file('product_logo')->getClientOriginalExtension();
    
            // Filename to store
            $filenameToStore = $product->id.'_'.$ctr.'.'.$extension;
    
            //Upload Image
            $path = $request->file('product_logo')->storeAs('public/product_images', $filenameToStore);

            $product_image = new ProductPicture;
            $product_image->image_location = $filenameToStore;
            $product_image->product_id = $product->id;
            if($product_image->save()) {
                $ctr ++;

                if($request->hasFile('additional_p')) {
                    foreach($request->file('additional_p') as $a_picture) {
                        $additional_p_fname = $a_picture->getClientOriginalName();
                        $filename = pathinfo($additional_p_fname, PATHINFO_FILENAME);
                        $extension = $a_picture->getClientOriginalExtension();
                        $filenameToStore = $product->id.'_'.$ctr.'.'.$extension;
                        $path = $a_picture->storeAs('public/product_images', $filenameToStore);                  
                        
                        $add_product_image = new ProductPicture;
                        $add_product_image->image_location = $filenameToStore;
                        $add_product_image->product_id = $product->id;

                        if(!$add_product_image->save()) {
                            $product = Product::find($product->id);
                            $product->pictures->delete();
                            $product->delete();

                            return Redirect::back()->withErrors(['msg', 'Invalid Files']);
                        }
                        $ctr++;
                    }
                }

                return redirect('/')->with('success', $product->name.' has been added!');
            } else {
                $product = Product::find($product->id);
                $product->pictures->delete();
                $product->delete();

                return Redirect::back()->withErrors(['msg', 'Invalid Files']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        $orders = DB::table('delivery_items')
        ->join('products', 'delivery_items.product_id', '=', 'products.id')
        ->join('deliveries', 'delivery_items.delivery_id', '=', 'deliveries.id')
        ->select('delivery_items.*', 'deliveries.*', 'products.id as product_id', 'products.name', 'delivery_items.id as order_id')
        ->where('products.id', '=', $id)
        ->orderBy('delivery_items.id', 'desc')
        ->get();

        $data = array(
            'product' => $product,
            'orders' => $orders
        );
        
        return view('products.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_name' => 'required|string|min:5|max:35',
            'product_description' => 'required|string',
            'genderRadio' => 'required|in:male,female,unisex',
            'product_category' => 'required|in:shirt,pants,jacket,shoes,accessory',
            'product_price' => 'required|between:0.00,9999999.99',
            'product_stock' => 'required|numeric'
        ]);
        $gender_array = array('male' => 'M', 'female' => 'F', 'unisex' => 'U');
        $categories_array = array('shirt' => '1', 'pants' => '2', 'jacket' => '3', 'shoes' => '4','accessory' => '5');

        $product = Product::find($id);
        $product->name = $request['product_name'];
        $product->description = trim($request['product_description']);
        $product->gender = $gender_array[$request['genderRadio']];
        $product->category = $categories_array[$request['product_category']];
        $product->price = $request['product_price'];
        $product->stock = $request['product_stock'];
        if($product->save()) {
            return redirect('products/'.$id)->with('success', 'Product #'.$id.' has been updated.');
        } else {
            return redirect('products/'.$id)->with('error', 'Error updating product #'.$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function restock($id, Request $request) {
        $this->validate($request, [
            'stock_input' => 'numeric|min:0|max:99999'
        ], [
            'stock_input.numeric' => 'Enter a valid quantity for product stock.',
            'stock_input.max' => 'Stock input exceeds limit'
        ]);

        $product = Product::find($id);
        $product->stock = $request['stock_input'];
        if($product->save()) {
            return redirect('/products/'.$id)->with('success', 'Stock has been updated');
        } else {
            return redirect('/products/'.$id)->with('error', 'Error updating stock');
        }
    }
}
