@extends('admin.index')

@section('adminContent')
	{{ $user->username }}
	{{ $user->email }}
	{{ $role['0']->name }}
	@if ($user->image != NULL)
	<img src="{{ Croppa::url('/cookbook/public/uploads/'.$user->email.'/'.$user->image, 100) }}" />
	@endif
	<a href="{{ URL::to('users/'.$user->id.'/edit') }}">Edit</a>
	@if (Auth::user()->id != $user->id)
	<a href="" class="delete-action" data-resource='users' data-name='{{ $user->username }}' data-url="{{ URL::to('users/'.$user->id) }}">Delete</a>
	@endif
@stop