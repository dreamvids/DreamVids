<?php

class Watch extends Controller {
	
	private static $vidId = -1;

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
		$this->loadModel('watch_model');

		if($videoId == 'nope') {
			header('Location: '.WEBROOT);
			exit();
			return;
		}

		if($this->model->isVideoSuspended($videoId)) {
			$data = array();
			$data['video'] = $this->model->getVideoById($videoId);
			
			$this->renderView('watch/suspended', $data);
			exit();
			return;
		}

		self::$vidId = $videoId;

		$data = array();
		$video = $this->model->getVideoById($videoId);
		$data['video'] = $video;
		$data['title'] = $video->title;
		$data['poster_id'] = $video->poster_id;
		$data['author'] = $this->model->getAuthorsName($videoId);
		$data['description'] = $video->description;
		$data['views'] = $video->views;
		$data['likes'] = $video->likes;
		$data['dislikes'] = $video->dislikes;
		$data['thumbnail'] = $video->tumbnail;
		$data['subscribers'] = $this->model->getAuthorsSubscribers($videoId);
		$data['comments'] = $this->model->getCommentsOnVideo($videoId);
		$data['likedByUser'] = $this->model->isVideoLikedByUser($videoId) ? true : false;
		$data['dislikedByUser'] = $this->model->isVideoDislikedByUser($videoId) ? true : false;
		$data['recommendations'] = $this->model->getRecommendedVideos($video->poster_id);

		$this->model->addView($videoId);
		$this->renderView('watch/watch', $data);
	}

	public function postRequest($request) {
		$req = $request->getValues();

		if(isset($req['commentSubmit']) && Session::isActive()) {
			$content = Utils::secure($req['comment-content']);

			$this->model->postComment(Session::get()->getMainChannel()->id, self::$vidId, $content); // TODO: Allow the user to choose the channel to post with
		}
	}

	public function comment($commentText='nope') {
		if($commentText != 'nope' && Session::isActive()) {
			$this->model->postComment(Session::get()->getMainChannel()->id, self::$vidId, $commentText); // TODO: Allow the user to choose the channel to post with	
		}
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