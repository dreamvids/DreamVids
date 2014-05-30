<?php

class Channel extends Controller {

	private $channelId = 'lolnope';
	
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

			$this->channelId = $channel->id;

			$data = array();
			$data['id'] = $channel->id;
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['videos'] = $this->model->getVideoesFromChannel($channel->id);
			$data['subscribed'] = $this->model->userSubscribedToChannel(Session::get()->id, $channel->id);

			$this->renderView('channel/channel', $data);
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function social($channelId = 'nope') {
		if($channelId != 'nope') {
			$this->loadModel('channel_model');

			if($this->model->channelExists($channelId) | $this->model->channelNameExists($channelId)) {
				$channel = UserChannel::find_by_id($channelId);

				if(!is_object($channel))
					$channel = UserChannel::find_by_name($channelId);

				$this->channelId = $channel->id;

				$data = array();
				$data['id'] = $channel->id;
				$data['name'] = $channel->name;
				$data['description'] = $channel->description;
				$data['subscribers'] = $channel->subscribers;
				$data['videos'] = $this->model->getVideoesFromChannel($channel->id);
				$data['subscribed'] = $this->model->userSubscribedToChannel(Session::get()->id, $channel->id);
				$data['posts'] = $this->model->getPostsOnChannel($channel->id);
				$data['isUsersChannel'] = Session::isActive() ? $this->model->userBelongsToChannel(Session::get()->id, $channel->id) : 'salut';

				$this->renderView('channel/social', $data);
			}
			else Application::instance()->throwNotFoundError();
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function postRequest($request = 'nope') {
		if(is_object($request)) {
			if(!$this->model) {
				$this->loadModel('channel_model');
			}

			$req = $request->getValues();

			if(isset($req['post-message-submit']) && Session::isActive() && $this->channelId != 'lolnope') {
				if($this->model->userBelongsToChannel(Session::get()->id, $this->channelId)) {
					$postContent = $req['post-content'];
					
					$this->model->postMessageOnChannel($this->channelId, $postContent);
				}
			}
		}
	}

	public function subscribe($channelId = 'nope') {
		if($channelId != 'nope' && Session::isActive()) {
			$this->loadModel('channel_model');

			if($this->model->channelExists($channelId) && !$this->model->userBelongsToChannel(Session::get()->id, $channelId)) {
				$this->model->subscribeToChannel(Session::get()->id, $channelId);
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
			
			if($this->model->channelExists($channelId) && !$this->model->userBelongsToChannel(Session::get()->id, $channelId)) {
				$this->model->unsubscribeToChannel(Session::get()->id, $channelId);
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

}