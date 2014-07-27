<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'user.php';
require_once MODEL.'message.php';
require_once MODEL.'conversation.php';

class MessageController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function create($request) {
		if(Session::isActive()) {
			$req = $request->getParameters();

			if(isset($req['sender'], $req['conversation'], $req['content']) && !empty($req['conversation']) && !empty($req['sender']) && !empty($req['content'])) {
				$sender = Utils::secure($req['sender']);
				$conversation = Utils::secure($req['conversation']);
				$content = Utils::secure($req['content']);

				$channel = UserChannel::exists($sender) ? UserChannel::find($sender) : false;

				if($channel && $channel->belongToUser(Session::get()->id) && ($conv = Conversation::find($conversation))) {
					if(!$conv->containsChannel($channel))
						return Utils::getUnauthorizedResponse();

					$message = Message::sendNew($sender, $conversation, $content);

					$messageData = array(
						'id' => $message->id,
						'avatar' => $channel->getAvatar(),
						'pseudo' => $channel->name,
						'text' => $content,
						'mine' => 'true'
					);

					return new JsonResponse($messageData);
				}
			}
		}
		
		return new Response(500);
	}

	
	// Denied actions
	public function index($request) {}
	public function get($id, $request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}