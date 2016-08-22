
@extends('index')

@section('title', '登入')

@section('content')
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
    {{ Form::open(['url'=>'login', 'method'=>'post']) }}
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email') }}
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}
        {{ Form::submit('Login') }}
    {{ Form::close() }}
@endsection