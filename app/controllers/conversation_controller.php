<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'user.php';
require_once MODEL.'message.php';
require_once MODEL.'conversation.php';

class ConversationController extends Controller {

	public function __construct() {
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(Session::isActive()) {
			if($request->acceptsJson()) {
				$conversations = Conversation::getByUser(Session::get());

				$conversationsData = array();
				foreach($conversations as $conv) {
					$conversationsData[] = array(
						'id' => $conv->id,
						'title' => $conv->object,
						'members' => $conv->getMemberChannelsName(),
						'avatar' => 'http://lorempicsum.com/nemo/255/200/2', //TODO: Send the conversations's creator's avatar
						'text' => $conv->getLastMessage() ? $conv->getLastMessage()->content : 'Aucun message'
					);
				}

				return new JsonResponse($conversationsData);
			}
		}
		else
			return Utils::getUnauthorizedResponse();

		return new Response(500);
	}

	public function get($id, $request) {
		if(Session::isActive()) {
			if($conv = Conversation::find($id)) {
				if(!$conv->isUserAllowed(Session::get()))
					return Utils::getUnauthorizedResponse();

				$messages = $conv->getMessages();
				foreach ($messages as $message) {
					$sender = UserChannel::exists($message->sender_id) ? UserChannel::find($message->sender_id) : false;

					if(is_object($sender)) {
						$senderAvatar = $sender->getAvatar();

						$messagesData[] = array(
							'id' => 'id',
							'pseudo' => $sender->name,
							'avatar' => $senderAvatar,
							'text' => $message->content,
							'mine' => $sender->belongToUser(Session::get()->id)
						);
					}
				}

				$conversationsData = array();

				$avatar = $conv->thumbnail;

				/*if(!is_array(getimagesize($avatar))) { // if the image is invalid
					if(is_array(getimagesize(WEBROOT.$avatar)))
						$avatar = WEBROOT.$avatar;
					else
						$avatar = Config::getValue_('default-avatar');
				}*/


				$conversationsData['infos'] = array(
					'id' => $conv->id,
					'title' => $conv->object,
					'members' => $conv->getMemberChannelsName(),
					'avatar' => $avatar,
					'text' => isset(end($messages)->content) ? end($messages)->content : 'Aucun message'
				);

				if(isset($messagesData))
					$conversationsData['messages'] = $messagesData;

				return new JsonResponse($conversationsData);
			}
		}
		else
			return Utils::getUnauthorizedResponse();

		return new Response(500);
	}

	public function create($request) {
		if(Session::isActive()) {
			$req = $request->getParameters();

			if(isset($req['members'], $req['creator'], $req['subject']) && !empty($req['members']) && !empty($req['creator'])) {
				$membersStr = Utils::secure($req['members']);
				$creator = Utils::secure($req['creator']);
				$subject = !empty(Utils::secure($req['subject'])) ? Utils::secure($req['subject']) : 'Sans titre';

				if(($sender = UserChannel::find($creator))/* && strpos($membersStr, ';') */) {
					if(Utils::stringStartsWith($membersStr, ';'))
						$membersStr = substr_replace($membersStr, '', 0, 1);
					if(Utils::stringEndsWith($membersStr, ';'))
						$membersStr = substr_replace($membersStr, '', -1);

					$membersStr = preg_replace('/\s+/', '', $membersStr);

					$membersIdsFinal = ';';

					if(strpos($membersStr, ';')) {
						foreach (explode(';', $membersStr) as $destId) {
							if($dest = UserChannel::find_by_name($destId)) {
								$membersIdsFinal .= $dest->id.';';
							}
							else {
								$response = new Response(500);
								$response->setBody('Error: Le destinataire <'.$destId.'> n\'existe pas !');

								return $response;
							}
						}
					}
					else if($chann = UserChannel::find_by_name($membersStr)) {
						$membersIdsFinal .= $chann->id.';';
					}
					else {
						$response = new Response(500);
						$response->setBody('Error: les destinataires doivent être séparés par un \';\' !');

						return $response;
					}

					if($membersIdsFinal != ';') {
						$membersIdsFinal .= $sender->id.';';

						Conversation::createNew($subject, $sender, $membersIdsFinal);
						return new Response(200);
					}
				}
			}
		}
		
		return new Response(500);
	}

	// /conversations/channel/:id
	public function channel($id, $request) {
		if(Session::isActive() && ($channel = UserChannel::find($id)) && ($channel->belongToUser(Session::get()->id))) {
			if($request->acceptsJson()) {
				$conversations = Conversation::getByChannel($channel);

				$conversationsData = array();
				foreach($conversations as $conv) {
					$conversationsData[] = array(
						'id' => $conv->id,
						'title' => $conv->object,
						'members' => $conv->getMemberChannelsName(),
						'avatar' => $conv->getThumbnail(),
						'text' => $conv->getLastMessage() ? $conv->getLastMessage()->content : 'Aucun message'
					);
				}

				return new JsonResponse($conversationsData);
			}
		}
		else
			return Utils::getUnauthorizedResponse();

		return new Response(500);
	}

	
	// Denied actions
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}