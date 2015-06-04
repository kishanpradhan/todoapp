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

		$check = Checklist::find($checkid);
		$data = json_decode($check->list_data,true);
		$flag = 0;
		for($i=0;$i<count($data);$i++)
		{
			if($subid == $data[$i]['id'])
			{
				unset($data[$i]);
				$idata = json_encode($data);
				$check->list_data = $idata;
				$flag=1;
				if($check->save())
				{
					return Redirect::route('checklist', array($id, $checkid))->with('success', 'Deleted');
				}
				else
				{
					return Redirect::route('checklist', array($id, $checkid))->with('fail', 'Cannot be Deleted');
				}
			}
		}
		if($flag == 0)
		{
			return Redirect::route('checklist', array($id, $checkid))->with('fail', 'Invalid checklist id.');
		}
	}

	public function postCheckDelete($id)
	{
		$checkid = Input::get('checkid');

		$check = Checklist::where('task_id', '=', $id)->find($checkid);
		if($check->delete())
		{
			return Redirect::to('user/task/'.$id.'')->with('success', 'Checklist deleted.');
		}
		else
		{
			return Redirect::route('checklist', array($id, $checkid))->with('fail', 'Cannot be Deleted');
		}
	}

}