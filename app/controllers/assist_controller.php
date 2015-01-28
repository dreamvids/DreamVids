<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';

require_once MODEL.'ticket.php';
require_once MODEL.'pushover.php';

class AssistController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		return new ViewResponse('assist/ticket');
	}
	
	public function create($request) {
		$req = $request->getParameters();
		$response = new ViewResponse('assist/ticket');
		if (trim($req['bug']) != '') {
			$user_id = (Session::isActive()) ? Session::get()->id : 0;
			$ticket = Ticket::create(array(
				'user_id' => $user_id,
				'description' => $req['bug'],
				'url' => $req['url'],
				'ip' => $_SERVER['REMOTE_ADDR']
			));
			$ticket_id = $ticket->id;
			$response->addMessage(ViewMessage::success('Envoyé ! Vous serez notifié de l\'avancement de votre problème par E-Mail (Ticket #'.$ticket_id.')'));
			
			$notif = new PushoverNotification();
			$notif->setMessage('Nouveau ticket de '.Session::get()->username);
			$notif->setReceiver('all');
			$notif->setExtraParameter('url', 'http://dreamvids.fr'.WEBROOT.'admin/tickets');
			$notif->send();
		}
		else {
			$response->addMessage(ViewMessage::error('Merci de nous décrire votre problème.'));
		}
		return $response;
	}

	public function get($id, $request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}