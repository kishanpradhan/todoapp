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
		<h1>Login</h1>

		<form role="form" name="userlogin" method="post" action="user/login">
			<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
				<label for="email">email: </lable>
				<input id="email" name="email" type="text" class="form-control" placeholder="Your email">
				@if($errors->has('email'))
					{{ $errors->first('email') }}
				@endif	
			</div>
			<div class="form-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
				<label for="password">Password: </lable>
				<input id="password" name="password" type="password" class="form-control" placeholder="Your password">
				@if($errors->has('password'))
					{{ $errors->first('password') }}
				@endif	
			</div>
			<div class="checkbox">
				<label for="remember">
					<input type="checkbox" id="remember" name="remember" > Remember me
				</label>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" name="memloginbtn" value="Login" class="btn btn-default">
			</div>
		</form>
	</div>
@stop