<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'ticket.php';
require_once MODEL.'conversation.php';
require_once MODEL.'message.php';

class AdminTicketsController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		$data = [];
		$data['tickets'] = Ticket::find('all');
		return new ViewResponse('admin/tickets/index', $data);
	}
	
	public function solved($id, $request) {
		$ticket = Ticket::find($id);
		$message = "Après prise en charge de votre problème, celui-ci a été signalé comme résolu. Si le problème persiste ou qu'un autre survient, merci de nous le faire savoir via l'assistance.";
		$this->mail($ticket, $message);
		$ticket->delete();
		return new RedirectResponse(WEBROOT.'admin/tickets');
	}
	
	public function inprogress($id, $request) {
		$ticket = Ticket::find($id);
		if ($ticket->tech == '') {
			$ticket->tech = Session::get()->username;
			if (User::exists(array('id' => $ticket->user_id))) {
				$conv = Conversation::createNew('[Assistance] Demande #'.$ticket->id, Session::get()->getMainChannel(), ';'.User::find($ticket->user_id)->getMainChannel()->id.';'.Session::get()->getMainChannel()->id.';');
				Message::sendNew(Session::get()->getMainChannel()->id, $conv, 'Bonjour, je suis '.Session::get()->username.' et j\'ai pris en charge votre demande d\'assistance. Cette conversation a été créé pour pouvoir discuter avec vous. ATTENTION: Ne communiquez jamais votre mot de passe, même à un technicien ! Un vrai technicien a à sa disposition tous les outils nécessaires à la résolution de votre problème !');
				$ticket->conv_id = $conv;
			}
			$ticket->save();
			$message = "Votre demande d'assistance a été prise en charge par {{tech}}. Vous serez prochainement avertit de l'issue de l'intervention.";
			$this->mail($ticket, $message);
		}
		return new RedirectResponse(WEBROOT.'admin/tickets');
	}
	
	public function bug($id, $request) {
		$ticket = Ticket::find($id);
		$message = "Après étude de votre problème, il en résulte qu'il ne s'agit pas d'un incident isolé mais bien d'un problème technique interne à DreamVids (bug). Nous travaillons actuellement à la détection et à la résolution de ce bug mais nous ne pouvons vous donner de plus amples informations. Nous nous excusons pour la gêne occasionnée et vous remerçions de votre patience.";
		$this->mail($ticket, $message);
		$ticket->delete();
		return new RedirectResponse(WEBROOT.'admin/tickets');
	}
	
	private function mail($ticket, $message) {
		if ($ticket->user_id !== '0') {
			$username = (User::exists(array('id' => $ticket->user_id))) ? ' '.User::find($ticket->user_id)->username : '';
			$to = (User::exists(array('id' => $ticket->user_id))) ? User::find($ticket->user_id)->email : $ticket->user_id;
			$subject = '[DreamVids] Avancement de votre demande d\'assistance #'.$ticket->id;
			$message = str_replace('{{tech}}', Session::get()->username, $message);
			$message = "Bonjour$username,\r\n\r\n$message\r\n\r\nCordialement,\r\nL'équipe DreamVids.";
			$headers = 'From: DreamVids <assistance@dreamvids.fr>';
			mail($to, $subject, utf8_decode($message), $headers);
		}
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}