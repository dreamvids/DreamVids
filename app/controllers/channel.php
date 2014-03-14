<?php

class Channel extends Controller {
	
	public function index($channelId='nope') {
		if($channelId != 'nope') {
			if(User::exists(array('id' => $channelId)) || User::exists(array('username' => $channelId))) {
				$this->member($channelId);
				return;
			}
			else if(MultiUserChannel::exists(array('id' => $channelId)) || MultiUserChannel::exists(array('name' => $channelId))) {
				$this->multiuser($channelId);
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
			$data['description'] = $user->description;
			$data['subscribers'] = $user->subscribers;
			$data['videos'] = $this->model->getVideoesFromUser($user->id);
			$data['description'] = $user->description;

			$this->renderView('channel/member', $data);
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function multiuser($channelId = 'nope') {
		if($channelId != 'nope') {
			$this->loadModel('channel_model');
			$channel = MultiUserChannel::find_by_id($channelId);

			if(!is_object($channel))
				$channel = MultiUserChannel::find_by_name($channelId);

			$data = array();
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['videos'] = $this->model->getVideoesFromChannel($channel->id);

			$this->renderView('channel/multiuser', $data);
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function subscribe($channelId = 'nope') {
		if($channelId != 'nope' && Session::isActive()) {
			$this->loadModel('channel_model');

			if(Session::get()->id != $channelId) {
				if(Utils::stringStartsWith($channelId, 'c_'))
					if($this->model->channelExists($channelId)) $this->model->subscribeToMultiUserChannel(Session::get()->id, $channelId);
				else
					if($this->model->channelExists($channelId)) $this->model->subscribeToUser(Session::get()->id, $channelId);
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
			
			if(Session::get()->id != $channelId) {
				if(Utils::stringStartsWith($channelId, 'c_'))
					if($this->model->channelExists($channelId)) $this->model->unsubscribeToMultiUserChannel(Session::get()->id, $channelId);
				else
					$this->model->unsubscribeToUser(Session::get()->id, $channelId);
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}