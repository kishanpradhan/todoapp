<?php



//Next time never do this code......
class UserFirstController extends BaseController{

	public function getLogin()
	{
		//dd('die');
		return View::make('hello');
	}

	public function getCreate()
	{
		return View::make('user.register');
	}

	public function postCreate()
	{
		$validate = Validator::make(Input::all(), array(
			'firstname' => 'required|min:4',
			'lastname' => 'required|min:4',
			'email' => 'required',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1',
			'country' => 'required',
		));

		if($validate->fails())
		{
			return Redirect::to('create')->withErrors($validate)->withInput();
		}
		else
		{
			$user = new User();
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('pass1'));



			if ($user->save())
			{
				$userprofile = new UsersProfile();
				$userprofile->first_name = Input::get('firstname');
				$userprofile->last_name = Input::get('lastname');
				$userprofile->country = Input::get('country');
				$userprofile->user_id = $user->id;
				if($userprofile->save())
				{
					return Redirect::to('login')->with('success', 'You registered successfully. You can now login');
				}
			}
			else
			{
				return Redirect::to('create')->with('fail', 'Your registration failed. Please try again.');
			}
		}
	}


	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'email' => 'required',
			'password' => 'required',
		));

		if($validator->fails())
		{
			return Redirect::to('login')->withErrors($validator)->withInput();
		}
		else
		{
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			), $remember);

			if($auth)
			{
				Session::put('logemail', Input::get('email'));
				return Redirect::intended('/user');
			}
			else
			{
				return Redirect::to('login')->with('fail','You entered wrong login credentials. Please try again.');
			}
		}	
	}

	public function postAjax($id)
	{
		$sid = Input::get('id');
		$stask = Task::find($sid);
		$ptask = Task::find($stask->parent_id);
		$logid = Auth::user()->id;
		if($stask->parent_id == $id && ($stask->creator_id == $logid || $patask->creator_id == $logid))
		{
			$stask->completed = 1;
			if($stask->save())
			{
				return "success";
			}
			else
			{
				return "Pata nahin Kya hua hai";
			}
		}
		else
		{
			return "failed";
		}
	}

	public function getAjax()
	{
		return "dslfjsl";
	}

	public function postK()
	{
		return "aaasaas";
	}
}