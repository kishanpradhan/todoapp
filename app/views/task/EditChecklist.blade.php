@extends('layouts.master')

@section('head')
	@parent

	<title>Edit Checklist</title>

@stop

@section('content')
	
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif(Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif


	<div id="generate_task_box" class="active allbox">
		<h2>Edit {{ $checks->title }}</h2>
		<form method="post" action="">
			<button type="submit">Delete</button>
		</form>

		<?php $checkdata = json_decode($checks->list_data, true); ?>
		@for($i=0;$i<count($checkdata);$i++)
			<li>
			<form method="post" action="{{ URL::route('subcheck-delete', $tid) }}">
				<input type="hidden" name="subid" value="{{ $checkdata[$i]['id'] }}" >
				<input type="hidden" name="checkid" value="{{ $checks->id }}" >
				<input type="checkbox" name="subcheck{{ $checkdata[$i]['id'] }}">{{ $checkdata[$i]['value'] }}
				<button type="submit">Delete</button>
			</form>
			</li>
		@endfor
	</div>
@stop