<?php

class Videolist extends Controller {
	
	public function index() {
		if(Session::isActive()) {
			$this->discover();
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

	public function subscriptions() {
		$this->loadModel('videolist_model');
		$this->renderView('videolist/videolist_subscriptions');
	}

}