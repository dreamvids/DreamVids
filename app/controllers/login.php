<?php

class Login extends Controller {

	public function index() {
		if(!Session::isActive()) {
			$data = array();
			$data['css'] = CSS.'login.css';
			$this->renderView('login/login', $data);
		}
		else if(func_num_args() > 0) {
			if(func_get_arg(0) == 'signout') {
				$this->loadModel('login_model');
				$this->model->logout(Session::get()->id);
				header('Location: '.WEBROOT);
				exit();
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function postRequest($request) {
		$this->loadModel('login_model');
		$data = $request->getValues();

		if(isset($data['submitLogin']) && !Session::isActive()) {
			$username = Utils::secure($data['username']);
			$password = Utils::secure($data['pass']);

			if($this->model->userExists($username)) {
				$realPass = $this->model->getPassForUsername($username);

				if(sha1($password) == $realPass) {
					if(isset($data['remember']))
						$this->model->connect($username, 1);
					else
						$this->model->connect($username, 0);

					header('Location: '.WEBROOT);
					exit();
				}
				else {
					$data = array();
					$data['error'] = 'The password does not corresponds to the username';
					$this->clearView();
					$this->renderView('login/login', $data);
				}
			}
			else {
				$data = array();
				$data['error'] = 'This account does not exists';
				$this->clearView();
				$this->renderView('login/login', $data);
			}
		}
	}
}