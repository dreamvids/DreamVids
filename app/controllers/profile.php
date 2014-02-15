<?php

class Profile extends Controller {

	public function index() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			
			$this->renderView('profile/profile', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function settings() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;

			$this->renderView('profile/settings', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

}