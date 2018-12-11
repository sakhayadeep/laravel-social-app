@if(count($errors)>0)

    @foreach ($errors->all() as $error)
        <div class='alert alert-danger'>
        <strong>{{$error}}</strong>
        </div>
    @endforeach

@endif

@if(session('success'))

        <div class='alert alert-success'>
            {{session('success')}}
        </div>
@endif

@if(session('error'))

        <div class='alert alert-danger'>
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{session('error')}}
        </div>
@endif