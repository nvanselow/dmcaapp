@if($errors->any())
    @foreach ($errors->all() as $error)
        <ul class="alert alert-danger">
            <li>{{$error}}</li>
        </ul>
    @endforeach
@endif