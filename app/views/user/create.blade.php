@extends('admin.index')

@section('adminContent')
	{{ Form::open(array('url' => 'users', 'files' => true)) }}

		{{ Form::text('username', Input::old('username'), array('placeholder' => 'Username')) }}
	    {{ $errors->first("username") }}

		{{ Form::email('email', Input::old('email'), array('placeholder' => 'Email')) }}
	    {{ $errors->first("email") }}

	    
	    {{ Form::select('role', array('default'=>'Select Role') + $roles) }}
	    {{ $errors->first("role") }}

	    {{ Form::file('image') }}
	    {{ $errors->first("image") }}

		{{ Form::password("password", array(
		             "placeholder" => "Password"
		         )) }}
	    {{ $errors->first("password") }}

		{{ Form::password("password_confirmation", array(
		             "placeholder" => "Confirm Password"
		         )) }}
	    {{ $errors->first("password_confirmation") }}

		{{ Form::submit('Create') }}
	{{ Form::close() }}
	
@stop