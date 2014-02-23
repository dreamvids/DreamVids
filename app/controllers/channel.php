<?php

class Channel extends Controller {
	
	public function index($channelId='nope') {
		if($channelId != 'nope') {
			if(User::exists(array('id' => $channelId))) {
				$this->member($channelId);
				return;
			}
			else if(User::exists(array('username' => $channelId))) {
				$this->member($channelId);
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

	public function member($userId='nope') {
		if($userId != 'nope') {
			$this->loadModel('member_model');
			$user = User::find_by_id($userId);

			if(!is_object($user))
				$user = User::find_by_username($userId);

			$data = array();
			$data['name'] = $user->username;
			$data['subscribers'] = $user->subscribers;
			$data['videos'] = $this->model->getVideoesFromUser($user->id);

			$this->renderView('channel/member', $data);
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}