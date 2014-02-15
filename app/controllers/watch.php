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
		$data['likedByUser'] = $this->model->isVideoLikedByUser($videoId) ? true : false;
		$data['dislikedByUser'] = $this->model->isVideoDislikedByUser($videoId) ? true : false;

		$this->renderView('watch/watch', $data);
	}

	public function like($videoId='nope') {
		if($videoId != 'nope' && Session::isActive() && Video::exists(array('id' => $videoId))) {
			$this->loadModel('watch_model');
			$userId = Session::get()->id;

			if(!$this->model->isVideoLikedByUser($videoId, Session::get()->id)) {

				if($this->model->isVideoDislikedByUser($videoId, Session::get()->id)) {
					$this->model->removeDislike($videoId, $userId);
				}

				$this->model->likeVideo($videoId, $userId);
			}
		}
	}

	public function dislike($videoId='nope') {
		if($videoId != 'nope' && Session::isActive() && Video::exists(array('id' => $videoId))) {
			$this->loadModel('watch_model');
			$userId = Session::get()->id;

			if(!$this->model->isVideoDislikedByUser($videoId, Session::get()->id)) {

				if($this->model->isVideoLikedByUser($videoId, Session::get()->id)) {
					$this->model->removeLike($videoId, $userId);
				}

				$this->model->dislikeVideo($videoId, $userId);
			}
		}
	}

	public function unlike($videoId='nope') {
		if($videoId != 'nope' && Session::isActive() && Video::exists(array('id' => $videoId))) {
			$this->loadModel('watch_model');
			$userId = Session::get()->id;

			if($this->model->isVideoLikedByUser($videoId, Session::get()->id)) {
				$this->model->removeLike($videoId, $userId);
			}
		}
	}

	public function undislike($videoId='nope') {
		if($videoId != 'nope' && Session::isActive() && Video::exists(array('id' => $videoId))) {
			$this->loadModel('watch_model');
			$userId = Session::get()->id;

			if($this->model->isVideoDislikedByUser($videoId, Session::get()->id)) {
				$this->model->removeDislike($videoId, $userId);
			}
		}
	}

}