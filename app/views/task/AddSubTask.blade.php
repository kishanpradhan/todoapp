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


	<div id="generate_task_box" class="active allbox">
		<h2>Add Sub Task</h2>
		<div id="generate_task_box1" style="padding:0px 10px 10px 10px;">
        	<form role="form" class="form_box" id="taskgenform" action="add-sub-task" method="post" >
               <div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
	               <label>Sub Task Title</label>
	               <input type="text" class="form-control" name="title" id="tname" placeholder="Enter Task Title" required>
	               <div id="tnstatus"></div>
	               @if($errors->has('title'))
					{{ $errors->first('title') }}
					@endif
               </div>
               <div>
               		<input type="hidden" name="taskid" value="{{ $tid }}">
               </div>
               <div class="form-group{{ ($errors->has('taskdesc')) ? ' has-error' : '' }}">
	               <label>Sub Task Description</label>
	               <textarea name="taskdesc" id="taskdesc" class="form-control" placeholder="Enter Task Description"></textarea>
	               @if($errors->has('taskdesc'))
					{{ $errors->first('taskdesc') }}
					@endif
               </div>
               {{ Form::token() }}
               <div class="form-group">
	               <input type="submit" class="form-control btn-primary" onclick="generateTask()" name="gtsubmit" value="Generate Task" >
	           </div>
			</form>
			<div id="gtstatus"></div>   
        </div>
	</div>
@stop