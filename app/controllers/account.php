<?php

class Account extends Controller {

	public function index() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			
			$this->renderView('account/profile', $data);
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

			$this->renderView('account/settings', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function videos() {
		if(Session::isActive()) {
			$this->loadModel('account_model');
			
			$data['user'] = Session::get();
			$data['videos'] = $this->model->getVideosFromUser(Session::get()->id);

			$this->renderView('account/videos', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function channels() {
		if(Session::isActive()) {
			$this->loadModel('account_model');
			
			$data['user'] = Session::get();
			$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);

			$this->renderView('account/channels', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function postRequest($request) {
		if(is_object($request)) {
			$this->loadModel('account_model');
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
							$this->renderView('account/settings', $data);
						}
					}
					else {
							$data = array();
							$data['error'] = 'Les mots de passe ne sont pas identiques';
							$this->clearView();
							$this->renderView('account/settings', $data);
					}
				}
			}

			if(isset($req['avatarSubmit']) && Session::isActive()) {
				
			}

			if(isset($req['createChannelSubmit']) && Session::isActive()) {
				
			}
		}
	}

}