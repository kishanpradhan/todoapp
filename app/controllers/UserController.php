<?php

class UserController extends BaseController
{
	//gets the view for the register page
	/*public function getCreate()
	{
		return View::make('user.register');
	}

	//gets the view for the login page
	public function getLogin()
	{
		//return View::make('user.login');
	}

	public function postCreate()
	{
		return "Post create";
	}

	public function postLogin()
	{
		return View::make('user.todo');	
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}*/

	public function getIndex()
	{
		$tasks = Task::where('creator_id', '=', Auth::user()->id)->get();
		return View::make('user.todo')->with('tasks', $tasks);
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
			return Redirect::to('user/create')->withErrors($validate)->withInput();
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
					return Redirect::to('user/login')->with('success', 'You registered successfully. You can now login');
				}
			}
			else
			{
				return Redirect::to('user/create')->with('fail', 'Your registration failed. Please try again.');
			}
		}
	}

	public function getLogin()
	{
		return View::make('hello');
	}

	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'email' => 'required',
			'password' => 'required',
		));

		if($validator->fails())
		{
			return Redirect::to('user/login')->withErrors($validator)->withInput();
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
				return Redirect::to('user/login')->with('fail','You entered wrong login credentials. Please try again.');
			}
		}	
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}

	public function getCreateTask()
	{
		return View::make('task.create');
	}

	public function postCreateTask()
	{
		$validate = Validator::make(Input::all(), array(
			'title' => 'required|min:2',
			'taskdesc' => 'required|min:4'
		));

		if($validate->fails())
		{
			return Redirect::to('user/create-task')->withErrors($validate)->withInput();
		}
		else
		{
			$task = new Task();
			$task->title = Input::get('title');
			$task->task_desc = Input::get('taskdesc');
			$task->creator_id = Auth::user()->id;
			$task->parent_id = 0;


			if ($task->save())
			{
				
				return Redirect::to('user/create-task')->with('success', 'Your task created successfully.');
				
			}
			else
			{
				return Redirect::to('user/create-task')->with('fail', 'Your task is not created due to some error.');
			}
		}
	}

}