@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-secondary" role="alert">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-secondary" role="alert">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-secondary" role="alert">
        {{session('error')}}
    </div>
@endif