<?php

class UserTaskController extends \BaseController {

	public $restful = true;

	public function getIndex($id)
	{
// 		$client = new GuzzleHttp\Client();
// $res = $client->get('https://www.facebook.com/', []);
// echo $res->getStatusCode();
// // "200"
// echo $res->getHeader('content-type');
// // 'application/json; charset=utf8'
// echo $res->getBody();
// // {"type":"User"...'

// // Send an asynchronous request.


// 		dd("dlkfnl");


		$mtasks = Task::find($id);
		if(count($mtasks) == 0){
			return Redirect::to('user')->with("fail", 'Task Not Found.');
		}
		$assigncheck = AssignedTask::where('task_id', '=', $id)->where('assign_to_id', '=', Auth::user()->id)->first();
		if(Auth::user()->id != $mtasks->creator_id && Auth::user()->id != $assigncheck['assign_to_id'])
		{
			return Redirect::to('user')->with("fail", 'Task Not Found.');
		}
		$stasks = Task::where('parent_id', '=', $mtasks->id)->get();
		$assign = AssignedTask::where('task_id', '=', $id)->get();

		$value = array();
		if(count($assign) < 1)
		{
			$value = "";
			
		}
		else
		{
			foreach ($assign as $key => $ass) {
				$user = UsersProfile::where('user_id', '=', $ass->assign_to_id)->first();
				//return $ass->assign_to_id;
				$user1 = User::find($ass->assign_to_id);
				array_push($value,['id' => $ass['id'],'username' => $user['first_name'], 'email' => $user1['email']]);
			}
		}

		//$comments = Comment::where('task_id', '=', $id)->get();//do join of comment and user table
		$comments = Task::find($id)->comments;
		$returncomment = array();
		foreach ($comments as $key => $comment) {
			$user = UsersProfile::where('user_id', '=', $comment->user_id)->first();
			array_push($returncomment,['username' => $user->first_name, 'comment' => $comment->comment, 'cmtid' => $comment->id]);
		}

		$files = FileUpload::where('task_id', '=', $id)->get();
		$returnfile = array();
		foreach ($files as $key => $file) {
			$user = UsersProfile::where('user_id', '=', $file->user_id)->first();
			array_push($returnfile,['id' => $file->id,'username' => $user->first_name, 'file' => $file->taskurl]);
		}
		
		$checklists = Checklist::where('task_id', '=', $id)->get();
		return View::make('task.maintask')
						->with('mtasks', $mtasks)
						->with('stasks', $stasks)
						->with('comments', $returncomment)
						->with('checklists', $checklists)
						->with('files', $returnfile)
						->with('assign', $value);
	}


	public function getAddSubTask($id)
	{
		return View::make('task.AddSubTask')->with('tid', $id);
	}

	public function postAddSubTask()
	{
		$validate = Validator::make(Input::all(), array(
			'title' => 'required|min:2',
			'taskdesc' => 'required'
		));

		$tid = Input::get('taskid');

		if($validate->fails())
		{
			return Redirect::to('user/task/'.$tid.'/addsubtask')->withErrors($validate)->withInput();
		}
		else
		{
			$task = new Task();
			$task->title = Input::get('title');
			$task->task_desc = Input::get('taskdesc');
			$task->creator_id = Auth::user()->id;
			$task->parent_id = $tid;


			if ($task->save())
			{
				
				return Redirect::to('user/task/'.$tid.'')->with('success', 'Your subtask created successfully.');
				
			}
			else
			{
				return Redirect::to('user/task/'.$tid.'/addsubtask')->with('fail', 'Your subtask is not created due to some error.');
			}
		}
	}

	public function getDeleteSubTask()
	{
		return "delete get sub task";
	}

	public function postDeleteSubTask($id)
	{
		$stid = Input::get('staskid');
		
		$dtask = Task::find($stid);
		if($dtask->parent_id == $id)
		{
			$dtask->delete();
			return Redirect::to('user/task/'.$id.'')->with('success', 'Subtask deleted.');
		}
		else
		{
			return Redirect::to('user/task/'.$id.'')->with('fail', 'Subtask cannot be deleted.');
		}
	}

	public function getDeleteTask()
	{
		return "get delete task";
	}

	public function postDeleteTask($id)
	{
		$tid = Input::get('mtaskid');
		if($tid == $id)
		{
			$dtask = Task::find($tid);
			$dtask->delete();
			return Redirect::to('user')->with('success', 'Task Deleted.');
		}
		else
		{
			return Redirect::to('user')->with('fail', 'Delete Failed.');
		}
	}

	public function postAssignMember($id)
	{
		$memail = Input::get('memberemail');
		$check = User::where('email', '=', $memail)->first();
		if(count($check) < 1)
		{
			return Redirect::to('user/task/'.$id.'')->with('fail', 'You have entered wrong email.');
		}
		else
		{
			$asscheck = AssignedTask::where('assign_by_id', '=', $check->id)->orWhere('assign_to_id', '=', $check->id)->get();
			if(count($asscheck) > 0)
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'Member has already been assigned.');
			}
			$assign = new AssignedTask();
			$assign->task_id =  $id;
			$assign->assign_by_id = Auth::user()->id;
			$assign->assign_to_id = $check->id;

			if($assign->save())
			{
				return Redirect::to('user/task/'.$id.'')->with('success', 'Member assigned.');
			}
			else
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'Member assignment failed.');
			}
		}
	}

	public function postDeleteMember($id)
	{
		$assid = Input::get('assid');
		$did = AssignedTask::find($assid);
		if($did->task_id == $id && ($did->assign_by_id == Auth::user()->id || $did->assign_to_id == Auth::user()->id))
		{
			if($did->delete())
			{
				return Redirect::to('user/task/'.$id.'')->with('success', 'Member deleted.');
			}
			else
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'Member deletion failed.');
			}
		}
	}

	public function postComment($id)
	{
		$validate = Validator::make(Input::all(), array(
			'comment' => 'required',
		));

		if($validate->fails())
		{
			return Redirect::to('user/task/'.$id.'')->withErrors($validate)->withInput();
		}

		$cmt = Input::get('comment');

		$cmtobj = new Comment();

		$cmtobj->task_id = $id;
		$cmtobj->user_id = Auth::user()->id;
		$cmtobj->comment = $cmt;

		if($cmtobj->save())
		{
			return Redirect::to('user/task/'.$id.'');
		}
		else
		{
			return Redirect::to('user/task/'.$id.'')->with('fail', 'Comment failed.');
		}
	}

	

	public function postDeleteComment($id)
	{
		$cmtid = Input::get('cmtid');
		//$comment = Comment::where('task_id', '=', $id)->find($cmtid);
		$comment = Comment::find($cmtid);
		if(count($comment) < 1)
		{
			return "not found ";
		}
		else
		{
			$task = Task::find($comment->task_id);
			$user = User::find($comment->user_id);
			if (($user->id == Auth::user()->id) || ($task->creator_id == Auth::user()->id)) {
				if($comment->delete())
				{
					return Redirect::to('user/task/'.$id.'')->with('success', 'Comment deleted');	
				}
				else
				{
					return Redirect::to('user/task/'.$id.'')->with('fail', 'Comment cannot be deleted.');
				}
			}
			else
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'You are not the owner of the comment');
			}
		}
	}
	

}
