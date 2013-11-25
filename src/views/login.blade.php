@extends('nologin::layout')

@section('body')

	<h1>Login</h1>

	{{ Form::open(array('url' => URL::current())) }}

	{{ Form::hidden('redirect', $redirect) }}

	{{ Form::label('email1', 'Enter your email:') }}
	{{ Form::text('email1') }}

	{{ Form::submit('Submit') }}
	{{ Form::close() }}
	
@stop
