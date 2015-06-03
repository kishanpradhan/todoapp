@extends('layouts.master')

@section('head')
	@parent

	<title>Task Page</title>
	<style type="text/css">

	.left{
		float: left;
		margin-left: 90px;
	}
	.right{
		float: right;
		margin-right: 90px;
	}
	</style>

@stop

@section('content')
	
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif(Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif


	<div class="left">
		
		<span>{{ $mtasks->title }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span><a href="">Delete Task</a></span>
		<div>
			@foreach($stasks as $stask)
				<div>
					<span>{{ $stask->title }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<span>finished??&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<span>
						<a href="{{ URL::route('delete-sub-task', $mtasks->id) }}">Delete</a>
						<form method="post" action="{{ URL::route('delete-sub-task', $mtasks->id) }}">
							<input type="hidden" name="staskid" value="{{ $stask->id }}">
							<button type="submit">Delete {{ $stask->title }}</button>
						</form>
					</span><br>
					<div>{{ $stask->task_desc }}</div><br>
				</div>
			@endforeach
			<div><a href="{{ URL::route('add-sub-task', $mtasks->id) }}">Add new subtask</a></div>
		</div>
		<div>
			<ul>
				<li>Checklist 1</li>
				<ul>
					<li>subChecklist 2</li>
					<li>subChecklist 3</li>
				</ul>
			</ul>
			<a href="">Add Checklist</a>
		</div>
		<div>
			<div>Showing comment</div>
			<div>
				<form method="post" action="">
					<div class="form-group{{ ($errors->has('comment')) ? ' has-error' : '' }}">
						<label for="comment">comment: </lable>
						<input id="comment" name="comment" type="text" class="form-control" placeholder="Your comment">
						@if($errors->has('comment'))
							{{ $errors->first('comment') }}
						@endif	
					</div>
					{{ Form::token() }}
					<div class="form-group">
						<input type="submit" name="cmtbtn" value="Comment" class="btn btn-default">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="right">
		<div>
			<a href="">Add Friend</a>
			<span>Friend 1</span>
			<span>Friend 2</span>
			<span>Friend 3</span>
		</div>
		<div>
			<div>File 1</div>
			<div>File 2</div>
			<div>File 3</div>
		</div>
	</div>
@stop