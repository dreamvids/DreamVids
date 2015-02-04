<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'password';

class PasswordController extends Controller {
	
	public function __construct() {
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		if (Session::isActive()) {
			return new RedirectResponse(WEBROOT);
		}
		else {
			$data = array();
			$data['currentPageTitle'] = 'Mot de passe oublié';
			return new ViewResponse('password/password', $data);
		}
	}
	
	public function create($request) {
		$req = $request->getParameters();
		$data = array();
		$data['currentPageTitle'] = 'Mot de passe oublié';
		$resp = new ViewResponse('password/password', $data);
		if (!empty($req['email']) xor !empty($req['pseudo'])) {
			if (!empty($req['email'])) {
				if (Utils::validateMail($req['email'])) {
					if (User::exists(array('email' => $req['email']))) {
						$user_id = User::find(array('email' => $req['email']))->id;
						$email = $req['email'];
					}
					else {
						$resp->addMessage(ViewMessage::error('Cette adresse E-Mail n\'est associée à aucun compte.'));
						return $resp;
					}
				}
				else {
					$resp->addMessage(ViewMessage::error('Merci de renseigner une adresse E-Mail valide !'));
					return $resp;
				}
			}
			else if (!empty($req['pseudo'])) {
				if (User::exists(array('username' => $req['pseudo']))) {
					$user_id = User::find(array('username' => $req['pseudo']))->id;
					$email = User::find(array('username' => $req['pseudo']))->email;
				}
				else {
					$resp->addMessage(ViewMessage::error('Ce Pseudo n\'est associé à aucun compte.'));
					return $resp;
				}
			}
			$key = md5(uniqid());
			Password::create(array(
				'user_id' => $user_id,
				'key' => $key
			));
			
			$headers = 'From: DreamVids <ne-pas-repondre@dreamvids.fr>' . "\r\n".
			'MIME-Version: 1.0' . "\r\n".
			'Content-type: text/html; charset=utf-8' . "\r\n";
			$message = 'Vous avez demandé la réinitialisation de votre mot de passe DreamVids. Clique sur le lien ci-dessous pour accéder à votre nouveau mot de passe :<br /><br />
			<a href="http://dreamvids.fr/password/'.$key.'">http://dreamvids.fr/password/'.$key.'</a>';
			mail($email, 'DreamVids - Mot de passe oublié', $message, $headers);
			$resp->addMessage(ViewMessage::success('Vous allez recevoir un E-Mail à l\'adresse '.$email.', suivez-en les instructions.'));
		}
		else {
			$resp->addMessage(ViewMessage::error('Merci de renseigner une Adresse E-Mail OU un Pseudo.'));
		}
		return $resp;
	}
	
	// je kiff cette musique les gens <3 20/08/2014 18:37 #LiveCoding #Wesh (KDrew - Bullseye)

	public function get($key, $request){
		if (Password::exists(array('key' => $key))) {
			$pass = Password::find_by_key($key);
			$user = User::find($pass->user_id);
			$pass->delete();
			$pass = Password::generatePass(9);
			$user->pass = password_hash($pass, PASSWORD_BCRYPT);
			$user->save();
			$data = array();
			$data['currentPageTitle'] = 'Connexion';
			$resp = new ViewResponse('login/login', $data);
			$resp->addMessage(ViewMessage::success('Voici votre nouveau mot de passe: <b>'.$pass.'</b>. Connectez-vous dès maintenant !'));
			return $resp;
		}
		else {
			$data = array();
			$data['currentPageTitle'] = 'Mot de passe oublié';
			$resp = new ViewResponse('password/password', $data);
			$resp->addMessage(ViewMessage::error('Clé invalide ou expirée, merci de recommencer la procédure'));
			return $resp;
		}
	}
	
	public function update($id, $request){}
	public function destroy($id, $request){}
}