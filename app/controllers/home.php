<?php

class Home extends Controller {

	public function index() {
		if(Session::isActive()) {
			$this->userpage();
		}
		else {
			header('Location: '.WEBROOT.'discover');
			exit();
		}
	}

	public function userpage() {
		if(Session::isActive()) {
			$this->loadModel('feed_model');

			$data = array();
			$data['subscriptions'] = $this->model->getSubscriptions(Session::get()->id);
			$data['subscriptions_vids'] = $this->model->getSubscriptionsVideos(Session::get()->id, 6);

			$this->renderView('home/logged', $data);
		}
	}

}