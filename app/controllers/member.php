<?php

class Member extends Controller {
	
	public function index($userId='nope') {
		if($userId != 'nope') {
			if(User::exists(array('id' => $userId))) {
				$this->channel($userId);
				return;
			}
			else if(User::exists(array('username' => $userId))) {
				$this->channel($userId);
				return;
			}
			else {
				Application::instance()->throwNotFoundError();
				return;
			}
		}

		header('Location: '.WEBROOT);
		exit();
	}

	public function channel($userId='nope') {
		if($userId != 'nope') {
			$this->loadModel('member_model');
			$user = User::find_by_id($userId);

			if(!is_object($user))
				$user = User::find_by_username($userId);

			$data = array();
			$data['name'] = $user->username;
			$data['subscribers'] = $user->subscribers;
			$data['videos'] = $this->model->getVideoesFromUser($user->id);

			$this->renderView('member/channel', $data);
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}