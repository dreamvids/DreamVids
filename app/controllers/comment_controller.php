<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'user_channel.php';
require_once MODEL.'comment.php';

class CommentController extends Controller {

	public function __construct() {
		$this->denyAction(Action::INDEX);
	}

	public function get($id, $request) {
		$comment = Comment::find($id);

		if(is_object($comment)) {
			if($request->acceptsJson()) {
				$commentData = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'timestamp' => $comment->timestamp,
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);

				return new JsonResponse($commentData);
			}
			else {
				return new RedirectResponse(WEBROOT.'watch/'.$comment->video_id);
			}
		}

		return new Response(500);
	}

	public function create($request) {
		$req = $request->getParameters();

		if(isset($req['commentSubmit'], $req['from-channel'], $req['video-id']) && Session::isActive()) {
			$channelId = Utils::secure($req['from-channel']);
			
			if(UserChannel::exists($channelId) && UserChannel::find($channelId)->belongToUser(Session::get()->id)) {
				$content = Utils::secure($req['comment-content']);
				$content = trim($content);
				$parent = (isset($req['parent'])) ? Utils::secure($req['parent']) : '';
				if (!empty($content)) {
					$vidId = Utils::secure($req['video-id']);
	
					$comment = Comment::postNew($channelId, $vidId, $content, $parent);
	
					$commentData = array(
						'id' => $comment->id,
						'author' => UserChannel::find($comment->poster_id)->name,
						'video_id' => $vidId,
						'comment' => $content,
						'relativeTime' => Utils::relative_time($comment->timestamp),
						'likes' => $comment->likes,
						'dislikes' => $comment->dislikes
					);
	
					return new JsonResponse($commentData);
				}
			}
		}

		return new Response(500);
	}

	public function update($id, $request) {
		$req = $request->getParameters();

		if(isset($req['like']) && Session::isActive() && Comment::exists($id)) {
			$comment = Comment::find($id);

			if(!$comment->isLikedByUser(Session::get())) {
				$comment->like(Session::get());

				$commentData = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);

				return new JsonResponse($commentData);
			}
			else { // The comment is already liked by the user, so we remove the like
				$comment->unlike(Session::get());

				$commentData = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);

				return new JsonResponse($commentData);
			}
		}
		else if(isset($req['dislike']) && Session::isActive() && Comment::exists($id)) {
			$comment = Comment::exists($id) ? Comment::find($id) : false;

			if(!$comment->isDislikedByUser(Session::get())) {
				$comment->dislike(Session::get());

				$commentData = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);

				return new JsonResponse($commentData);
			}
			else { // The comment is already disliked by the user, so we remove the dislike
				$comment->undislike(Session::get());

				$commentData = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);

				return new JsonResponse($commentData);
			}
		}
		else if(isset($req['flag']) && Session::isActive() && Comment::exists($id)) {
			$comment = Comment::exists($id) ? Comment::find($id) : false;

			if(!$comment->isReported() && $req['flag'] == 'true') {
				$comment->report(Session::get());
			}
			else if((Session::get()->isAdmin() || Session::get()->isModerator()) && $req['flag'] == 'false') {
				$comment->unflag(Session::get());
			}
			
			return new Response(200);
		}

		return new Response(500);
	}

	public function destroy($id, $request) {
		$comment = Comment::exists($id) ? Comment::find($id) : false;
		if(Session::isActive() && (Session::get()->isModerator() || Session::get()->isAdmin() || ($comment && $comment->getVideo()->getAuthor()->belongToUser(Session::get()->id)))) { 
			
			$comment->erase(Session::get());
			$response = new Response(200);
			$response->setBody("done");
			return $response;
		}
		$response = new Response(500);
		$response->setBody("error");
		return $response;
	}

	// Return all the comments on the specified video
	public function video($id, $request) {
		$video = Video::exists($id) ? Video::find($id) : false;

		if(!$request->acceptsJson())
			return new RedirectResponse(WEBROOT.'watch/'.$id);

		if(is_object($video)) {
			$comments = $video->getComments();
			$commentsData = array();

			foreach ($comments as $comment) {
				$commentsData[] = array(
					'id' => $comment->id,
					'author' => UserChannel::find($comment->poster_id)->name,
					'video_id' => $comment->video_id,
					'comment' => $comment->comment,
					'relativeTime' => Utils::relative_time($comment->timestamp),
					'timestamp' => $comment->timestamp,
					'likes' => $comment->likes,
					'dislikes' => $comment->dislikes
				);
			}

			return new JsonResponse($commentsData);
		}

		return new Response(500);
	}

	// Denied actions
	public function index($request) {}

}