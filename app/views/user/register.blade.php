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


	<div id="member_signup_box" class="deactive">
		<h2>User Registration</h2>
		<div id="form1" style="padding:0px 10px 10px 10px;">
	    	<form role="form" class="form_box" method="post" name="signupform" id="signupform" action="create">
	           	<div class="form-group{{ ($errors->has('firstname')) ? ' has-error' : '' }}">
				 <label id="label6">First Name</label>
	             <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Your firstname">
	             @if($errors->has('firstname'))
					{{ $errors->first('firstname') }}
				@endif
	            </div>
	            <div class="form-group{{ ($errors->has('lastname')) ? ' has-error' : '' }}">
	             <label id="label7">Last Name</label>
	             <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Your lastname" >
	             @if($errors->has('lastname'))
					{{ $errors->first('lastname') }}
				@endif
	            </div>
             	<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
	             <label id="label3">Email</label>
	             <input type="email" class="form-control" id="email" name="email" onblur="checkemail()" placeholder="Email">
	             @if($errors->has('email'))
					{{ $errors->first('email') }}
				@endif
	             <span id="emailstatus"></span>
	            </div>
	            <div class="form-group{{ ($errors->has('pass1')) ? ' has-error' : '' }}">
	             <label id="label4">Password</label>
	             <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Password">
	             @if($errors->has('pass1'))
					{{ $errors->first('pass1') }}
				@endif
	            </div>
	            <div class="form-group{{ ($errors->has('pass2')) ? ' has-error' : '' }}">
	             <label id="label5">Re-Type Password</label>
				 <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Re-type Password">
				 @if($errors->has('pass2'))
					{{ $errors->first('pass2') }}
				@endif
				</div>
				
	            <div class="form-group{{ ($errors->has('country')) ? ' has-error' : '' }}">
	             <label id="label8">Country</label>
	             <input type="text" class="form-control" id="country" name="country" placeholder="Your Country">
	             @if($errors->has('country'))
					{{ $errors->first('country') }}
				@endif
	            </div>
	            <div class="form-group">
	             <input type="submit" id="signbtn" name="signbtn" value="Create Account" class="btn btn-primary btn-lg btn-block"></input>
	       		</div>
			</form> 
	        <div id="status" style="color:red;"></div>   
	        </div>
		</div>
	</div>
@stop