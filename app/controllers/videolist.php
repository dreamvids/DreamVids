<?php

class Videolist extends Controller {
	
	public function index() {
		if(Session::isActive()) {
			$this->feed();
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function discover() {
		$this->loadModel('videolist_model');

		$data = array();
		$data['vids'] = $this->model->getDiscoverVideos();

		$this->renderView('videolist/videolist_discover', $data);
	}

	public function feed($fromUser='nope') {
		$this->loadModel('videolist_model');

		if($fromUser != 'nope' && $this->model->userExists($fromUser) && $fromUser != Session::get()->id) {
			$data = array();
			$data['vids'] = $this->model->getSubscriptionsVideosFromUser(Session::get()->id, $fromUser);

			$this->renderView('videolist/videolist_feed', $data);
		}
		else {
			$data = array();
			$data['vids'] = $this->model->getSubscriptionsVideos(Session::get()->id, 0);

			$this->renderView('videolist/videolist_feed', $data);
		}
	}

	public function subscriptions() {
		$this->loadModel('videolist_model');
		$this->renderView('videolist/videolist_subscriptions');
	}

}