<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
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
        $shop_products = Auth::user()->shop_profile->products;
        $data = array(
            'products' => $shop_products,
        );
        return view('home')->with($data);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
