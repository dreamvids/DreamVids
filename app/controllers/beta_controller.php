<?php
/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'beta_key.php';

class BetaController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		if (Session::isActive()) {
			return new RedirectResponse(WEBROOT);
		}
		return new ViewResponse('beta/beta', array(), false);
	}

	public function create($request) {
		$req = $request->getParameters();
		
		if (BetaKey::exists(array('keey' => $req['key'], 'used' => 0))) {
			$key = BetaKey::find_by_keey($req['key']);
			if(isset($req['submitRegister'], $req['username'], $req['pass'], $req['pass-confirm'], $req['mail'])) {
				$username = Utils::secure($req['username']);
				$pass = Utils::secure($req['pass']);
				$pass2 = Utils::secure($req['pass-confirm']);
				$mail = Utils::secure($req['mail']);
	
				$data = $_POST;
	
				if(Utils::validateUsername($username) && Utils::validateMail($mail) && $pass2 != '' && $pass != '') {
					if($pass == $pass2) {
						if(!User::find_by_username($username)) {
							if(!User::isMailRegistered($mail)) {
								$key->used = 1;
								$key->save();
								
								User::register($username, $pass, $mail);
								
								$created_user = User::find('first', array('username' => $username));
								$created_user->sendWelcomeNotification();
								
								
								$response = new ViewResponse('login/login');
								$response->addMessage(ViewMessage::success('Inscription validée. Vous pouvez vous connecter !'));
								return $response;
							}
							else {
								$data['msg'] = 'Cette adresse e-mail est déjà enregistrée';
								$response = new ViewResponse('beta/beta', $data, false);
	
								return $response;
							}
						}
						else {
							$data['msg'] = 'Ce nom d\'utilisateur est déjà pris';
							$response = new ViewResponse('beta/beta', $data, false);
	
							return $response;
						}
					}
					else {
						$data['msg'] = 'Les mots de passe ne correspondent pas';
						$response = new ViewResponse('beta/beta', $data, false);
	
						return $response;
					}
				}
				else {
					$data['msg'] = 'Veuillez saisir des informations valides';
					$response = new ViewResponse('beta/beta', $data, false);
	
					return $response;
				}
			}
			else {
				$data['msg'] = 'Tous les champs doivent être remplis.';
				$response = new ViewResponse('beta/beta', $data, false);
	
				return $response;
			}
		}
		else {
			$data['msg'] = 'Clé invalide ou déjà utilisée !';
			$response = new ViewResponse('beta/beta', $data, false);
	
			return $response;
		}
	}
	
	public function get($id, $request){}
	public function update($id, $request){}
	public function destroy($id, $request){}

}
/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */