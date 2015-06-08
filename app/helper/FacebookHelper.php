<?php
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

class FacebookHelper{

	private $helper;

	public function _construct()
	{
		FacebookSession::setDefaultApplication(Config::get('facebook.app_id'), Config::get('facebook.app_secret'));
		$this->helper = new FacebookRedirectLoginHelper(url('login/fb/callback'));
		
	}

	public function getUrlLogin()
	{
		return $this->$helper->getLoginUrl(Config::get('facebook.app_scope'));
	}
}