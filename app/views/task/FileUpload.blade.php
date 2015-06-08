@extends('layouts.master')

@section('head')
	@parent

	<title>File Upload</title>

@stop

@section('content')
	
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif(Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif


	<div class="container">
		
	</div>
@stop