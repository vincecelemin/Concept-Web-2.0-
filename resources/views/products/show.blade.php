@extends('layouts.app')

@section('content')

<div class="container">
    @include('inc.messages')
    <div class="row">
        <div class="col-md-3 border-right border-dark p-2">
            <div id="image_carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="{{asset('storage/product_images/'.$product->pictures->first()->image_location)}}" alt="{{$product->name}}">
                  </div>

                  @foreach($product->pictures as $picture)
                    @if($picture != $product->pictures->first())
                        <div class="carousel-item">
                        <img class="d-block w-100" src="{{asset('storage/product_images/'.$picture->image_location)}}" alt="{{$product->name}}">
                        </div>
                    @endif
                  @endforeach
                </div>
                <a class="carousel-control-prev" href="#image_carousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#image_carousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
        </div>

        <div class="col-md-9">
            <h1 class="mb-1">{{$product->name}}</h1>
            <h6 class="my-0">Added {{$product->created_at}}</h6>
            <small class="text-muted">Product #{{$product->id}}</small>

            <div class="mt-2">
                {{$product->description}}
            </div>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-outline-dark" data-toggle="modal" data-target="#restockModal">Restock</button>
        <a href="{{url('/products/'.$product->id.'/edit')}}" class="btn btn-outline-dark">Edit</a>
    </div>
    <div class="mt-2">
        <h3>Product Orders</h3>
    </div>
</div>

<div class="modal fade" id="restockModal" tabindex="-1" role="dialog" aria-labelledby="restockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="restockModalLabel">Restock Product #{{$product->id}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/products/{{$product->id}}/restock" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-body">
            <h5>Current Stock: {{$product->stock}}</h5>
            <div class="form-group">
                <label for="stock-input">Input Stock</label>
                <input type="text" class="form-control" name="stock_input" value="{{$product->stock}}" id="stock-input" aria-describedby="stockHelp">
                <small id="stockHelp" class="form-text text-muted">Enter a valid numerical value</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
        </form>
        </div>
    </div>
</div>
@endsection