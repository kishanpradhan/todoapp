<?php

class FileController extends BaseController{

	public function postFile($id)
	{
		$input = Input::all();
		$validate = Validator::make(Input::all(), array(
			'file' => 'required',
		));

		if($validate->fails())
		{
			return Redirect::to('user/task/'.$id.'')->withErrors($validate);
		}

		$file = Input::file('file');
		$extension = Input::file('file')->getClientOriginalExtension();
		$destinationPath = 'public/uploads';
		$filename = sha1(Auth::user()->id.time()).".$extension";
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		if( $upload_success ) {
		  	$file = new FileUpload();

			$file->taskurl = URL::to($destinationPath.'/'.$filename);
			$file->task_id = $id;
			$file->user_id = Auth::user()->id;

			if($file->save())
			{
				return Redirect::to('user/task/'.$id.'')->with('success', 'File uploaded successfully');
			}
			else
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'File upload failed.');
			}
		} 
		else {
		   return "not okkk";
		}
	}

	public function postFileDelete()
	{
		$tid = Input::get('tid');
		$fid = Input::get('id');

		$file = FileUpload::where('id', '=', $fid)->where('task_id', '=', $tid)->first();
		$logid = Auth::user()->id;
		$task = Task::find($tid);
		if($task->creator_id == $logid || $file->user_id == $logid)
		{
			if($file->delete())
			{
				return "success";
			}
			else
			{
				return "Ye na ho saka";
			}
		}
		else
		{
			return "File does not belong to you.";
		}
	}

	public function getFile()
	{
		return "download file";
	}

}