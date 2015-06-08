<?php

class LoginFacebookController extends BaseController{

	private $fb;

	public function _construct(FacebookHelper $fb)
	{
		$this->fb = $fb;
	}

	public function login()
	{
		return Redirect::to($this->fb->getUrlLogin);
	}

	public function callback()
	{
		dd(Input::all());
	}

}