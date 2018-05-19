@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Register as a New Store') }}
                    @foreach($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="store_name" class="col-md-4 col-form-label text-md-right">{{ __('Store Name') }}</label>

                            <div class="col-md-6">
                                <input id="store_name" type="text" class="form-control{{ $errors->has('store_name') ? ' is-invalid' : '' }}" name="store_name" value="{{ old('store_name') }}" required autofocus>

                                @if ($errors->has('store_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_description" class="col-md-4 col-form-label text-md-right">{{ __('Store Description') }}</label>

                            <div class="col-md-6">
                                <textarea name="store_description" id="store_description" cols="30" rows="3" class="form-control{{ $errors->has('store_description') ? ' is-invalid' : '' }}"  required autofocus>{{ old('store_description') }}</textarea>

                                @if ($errors->has('store_description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_location" class="col-md-4 col-form-label text-md-right">{{ __('Store Location') }}</label>

                            <div class="col-md-6">
                                <input id="store_location" type="text" class="form-control{{ $errors->has('store_location') ? ' is-invalid' : '' }}" name="store_location" value="{{ old('store_location') }}" required autofocus>

                                @if ($errors->has('store_location'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('store_location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-right">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-dark">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="text-center p-4" id="drop-logo">                    
    <img src="{{asset('images/logo.png')}}" alt="Concept">
</div>
@endsection
