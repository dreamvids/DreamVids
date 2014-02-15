<?php

class Videolist extends Controller {
	
	public function index() {
		$this->feed();
	}

	public function discover() {
		$this->loadModel('videolist_model');

		$data = array();
		$data['vids'] = $this->model->getDiscoverVideos();

		$this->renderView('videolist/videolist_discover', $data);
	}

	public function feed() {
		$this->loadModel('videolist_model');
		$this->renderView('videolist/videolist_feed');
	}

	public function subscriptions() {
		$this->loadModel('videolist_model');
		$this->renderView('videolist/videolist_subscriptions');
	}

}