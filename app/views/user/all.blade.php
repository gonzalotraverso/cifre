@extends('admin.index')

@section('adminContent')
	<div class="ga-message-container">
	@if(Session::has('message'))
		{{ Session::get('message') }}
	@endif
	</div>
	<h2>Users</h2>
	@if ($users != null)
	<table id="">
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Actions</th>
		</tr>
		@foreach ($users as $u)
		<tr>
			<td>
				<a href="{{ URL::to('users/'.$u->id) }}">
					{{ $u->username }}
				</a>
			</td>
			<td>
				<a href="{{ URL::to('users/'.$u->id) }}">
					{{ $u->email }}
				</a>
			</td>
			<td>
				<a href="{{ URL::to('users/'.$u->id.'/edit') }}">Edit</a>
				@if (Auth::user()->id != $u->id)
				<a href="" class="delete-action" data-resource='users' data-name='{{ $u->username }}' data-url="{{ URL::to('users/'.$u->id) }}">Delete</a>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
	{{ $users->links() }}
	@else
		No records.
	@endif

@stop