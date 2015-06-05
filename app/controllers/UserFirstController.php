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

	
}