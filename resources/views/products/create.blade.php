@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Add a new product</h2>

        <form action="/products" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="col-6 pr-3" style="border-right: 1px solid rgba(200,200,200,.15);">
                <div class="form-group">
                    <label for="product_name" class="col-form-label pb-0">{{ __('Product Name') }}</label>
    
                    <div>
                        <input id="product_name" type="text" class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }}" name="product_name" value="{{ old('product_name') }}" required autofocus>
    
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
                            {{ trim(old('product_description')) }}
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

                        <input id="product_price" type="text" class="form-control{{ $errors->has('product_price') ? ' is-invalid' : '' }}" name="product_price" value="{{ old('product_price') }}"  placeholder="0.00" aria-describedby="basic-addon1" required>
    
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
                        <input id="product_stock" type="text" class="form-control{{ $errors->has('product_stock') ? ' is-invalid' : '' }}" name="product_stock" value="{{ old('product_stock') }}" required autofocus>
    
                        @if ($errors->has('product_stock'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_stock') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group">
                    <label for="product_logo" class="col-form-label py-0">{{ __('Product Icon') }}</label>
    
                    <div>
                        <input id="product_logo" type="file" class="form-control{{ $errors->has('product_logo') ? ' is-invalid' : '' }}" name="product_logo" required autofocus>
    
                        @if ($errors->has('product_logo'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('product_logo') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group control-group">
                    <label for="additional_pics" class="col-form-label py-0">{{ __('Additional Pictures') }}</label>
                    
                    <div class="input-group control-group increment">
                        <input type="file" name="additional_p[]" class="form-control{{ $errors->has('additional_p[]') ? ' is-invalid' : '' }}">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" id="add-new-field" type="button"><i class="fas fa-plus"></i> Add</button>
                        </div>
    
                        @if ($errors->has('additional_p[]'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('additional_p[]') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="clone hide">
                        <div class="input-group control-group mt-2">
                            <input type="file" name="additional_p[]" class="form-control{{ $errors->has('additional_p[]') ? ' is-invalid' : '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger additional" id="remove-field" type="button"><i class="fas fa-minus"></i> Remove</button>
                            </div>
        
                            @if ($errors->has('additional_p[]'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('additional_p[]') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
      

                <div class="text-right">
                    <button class="btn btn-dark" type="submit">Add Product</button>
                </div>
            </div>
        </form>
    </div>

    
    <script type="text/javascript">
        $(document).ready(function () {

            $(".btn-outline-secondary").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".additional", function () {
                $(this).closest(".control-group").remove();
            });

        });

    </script>
@endsection