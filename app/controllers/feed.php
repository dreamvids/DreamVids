<?php

class Feed extends Controller {

	public function index($fromUser = 'nope') {
		if(Session::isActive()) {
			$this->loadModel('feed_model');
			$data = array();

			if($fromUser != 'nope' && $this->model->userExists($fromUser) && $fromUser != Session::get()->id) {
				$data = array();

				$data['subscriptions'] = $this->model->getSubscriptions(Session::get()->id);
				$data['vids'] = $this->model->getSubscriptionsVideosFromUser(Session::get()->id, $fromUser, 6);

				$this->renderView('feed/feed', $data);
			}
			else {
				$data = array();

				$data['subscriptions'] = $this->model->getSubscriptions(Session::get()->id);
				$data['vids'] = $this->model->getSubscriptionsVideos(Session::get()->id, 6);
				$data['subscriptionActions'] = $this->model->getSubscriptionsActions(Session::get()->id);
				$data['personalActions'] = $this->model->getUsersPersonalActions(Session::get()->id);

				$this->renderView('feed/feed', $data);
			}
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}
}