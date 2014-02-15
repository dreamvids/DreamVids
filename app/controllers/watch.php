<?php

class Watch extends Controller {
	
	public function index($videoId='nope') {
		if($videoId != 'nope') {
			if(Video::exists(array('id' => $videoId))) {
				$this->video($videoId);
				return;
			}
			else  {
				Application::instance()->throwNotFoundError();
				return;
			}
		}

		header('Location: '.WEBROOT);
		exit();
	}

	public function video($videoId='nope') {
		if($videoId == 'nope') {
			header('Location: '.WEBROOT);
			exit();
			return;
		}

		$this->loadModel('watch_model');

		$data = array();
		$video = $this->model->getVideoById($videoId);
		$data['video'] = $video;
		$data['title'] = $video->title;
		$data['user_id'] = $video->user_id;
		$data['author'] = $this->model->getAuthorsName($videoId);
		$data['description'] = $video->description;
		$data['views'] = $video->views;
		$data['likes'] = $video->likes;
		$data['dislikes'] = $video->dislikes;
		$data['subscribers'] = $this->model->getAuthorsSubscribers($videoId);
		$data['comments'] = $this->model->getCommentsOnVideo($videoId);

		$this->renderView('watch/watch', $data);
	}

}