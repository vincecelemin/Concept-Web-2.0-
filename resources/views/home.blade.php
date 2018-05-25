@extends('layouts.app')
@section('content')
<div class="container-fluid row">
    <div class="col-md-2 offset-md-2 pr-4" id="sidenav">
        <h5 class="text-right mb-0">Welcome,</h5>
        <h1 class="text-right mb-8">{{ Auth::user()->shop_profile->shop_name }}</h1>

        <div class="col-12 text-right p-0">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" data-toggle="list" href="#home-product-container">Products</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile">Orders</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile">Sales</a>
            </div>
        </div>

        <div class="text-right">
            <a href="#" class="btn-link btn text-dark p-0 mt-4"><i class="fas fa-edit"></i> <i>Update your profile</i></a>
        </div>
    </div>

    <div class="col-md-7 offset-md-4 pl-4" id="content-view">
        <h1>Products <a href="/products/create" class="btn btn-link text-dark p-0 align-bottom"><i class="fas fa-plus fa-xs"></i> New</a></h1>

        <div class="container-fluid">
            @if(count($products) == 0)
                <h4 class="mt-5">Your product list seems to be empty. You can add some by clicking <a href="products/create" class="text-dark">here!</a></h4>

            @else
                <div id="home-product-container">
                    @foreach($products as $product)
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{asset('storage/product_images/'.$product->pictures->first()->image_location)}}" alt="{{$product->name}}" style="width: 250px; height: 250px;">
                        <div class="card-body">
                            <h5 class="card-title"><b>{{$product->name}}</b></h5>
                            <p class="card-text">{{$product->description}}</p>
                            <div class="text-right">
                                <a href="/products/{{$product->id}}/edit" class="btn btn-outline-dark">Edit</a>
                                <a href="/products/{{$product->id}}" class="btn btn-outline-dark">View</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
</div>
@endsection
