<?php

class UserTaskController extends \BaseController {

	public $restful = true;

	public function getIndex($id)
	{
		$mtasks = Task::find($id);
		$stasks = Task::where('parent_id', '=', $mtasks->id)->get();
		$assign = AssignedTask::where('assign_to_id', '=', Auth::user()->id)
									->where('accepted', '=', 0)
									->where('task_id', '=', $id)->first();
		$value = "";
		if(count($assign) < 1)
		{
			$value = "No Task Request";
		}
		else
		{
			$task = Task::find($assign->task_id);
			$userby = UsersProfile::where('user_id', '=', $assign->assign_by_id)->first();
			$userto = UsersProfile::where('user_id', '=', $assign->assign_to_id)->first();

			$value = array('task_title' => $task->title,
							'assign_by_name' => $userby->first_name,
							'assign_by_id' => $userby->user_id,
							'assign_to_name' => $userto->first_name,
							'assign_to_id' => $userto->user_id );
			
		}

		//$comments = Comment::where('task_id', '=', $id)->get();//do join of comment and user table
		$comments = Task::find($id)->comments;
		$checklists = Checklist::where('task_id', '=', $id)->get();
		return View::make('task.maintask')
						->with('mtasks', $mtasks)
						->with('stasks', $stasks)
						->with('comments', $comments)
						->with('checklists', $checklists)
						->with('assign', $value);
	}

	/*public function getAssignedTask($id)
	{
		$assign = AssignedTask::where('assign_to_id', '=', Auth::user()->id)
									->where('accepted', '=', 0)
									->where('task_id', '=', $id)->first();
		if(count($assign) < 1)
		{
			return "No Task Request";
		}
		else
		{
			$task = Task::find($assign->task_id);
			$userby = UsersProfile::find($asssign->assign_by_id);
			$userto = UsersProfile::find($asssign->assign_to_id);

			$value = array('task_title' => $task->title,
							'assign_by_name' => $userby->first_name,
							'assign_by_id' => $userby->id,
							'assign_to_name' => $userto->first_name,
							'assign_to_id' => $userto->id );
			return $value;
		}
	}*/

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

	public function postComment($id)
	{
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

	

}
