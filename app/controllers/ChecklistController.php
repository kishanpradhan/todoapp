<?php

class ChecklistController extends BaseController {

	public function postChecklistTitle($id)
	{
		$validate = Validator::make(Input::all(), array(
			'checktitle' => 'required',
		));

		$ctitle = Input::get('checktitle');

		if($validate->fails())
		{
			return Redirect::to('user/task/'.$id.'')->withErrors($validate)->withInput();
		}
		else
		{
			
			$check = new Checklist();

			$check->task_id = $id;
			$check->title = $ctitle;
			$check->user_id = Auth::user()->id;
			//$check->list_data = "";

			if($check->save())
			{
				return Redirect::to('user/task/'.$id.'');
			}
			else
			{
				return Redirect::to('user/task/'.$id.'')->with('fail', 'Comment failed.');
			}
		}
	}

	public function postChecklistData($id)
	{
		$validate = Validator::make(Input::all(), array(
			'subchecktitle' => 'required',
		));

		if($validate->fails())
		{
			return Redirect::to('user/task/'.$id.'')->withErrors($validate)->withInput();
		}
		else
		{

			$subtitle = Input::get('subchecktitle');
			$cid = Input::get('cid');

			$check = Checklist::find($cid);
			$cdata = $check->list_data;
			if($cdata == "")
			{
				$arr = array(array('id' => 1, 'value' => $subtitle));
				$idata = json_encode($arr);
				$check->list_data = $idata;

				if($check->save())
				{
					return Redirect::to('user/task/'.$id.'');
				}
				else
				{
					return Redirect::to('user/task/'.$id.'')->with('fail', 'Adding failed.');
				}
			}
			else
			{
				$cdata1 = json_decode($cdata,true);
				$i = count($cdata1)+1;
				array_push($cdata1,['id' => $i, 'value' => $subtitle]);
				$idata = json_encode($cdata1);
				$check->list_data = $idata;

				if($check->save())
				{
					return Redirect::to('user/task/'.$id.'');
				}
				else
				{
					return Redirect::to('user/task/'.$id.'')->with('fail', 'Adding failed.');
				}
			}
		}
	}

	public function getChecklist($id,$cid)
	{
		$check = Checklist::find($cid);
		return View::make('task.EditChecklist')->with('checks', $check)->with('tid', $id);
	}

	public function postSubCheckDelete($id)
	{
		$subid = Input::get('subid');
		$checkid = Input::get('checkid');

		
	}

}