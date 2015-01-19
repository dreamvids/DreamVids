<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';

require_once MODEL.'ticket.php';

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
			$username = (Session::isActive()) ? Session::get()->username : '[Anonyme]';
			Ticket::create(array(
				'username' => $username,
				'description' => $req['bug'],
				'url' => $req['url'],
				'ip' => $_SERVER['REMOTE_ADDR']
			));
			$response->addMessage(ViewMessage::success('Envoyé ! Vous serez notifié par E-Mail dès qu\'une réponse sera apporté à votre problème.'));
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