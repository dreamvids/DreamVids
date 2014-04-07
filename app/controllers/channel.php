<?php

class Channel extends Controller {
	
	public function index($channelId='nope') {

		if($channelId != 'nope') {
			if(UserChannel::exists(array('id' => $channelId)) || UserChannel::exists(array('name' => $channelId))) {
				$this->show($channelId);
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

	public function show($channelId = 'nope') {
		if($channelId != 'nope') {
			$this->loadModel('channel_model');
			$channel = UserChannel::find_by_id($channelId);

			if(!is_object($channel))
				$channel = UserChannel::find_by_name($channelId);

			$data = array();
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['videos'] = $this->model->getVideoesFromChannel($channel->id);

			$this->renderView('channel/channel', $data);
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
				if(Utils::stringStartsWith($channelId, 'c_'))
					$this->model->subscribeToMultiUserChannel(Session::get()->id, $channelId);
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
				if(Utils::stringStartsWith($channelId, 'c_'))
					if($this->model->channelExists($channelId)) $this->model->unsubscribeToMultiUserChannel(Session::get()->id, $channelId);
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}