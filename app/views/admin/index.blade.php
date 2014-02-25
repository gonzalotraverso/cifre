@extends('layout')

@section('head')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/admin-utils.css') }}">
@stop

@section('header')
	<h2>Hello <a href="{{ URL::to('users/'.Auth::user()->id) }}">{{ Auth::user()->username }}</a></h2>
	<a href="{{ URL::route('logout') }}">Log out</a>
	@if (Auth::user()->hasRole('Administrator'))
	<a href="{{ URL::to('users') }}">Users</a>
	<a href="{{ URL::to('users/create') }}">Create User</a>
	@endif
@stop

@section('content')
	@yield('adminContent')
@stop

@section('scripts')
	@parent
 	<script type="text/javascript" src="{{ URL::asset('js/admin.js') }}"></script>
@stop