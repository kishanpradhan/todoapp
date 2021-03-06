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

	<script>
	/*$(document).ready(function(){
	    $('#membername').keyup(function() {
            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                data: $('form#ajaxform').serialize(),
                beforeSend: function() { 
                    $("#validation-errors").hide().empty(); 
                },
                success: function(data) {
                    if(data.success == false)
                    {
                        var arr = data.errors;
                        $.each(arr, function(index, value)
                        {
                            if (value.length != 0)
                            {
                                $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
                            }
                        });
                        $("#validation-errors").show();
                    } else {
                         location.reload();
                    }
                },
                error: function(xhr, textStatus, thrownError) {
                    alert('Something went to wrong.Please Try again later...');
                }
            });
            return false;
            var value = $('#membername').val();
			var poststr="mname="+value;
			$.ajax({
				type: 'post',
				url: "assign-member",
				cache:0,
				data:poststr,
				success:function(result){
   					alert("okkkk");
					}
				error: function(xhr, textStatus, thrownError) {
                    alert('Something went to wrong.Please Try again later...');
                }
   			});
   			//alert('klkl');
    	});
	});*/
	$(document).ready(function(){
		$('#addcheck').click(function(){
			$('#checklistui').toggle();
		});
	});
	</script>

@stop

@section('content')
	
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif(Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif


	<div class="left">
		
		<span><h4>{{ $mtasks->title }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4></span>
		<span>
			<form method="post" action="{{ URL::route('delete-task', $mtasks->id) }}">
				<input type="hidden" name="mtaskid" id="mtaskid" value="{{ $mtasks->id }}">
				{{ Form::token() }}
				<button type="submit">Delete {{ $mtasks->title }}</button>
			</form>
		</span>
		<div>
			<h3>Subtasks</h3>
			@foreach($stasks as $stask)
				<div id="{{ $stask->id }}">
					<span>{{ $stask->title }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					@if($stask->completed == 0)
					<span id="finish{{$stask->id}}"><button class="btn-primary finish-subtask" >finished??&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></span>
					@else
					<span>Finished</span>
					@endif
					<span>	
						<form method="post" action="{{ URL::route('delete-sub-task', $mtasks->id) }}">
							<input type="hidden" name="staskid" value="{{ $stask->id }}">
							{{ Form::token() }}
							<button type="submit">Delete {{ $stask->title }}</button>
						</form>
					</span>
					<div>{{ $stask->task_desc }}</div>
					<hr>
				</div>
			@endforeach
			<div><a href="{{ URL::route('add-sub-task', $mtasks->id) }}">Add new subtask</a></div>
		</div>
		<div>
			<h3>Checklists</h3>
			<ul>
				@foreach($checklists as $checklist)
				<li><a href="#">{{ $checklist->title }}</a><a href="{{ URL::route('checklist', array($mtasks->id, $checklist->id)) }}">Edit checklist</a>
				<ul><?php $checkdata = json_decode($checklist->list_data, true); ?>
					@for($i=0;$i<count($checkdata);$i++)
						<li><input type="checkbox" id="{{ $checklist->id }}sub{{ $checkdata[$i]['id'] }}" name="{{ $checkdata[$i]['value'] }}">{{ $checkdata[$i]['value'] }}
						</li>
					@endfor
				</ul>
				<form method="post" action="{{ URL::route('checklist-data', $mtasks->id) }}">
					<input type="text" name="subchecktitle" id="subchecktitle" class="form-control">
					@if($errors->has('subchecktitle'))
						{{ $errors->first('subchecktitle') }}
					@endif
					<input type="hidden" name="cid" id="cid" value="{{ $checklist->id }}" class="form-control">
					<button type="submit">Add</button> 
				</form>
				</li>
				@endforeach
			</ul>
			<a href="javascript:void(0)" id="addcheck">Add Checklist</a>
			@if($errors->has('checktitle'))
				{{ $errors->first('checktitle') }}
			@endif
			<div id="checklistui" style="display:none;">
				<form id="addchecklist" method="post" action="{{URL::route('checklist-title', $mtasks->id)}}">
					<input type="text" id="checktitle" name="checktitle" class="form-control">

					<button type="submit">Add checklist</button>
 				</form>
			</div>
		</div>
		<div>
			<h3>Comments</h3>
			@for($i=0;$i<count($comments);$i++)
				<div><span>{{ $comments[$i]['username'] }} : {{$comments[$i]['comment']}}</span>

					<span>
						<form method="post" action="{{ URL::route('comment-delete', $mtasks->id) }}">
							<input type="hidden" name="cmtid" value="{{ $comments[$i]['cmtid'] }}" >
							<button type="submit">Delete</button>
						</form>
					</span>
				</div>
			@endfor
			<div>
				<form method="post" action="{{ URL::route('comment', $mtasks->id) }}">
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
			<h3>Add member to this task</h3>
			<form id="assignform" method="post" action="{{ URL::route('assign-member', $mtasks->id) }}">
				<div class="form-group">
					<input type="text" class="form-control" name="memberemail" id="memberemail" placeholder="Enter Member email">
				</div>
				{{ Form::token() }}
				<div>
					<button type="submit" >Add Member</button>
				</div>
			</form>
			<br>
			
			@if($assign != '')
				<h4>Member associated</h4>
				@for($i=0;$i<count($assign);$i++)
					<div>{{ $assign[$i]['username'] }} : {{$assign[$i]['email']}}</div>
					<div>
						<form method="post" action="{{ URL::route('member-delete', $mtasks->id) }}">
							<input type="hidden" name="assid" value="{{ $assign[$i]['id'] }}">
							<button type="submit">Delete Memeber</button>
						</form>
					</div>
				@endfor
			@else
				<div>No associated member</div>
			@endif
		</div>
		<br>
		<div>
			<h3>File Upload</h3>
			@for($i=0;$i<count($files);$i++)
			<div id="file{{$files[$i]['id']}}"
				<span>{{ $files[$i]['username'] }} : <a href="{{$files[$i]['file']}}">File</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span myattr="{{ $mtasks->id }}"><a href="javascript:void(0)" id="{{$files[$i]['id']}}" class="filedelete">Delete</a></span><hr></br>
			@endfor
			</div>
			<div>
				<form method="post" action="{{ URL::route('upload-file', $mtasks->id) }}" enctype="multipart/form-data">
					<label for="file">File Uploaded</label>
					<input type="file" name="file" id="file" >
					<button type="submit">Upload</button>
					@if($errors->has('file'))
						{{ $errors->first('file') }}
					@endif
				</form>
			</div>
		</div>
		
	</div>
@stop