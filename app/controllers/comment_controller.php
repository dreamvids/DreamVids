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


	// Denied actions
	public function index($request) {}

}