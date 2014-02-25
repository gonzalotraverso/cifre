@extends('layout')

@section('content')
	{{ Form::open(array("route" => "reminder", "autocomplete" => "off")) }}
		{{ Form::label("email", "Email") }}
		{{ Form::text("username", Input::get("email"), array(
		             "placeholder" => "email"
		         )) }}
        {{ $errors->first("email") }}
		
        {{ Form::submit("Send Reminder") }}
	{{ Form::close() }}
@stop