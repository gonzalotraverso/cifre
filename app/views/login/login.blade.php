@extends("layout")

@section("content")
	{{ Form::open(array("route" => "login", "autocomplete" => "off")) }}
		{{ Form::label("email", "Email") }}
		{{ Form::text("email", Input::old("email"), array(
		             "placeholder" => "email"
		         )) }}
        {{ $errors->first("username") }}
		{{ Form::label("password", "password") }}
		{{ Form::password("password", array(
		             "placeholder" => "password"
		         )) }}
        {{ $errors->first("password") }}

		{{ Form::label("remember", "Remember Me") }}
        {{ Form::checkbox('remember', 'true') }}

        {{ Form::submit("login") }}
	{{ Form::close() }}
@stop

@section("footer")
	@parent
	<script src="//polyfill.io"></script>
@stop