<?php

class Discover extends Controller {

	public function index() {
		$this->loadModel('videolist_model');

		$data = array();
		$data['vids'] = $this->model->getDiscoverVideos();

		$this->renderView('videolist/videolist_discover', $data);
	}

}