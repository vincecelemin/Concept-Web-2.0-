@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Update Product #{{$product->id}}</h2>

        <form action="/products/{{$product->id}}" method="POST" enctype="multipart/form-data" class="row">
            @method('PUT')
            @csrf
            <div class="col-6 pr-3" style="border-right: 1px solid rgba(200,200,200,.15);">
                <div class="form-group">
                    <label for="product_name" class="col-form-label pb-0">{{ __('Product Name') }}</label>
    
                    <div>
                        <input id="product_name" type="text" class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }}" value="{{$product->name}}"name="product_name" value="{{ old('product_name') }}" required autofocus>
    
                        @if ($errors->has('product_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="product_description" class="col-form-label py-0">{{ __('Product Description') }}</label>
    
                    <div>
                        <textarea name="product_description" id="product_description" rows="5" class="form-control{{ $errors->has('product_description') ? ' is-invalid' : '' }}" required>
                            {{ trim($product->description) }}
                        </textarea>
    
                        @if ($errors->has('product_description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group">
                    <label for="product_price" class="col-form-label py-0">{{ __('Product Price') }}</label>
    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">₱</span>
                        </div>

                        <input id="product_price" type="text" value="{{$product->price}}" class="form-control{{ $errors->has('product_price') ? ' is-invalid' : '' }}" name="product_price" value="{{ old('product_price') }}"  placeholder="0.00" aria-describedby="basic-addon1" required>
    
                        @if ($errors->has('product_price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
            </div>

            <div class="col-6 pl-3">
                <div class="form-group">
                    <label for="product_stock" class="col-form-label pb-0">{{ __('Current Stock') }}</label>
    
                    <div>
                        <input id="product_stock" type="text" value="{{$product->stock}}" class="form-control{{ $errors->has('product_stock') ? ' is-invalid' : '' }}" name="product_stock" value="{{ old('product_stock') }}" required autofocus>
    
                        @if ($errors->has('product_stock'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_stock') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="product_gender" class="col-form-label pb-0">{{ __('Targeted Gender') }}</label>
    
                    <span id="product_gender" class="ml-3 align-middle">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genderRadio" id="maleRadio" value="male"
                            @if($product->gender == 'M')
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="maleRadio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genderRadio" id="femaleRadio" value="female"
                            @if($product->gender == 'F')
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="femaleRadio">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genderRadio" id="unisexRadio" value="unisex"
                            @if($product->gender == 'U')
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="unisexRadio">Unisex</label>
                        </div>
    
                        @if ($errors->has('product_gender'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_gender') }}</strong>
                            </span>
                        @endif
                    </span>
                </div>

                <div class="form-group">
                    <label for="product_category" class="col-form-label pb-0">{{ __('Category') }}</label>
                    <select class="custom-select" name="product_category" id="product_category">
                        <option value="shirt"
                        @if($product->category == '1')
                        selected
                        @endif
                        >Shirt</option>
                        <option value="pants"
                        @if($product->category == '2')
                        selected
                        @endif
                        >Pants</option>
                        <option value="jacket"
                        @if($product->category == '3')
                        selected
                        @endif
                        >Jacket</option>
                        <option value="shoes"
                        @if($product->category == '4')
                        selected
                        @endif
                        >Shoes</option>
                        <option value="accessory"
                        @if($product->category == '5')
                        selected
                        @endif
                        >Accessory</option>
                    </select>
                </div>

                <div class="text-right">
                    <a href="{{url('/products/'.$product->id)}}" class="btn btn-outline-dark">Back</a>
                    <button class="btn btn-dark" type="submit">Update Product</button>
                </div>
            </div>
        </form>
    </div>
@endsection