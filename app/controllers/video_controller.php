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

	public function get($id, $request, $playlist = false) {
		if(!Video::exists($id)) {
			return Utils::getNotFoundResponse();
		}

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
			$data['author'] = $author;
			$data['video'] = $video;
			
			return new ViewResponse('video/suspended', $data);
		}
		elseif($video->isPrivate() && $video->poster_id != Session::get()->getMainChannel()->id) {
			$data = array();
			$data['author'] = $author;
			$data['video'] = $video;
			
			return new ViewResponse('video/private', $data);
		}

		$data = array();

		$data['playlist'] = $playlist;
		$data['video'] = $video;
		$data['playlists'] = array();
		$data['channels'] = (Session::isActive()) ? Session::get()->getOwnedChannels() : array();
		foreach ($data['channels'] as $chan) {
			$data['playlists'][$chan->id] = Playlist::all(array('conditions' => array('channel_id = ?', $chan->id), 'order' => 'timestamp desc'));
		}
		$data['title'] = $video->title;
		$data['tags'] = array();
		$tags = explode(' ', $video->tags);
		foreach ($tags as $tag) {
			$tag = trim($tag);
			$tag = str_replace(',', '', $tag);
			$tag = str_replace(';', '', $tag);
			$tag = str_replace(':', '', $tag);
			$tag = str_replace('.', '', $tag);
			$tag = '<a href="search?q=%23'.$tag.'">#'.$tag.'</a>';
			$data['tags'][] = $tag;
		}
		$data['poster_id'] = $video->poster_id;
		$data['author'] = $author;
		$data['description'] = $video->description;
		$data['views'] = $video->views;
		$data['likes'] = $video->likes;
		$data['dislikes'] = $video->dislikes;
		$data['thumbnail'] = $video->getThumbnail();
		$data['subscribers'] = $author->getSubscribersNumber();
		$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($author->id) : false;
		$data['likedByUser'] = Session::isActive() ? $video->isLikedByUser(Session::get()->id) : false;
		$data['dislikedByUser'] = Session::isActive() ? $video->isDislikedByUser(Session::get()->id) : false;
		$data['recommendations'] = $video->getAssociatedVideos();
		$data['channels'] = Session::isActive() ? Session::get()->getOwnedChannels() : array();
		$data['flagged'] = $video->isFlagged();
		$data['discover'] = $video->discover;

		$data['currentPage'] = "watch";

		$video->addView();
		return new ViewResponse('video/video', $data);
	}

	public function create($request) {

	}

	public function update($id, $request) {
		$req = $request->getParameters();

		if(Session::isActive()) {
			if($video = Video::find($id)) {
				if(isset($req['video-edit-submit'], $req['video-title'], $req['video-description'], $req['video-tags'])) {
					$data['video'] = $video;

					$title = $req['video-title'];
					$description = $req['video-description'];
					$tags = $req['video-tags'];

					if(Utils::validateVideoInfo($title, $description, $tags)) {
						$video->updateInfo($title, $description, $tags);
						$data['video'] = $video;

						$response = new ViewResponse('video/edit', $data);
						$response->addMessage(ViewMessage::success('Votre video a bien été modifitée !'));

						return $response;
					}
					else {
						$response = new ViewResponse('video/edit', $data);
						$response->addMessage(ViewMessage::error('Les informations ne sont pas valides !'));

						return $response;
					}
				}
				else if(isset($req['flag']) && !empty($req['flag'])) {
					$flag = $req['flag'];

					if($flag == 'false' && (Session::get()->isModerator() || Session::get()->isAdmin())) {
						$video->unFlag(Session::get()->id);
						return new Response(200);
					}
					else if($flag == 'true') {
						$video->flag(Session::get()->id);
						return new Response(200);
					}
				}
				else if(isset($req['suspend']) && !empty($req['suspend']) && (Session::get()->isModerator() || Session::get()->isAdmin())) {
					$suspend = $req['suspend'];

					if($suspend == 'false') {
						$video->unSuspend(Session::get()->id);
						return new Response(200);
					}
					else if($suspend == 'true') {
						$video->suspend(Session::get()->id);
						return new Response(200);
					}
				}
				else if(isset($req['like'])) {
					$userId = Session::get()->id;

					if(!$video->isLikedByUser($userId)) {
						if($video->isDislikedByUser($userId)) {
							$video->removeDislike($userId);
						}

						$video->like($userId);
						return new Response(200);
					}
				}
				else if(isset($req['dislike'])) {
					$userId = Session::get()->id;

					if(!$video->isDislikedByUser($userId)) {
						if($video->isLikedByUser($userId)) {
							$video->removeLike($userId);
						}

						$video->dislike($userId);
						return new Response(200);
					}
				}
				else if(isset($req['unlike'])) {
					$userId = Session::get()->id;

					if($video->isLikedByUser($userId)) {
						$video->removeLike($userId);
						return new Response(200);
					}
					
				}
				else if(isset($req['undislike'])) {
					$userId = Session::get()->id;

					if($video->isDislikedByUser($userId)) {
						$video->removeDislike($userId);
						return new Response(200);
					}
				}
				else if(isset($req['discover'])) {
					$video->discover = Utils::tps();
					$video->save();
				}
			}
		}

		return new Response(500);
	}

	public function destroy($id, $request) {
		if(Session::isActive() && Session::get()->isAdmin()) {
			if($video = Video::find($id)) {
				$video->erase(Session::get()->id);

				return new Response(200);
			}
		}

		return new Response(500);
	}

	// Called by "GET video/upload"
	public function upload($request) {
		return new Response(200);
	}

	public function edit($id, $request) {
		if(Session::isActive()) {
			if($video = Video::find($id)) {
				$data = array();

				$data['video'] = $video;
				return new ViewResponse('video/edit', $data);
			}
			else
				return new RedirectResponse(WEBROOT.'account/videos');
		}
		else 
			return new RedirectResponse(WEBROOT.'login');
	}

	public function index($request) {}

}