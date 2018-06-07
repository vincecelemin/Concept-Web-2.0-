@extends('layouts.app')

@section('content')
    <div class="container">
        @include('inc.messages')
        <h1>Your Products</h1>
        @if(count($products) == 0)
            <h4 class="mt-5">Your product list seems to be empty. You can add some by clicking <a href="products/create" class="text-dark">here!</a></h4>

        @else
            <div id="products-page-container">
                @foreach($products as $product)

                @if($product->isActive == '1')
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top container-fluid p-2" src="{{asset('storage/product_images/'.$product->pictures->first()->image_location)}}" alt="{{$product->name}}" style="width: 250px; height: 250px;">
                    <div class="card-body">
                        <h5 class="card-title"><b>{{$product->name}}</b></h5>
                        <p class="card-text">{{$product->description}}</p>
                        <div class="text-right">
                            <a href="/products/{{$product->id}}/edit" class="btn btn-outline-dark">Edit</a>
                            <a href="/products/{{$product->id}}" class="btn btn-outline-dark">View</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        @endif
        
        <div class="my-4">
            <h3>Deleted Products</h3>
            @if(count($products) > 0)
                <div id="products-page-container">
                    @foreach($products as $product)
    
                    @if($product->isActive == '0')
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><b>{{$product->name}}</b></h5>
                            <p class="card-text">{{$product->description}}</p>

                            <form action="/products/{{$product->id}}/restore" method="POST" class="text-right">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark">Restore</a>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
@endsection