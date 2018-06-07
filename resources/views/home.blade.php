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
        @include('inc.messages')
        <h1>Products <a href="/products/create" class="btn btn-link text-dark p-0 align-bottom"><i class="fas fa-plus fa-xs"></i> New</a></h1>

        <div class="container-fluid">
            @if(count($products) == 0)
                <h4 class="mt-5">Your product list seems to be empty. You can add some by clicking <a href="products/create" class="text-dark">here!</a></h4>

            @else
                <div id="home-product-container">
                    <?php
                        $ctr = 0;
                        ?>
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

                    <?php 
                        $ctr ++;

                        if($ctr == 6 && count($products) > 6) {
                            break;
                        }
                        ?>
                    @endif
                    @endforeach
                </div>
                
                @if($ctr == 6)
                    <a href="/products" class="text-dark m-2 text-right"><h4>See All</h4></a>
                @endif
            @endif
        </div>
        
    </div>

    @if($ctr == 6)    
    <div class="col-md-7 offset-md-4 pl-4" id="content-view">

    @else
    <div class="col-md-7 offset-md-4 pl-4 mt-3" id="content-view">

    @endif
        <h1>Orders</h1>
        <div class="containter-fluid pl-3">
            @if(count($delivery_items) > 0)
            <?php
                $ctr = 0;
                ?>
            @foreach($delivery_items->all() as $delivery)
            
            <div class="card mb-2">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{asset('storage/product_images/'.$delivery->image_location)}}" class="w-100 p-2 text-center">
                    </div>
                    <div class="col-md-10 p-3 row">
                        <div class="col-10">
                            <div class="card-block px-3">
                                <h4 class="card-title mb-1"><b>{{$delivery->name}}</b></h4>
                                <p class="card-text mb-0">Ordered By {{$delivery->contact_person}}</p>
                                <p class="card-text mb-0">Ordered on {{ \Carbon\Carbon::createFromTimeStamp(strtotime($delivery->added))->format('M d Y H:i A')}}</p>
                                @if($delivery->status == 0)
                                <p class="card-text mb-0">Estimated Arrival Date: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($delivery->arrival_date))->format('M d Y')}}</p>
                                <p class="card-text mb-0"><span class="text-primary">On Transit</span></p>

                                @elseif($delivery->status == 1)
                                <p class="card-text mb-0">Arrival Date: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($delivery->arrival_date))->format('M d Y H:i A')}}</p>
                                <p class="card-text mb-0"><span class="text-success">Delivered</span></p>
                                
                                @elseif($delivery->status == 2)
                                <p class="card-text mb-0"><span class="text-danger">Cancelled</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="col-2">
                            <button class="btn btn-dark" onclick="getOrder({{$delivery->order_id}})"  data-toggle="modal" data-target="#orderModal">Details</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $ctr++;

                if($ctr == 3 && count($delivery_items) > 3) {
                    break;
                }
                ?>
            @endforeach
            
            @if($ctr == 3)
            <a href="#" class="text-dark"><h4>See All</h4></a>
            @endif

            @else
                <h4 class="mt-5">You currently have no orders</h4>
            @endif
        </div>
    </div>
</div>
@include('inc.ordermodal')
@endsection
