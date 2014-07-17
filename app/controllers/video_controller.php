<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'video.php';
require_once MODEL.'comment.php';
require_once MODEL.'user_channel.php';

class VideoController extends Controller {

public function __construct() {
		$this->denyAction(Action::INDEX);
	}

	public function get($id, $request) {
		if(!Video::exists($id))
			return Utils::getNotFoundResponse();

		$video = Video::find($id);
		$author = UserChannel::find($video->poster_id);

		if($request->acceptsJson()) {
			$videoData = array(
				'id' => $video->id,
				'title' => $video->title,
				'author' => $video->poster_id,
				'description' => $video->description,
				'views' => $video->views,
				'likes' => $video->likes,
				'dislikes' => $video->dislikes
			);

			return new JsonResponse($videoData);
		}

		if($video->isSuspended()) {
			$data = array();
			$data['video'] = $video;
			
			return new ViewResponse('video/suspended', $data);
		}

		$data = array();

		$data['video'] = $video;
		$data['title'] = $video->title;
		$data['poster_id'] = $video->poster_id;
		$data['author'] = $video->getAuthorName();
		$data['description'] = $video->description;
		$data['views'] = $video->views;
		$data['likes'] = $video->likes;
		$data['dislikes'] = $video->dislikes;
		$data['thumbnail'] = $video->tumbnail;
		$data['subscribers'] = $author->getSubscribersNumber();
		$data['comments'] = $video->getComments();
		$data['likedByUser'] = $video->isLikedByUser(Session::get()->id) ? true : false;
		$data['dislikedByUser'] = $video->isDislikedByUser(Session::get()->id) ? true : false;
		$data['recommendations'] = $video->getAssociatedVideos();
		$data['channels'] = Session::get()->getOwnedChannels();

		$data['currentPage'] = "watch";

		$video->addView();
		return new ViewResponse('video/video', $data);
	}

	public function create($request) {

	}

	public function update($id, $request) {

	}

	public function destroy($id, $request) {

	}

	// Called by "GET video/upload"
	public function upload($request) {
		return new Response(200);
	}

	public function edit($id, $request) {
		
	}

	// Called by "GET /video/:id/like"
	public function like($id, $request) {
		if(Session::isActive() && Video::exists(array('id' => $id))) {
			$userId = Session::get()->id;
			$video = Video::find($id);

			if(!$video->isLikedByUser($userId)) {
				if($video->isDislikedByUser($userId)) {
					$video->removeDislike($userId);
				}

				$video->like($userId);
				return new Response(200);
			}
		}

		return new Response(500);
	}

	// Called by "GET /video/:id/unlike"
	public function unlike($id, $request) {
		if(Session::isActive() && Video::exists(array('id' => $id))) {
			$video = Video::find($id);
			$userId = Session::get()->id;

			if($video->isLikedByUser($userId)) {
				$video->removeLike($userId);
				return new Response(200);
			}
		}

		return new Response(500);
	}

	// Called by "GET /video/:id/dislike"
	public function dislike($id, $request) {
		if(Session::isActive() && Video::exists(array('id' => $id))) {
			$userId = Session::get()->id;
			$video = Video::find($id);

			if(!$video->isDislikedByUser($userId)) {
				if($video->isLikedByUser($userId)) {
					$video->removeLike($userId);
				}

				$video->dislike($userId);
				return new Response(200);
			}
		}

		return new Response(500);
	}

	// Called by "GET /video/:id/undislike"
	public function undislike($id, $request) {
		if(Session::isActive() && Video::exists(array('id' => $id))) {
			$video = Video::find($id);
			$userId = Session::get()->id;

			if($video->isDislikedByUser($userId)) {
				$video->removeDislike($userId);
				return new Response(200);
			}
		}

		return new Response(500);
	}

	public function index($request) {}

}