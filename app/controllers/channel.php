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
			$this->loadModel('channel_model');
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

	public function subscribe($channelId = 'nope') {
		if($channelId != 'nope' && Session::isActive()) {
			$this->loadModel('channel_model');

			if(Session::get()->id != $channelId && $this->model->channelExists($channelId)) {
				$this->model->subscribeToUser(Session::get()->id, $channelId);

				//TODO: handle subscription to multi-user channels
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function unsubscribe($channelId = 'nope') {
		if($channelId != 'nope' && Session::isActive()) {
			$this->loadModel('channel_model');
			
			if(Session::get()->id != $channelId && $this->model->channelExists($channelId)) {
				$this->model->unsubscribeToUser(Session::get()->id, $channelId);

				//TODO: handle subscription to multi-user channels
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}