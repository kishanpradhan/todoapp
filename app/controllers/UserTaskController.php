<?php

class UserTaskController extends \BaseController {

	public $restful = true;

	public function getIndex($id)
	{
		$mtasks = Task::find($id);
		$stasks = Task::where('parent_id', '=', $mtasks->id)->get();
		return View::make('task.maintask')->with('mtasks', $mtasks)->with('stasks', $stasks);
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


}
