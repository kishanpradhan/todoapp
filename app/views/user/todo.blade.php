@extends('layouts.master')

@section('head')
	@parent

	<title>Todo App</title>

@stop

@section('content')
	
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif(Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif


	<div class="container">
		main home page <a href="{{ URL::to('user/create-task') }}" >   Add New Task</a>
		@foreach($tasks as $task)
			<div><a href="{{ URL::to('user/task', $task->id) }}">{{ $task->title }}</a></div>
		@endforeach

		<br>Tasks Assigned To you
		@if($atasks!=0)
			@for($i=0;$i<count($atasks);$i++)
				<div><a href="{{ URL::to('user/task', $atasks[$i]['tid']) }}">{{ $atasks[$i]['ttitle'] }}</a></div>
			@endfor
		@endif
	</div>
	<div>
		For Notification <br>
	</div>
@stop