<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';

require_once MODEL.'staff_notifications.php';
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
			if (Session::isActive()) {
				$user_id = Session::get()->id;
			}
			else {
				if (trim($req['email']) != '') {
					$user_id = $req['email'];
				}
				else {
					$user_id = 0;
				}
			}

			$ticket = Ticket::create(array(
				'user_id' => $user_id,
				'description' => $req['bug'],
				'timestamp' => time(),
				'ip' => $_SERVER['REMOTE_ADDR']
			));
			
			StaffNotification::createNotif('ticket', $user_id, null, $ticket->id);
			
			$ticket_id = $ticket->id;
			$response->addMessage(ViewMessage::success('Envoyé ! Vous serez notifié de l\'avancement par E-Mail ou Message Privé (Ticket #'.$ticket_id.')'));
			
			/*$username = (Session::isActive()) ? Session::get()->username : '[Anonyme]';
			$notif = new PushoverNotification();
			$notif->setMessage('Nouveau ticket de '.$username);
			$notif->setReceiver('all');
			$notif->setExtraParameter('url', 'http://dreamvids.fr'.WEBROOT.'admin/tickets');
			$notif->send();*/
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