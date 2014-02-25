@extends('admin.index')

@section('adminContent')
	<div class="ga-message-container">
	@if(Session::has('message'))
		{{ Session::get('message') }}
	@endif
	</div>
	{{ Form::open(array('url' => 'users/'.$user->id, 'method' => 'PUT', 'files' => true)) }}

		{{ Form::text('username', Input::old('username')? Input::old('username') : $user->username, array('placeholder' => 'Username')) }}
	    {{ $errors->first("username") }}

		{{ Form::email('email', Input::old('email')? Input::old('email') : $user->email, array('placeholder' => 'Email')) }}
	    {{ $errors->first("email") }}

	    {{ Form::select('role', array('default'=>'Select Role') + $roles, Input::old('role')? Input::old('role') : $role[0]->id) }}
	    {{ $errors->first("role") }}

	    @if ($user->image == NULL)
	    {{ Form::file('image') }}
	    @else
		<div class="ga-img-edit-cont">
			<img src="{{ Croppa::url('/cookbook/public/uploads/'.$user->email.'/'.$user->image, 100) }}" />
			<input name="image" type="file">
			<button class="ga-img-edit-change">Change Image</button>
			<button class="ga-img-edit-cancel">Cancel</button>
		</div>
	    @endif

		<div class="ga-new-pass-container">
		{{ Form::password("password", array(
		             "placeholder" => "Password",
		             'class' => 'ga-new-pass'
		         )) }}
		
		
		{{ Form::password("new_password", array(
		             "placeholder" => "New Password",
		             'class' => 'ga-new-pass'
		         )) }}
		    <a href="" class="ga-close-pass-cont">Close</a>
		</div>
			    {{ $errors->first("password") }}
			    {{ $errors->first("new_password") }}

		

		{{ Form::submit('Save') }}
	{{ Form::close() }}
	<a href="" class="ga-edit-pass">Edit password</a>
@stop