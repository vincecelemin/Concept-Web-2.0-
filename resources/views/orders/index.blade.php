@extends('layouts.app')

@section('content')
        <h1 class="container">Orders</h1>
        <div class="container mb-4" id="orders-page-container">
        @if(count($orders) == 0)
            <h4 class="mt-5">You currently have no orders</h4>

        @else
            @foreach($orders->all() as $order)
            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('storage/product_images/'.$order->image_location)}}" class="w-100 p-2 text-center">
                    </div>
                    <div class="col-md-8 p-2">
                        <div>
                            <div class="card-block px-3">
                                <h4 class="card-title mb-1"><b>{{$order->name}}</b></h4>
                                <p class="card-text mb-0">Ordered By {{$order->contact_person}}</p>
                                <p class="card-text mb-0">Ordered on {{ \Carbon\Carbon::createFromTimeStamp(strtotime($order->added))->format('M d Y H:i A')}}</p>
                                @if($order->status == 0)
                                <p class="card-text mb-0">Estimated Arrival Date: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($order->arrival_date))->format('M d Y')}}</p>
                                <p class="card-text mb-0"><span class="text-primary">On Transit</span></p>

                                @elseif($order->status == 1)
                                <p class="card-text mb-0">Arrival Date: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($order->arrival_date))->format('M d Y H:i A')}}</p>
                                <p class="card-text mb-0"><span class="text-success">Delivered</span></p>
                                
                                @elseif($order->status == 2)
                                <p class="card-text mb-0"><span class="text-danger">Cancelled</span></p>
                                @endif
                            </div>
                            

                            <div class="px-3 py-1 text-right">
                                <button class="btn btn-dark" onclick="getOrder({{$order->order_id}})"  data-toggle="modal" data-target="#orderModal">Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    @include('inc.ordermodal')
@endsection