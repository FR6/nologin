@extends('nologin::layout')

@section('body')
	<h1>Hey hi!</h1>
	<p>It seems that you are a new user so please enter your email once again, just to be sure:</p>

	{{ Form::open(array('url' => URL::to('nologin/confirm'))) }}

	{{ Form::hidden('redirect', $redirect) }}

	{{ Form::label('email1', 'Email:') }}
	{{ Form::text('email1', $email1) }}
	<br />
	{{ Form::label('email2', 'Again:') }}
	{{ Form::text('email2') }}
	<br />
	{{ Form::submit('Submit') }}
	{{ Form::close() }}

@stop