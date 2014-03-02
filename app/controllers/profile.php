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

	public function postRequest($request) {
		if(is_object($request)) {
			$this->loadModel('profile_model');
			$req = $request->getValues();

			if(isset($req['passwordSubmit']) && Session::isActive()) {
				if(isset($req['pass1']) && isset($req['pass2']) && isset($req['actualPass'])) {
					if($req['pass1'] == $req['pass2']) {
						$actualPass = sha1($req['actualPass']);
						$newPass = sha1($req['pass1']);

						if($actualPass == Session::get()->pass) {
							$this->model->setPassword(Session::get()->id, $newPass);
						}
						else {
							$data = array();
							$data['error'] = 'Le mot de pass actuel n\'est pas valide';
							$this->clearView();
							$this->renderView('profile/settings', $data);
						}
					}
					else {
							$data = array();
							$data['error'] = 'Les mots de passe ne sont pas identiques';
							$this->clearView();
							$this->renderView('profile/settings', $data);
					}
				}
			}

			if(isset($req['avatarSubmit'])) {
				
			}
		}
	}

}