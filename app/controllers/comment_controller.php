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
				$vidId = Utils::secure($req['video-id']);

				$comment = Comment::postNew($channelId, $vidId, $content);

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

		return new Response(500);
	}

	public function update($id, $request) {

	}

	public function destroy($id, $request) {

	}

	// "GET /comments/:id/like"
	public function like($id, $request) {
		if(Session::isActive() && Comment::exists($id)) {
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
		}

		return new Response(500);
	}

	// "GET /comments/:id/dislike"
	public function dislike($id, $request) {
		if(Session::isActive() && Comment::exists($id)) {
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
		}

		return new Response(500);
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