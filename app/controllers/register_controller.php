<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

class RegisterController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(Session::isActive()) {
			return new RedirectResponse(WEBROOT.'login');
		}
		else {
			return new ViewResponse('login/register');
		}
	}

	// Called by a POST request
	public function create($request) {
		$req = $request->getParameters();

		if(isset($req['submitRegister'])) {
			if(isset($req['username'])) {
				if(isset($req['pass'])) {
					if(isset($req['pass-confirm'])) {
						if(isset($req['mail'])) {
							$username = Utils::secure($req['username']);
							$pass = Utils::secure($req['pass']);
							$pass2 = Utils::secure($req['pass-confirm']);
							$mail = Utils::secure($req['mail']);

							$data = $_POST;

							if(Utils::validateUsername($username) && Utils::validateMail($mail) && $pass2 != '' && $pass != '') {
								if($pass == $pass2) {
									if(!User::find_by_username($username)) {
										if(!User::isMailRegistered($mail)) {
											User::register($username, $pass, $mail);

											$response = new ViewResponse('login/login');
											$response->addMessage(ViewMessage::success('Inscription validée. Vous pouvez vous connecter !'));
											return $response;
										}
										else {
											$response = new ViewResponse('login/register', $data);
											$response->addMessage(ViewMessage::error('Cette adresse e-mail est déjà occupée'));

											return $response;
										}
									}
									else {
										$response = new ViewResponse('login/register', $data);
										$response->addMessage(ViewMessage::error('Ce nom d\'utilisateur est déjà pris'));

										return $response;
									}
								}
								else {
									$response = new ViewResponse('login/register', $data);
									$response->addMessage(ViewMessage::error('Les mots de passe ne correspondent pas'));

									return $response;
								}
							}
							else {
								$response = new ViewResponse('login/register', $data);
								$response->addMessage(ViewMessage::error('Veuillez saisir des informations valides (a-z/A-Z/0-9)'));

								return $response;
							}
						}
						else {
							$response = new ViewResponse('login/register', $data);
							$response->addMessage(ViewMessage::error('L\'adresse e-mail est requise'));

							return $response;
						}
					}
					else {
						$response = new ViewResponse('login/register', $data);
						$response->addMessage(ViewMessage::error('Veuillez confirmer le mot de passe'));

						return $response;
					}
				}
				else {
					$response = new ViewResponse('login/register', $data);
					$response->addMessage(ViewMessage::error('Le mot de passe est requis'));

					return $response;
				}
			}
			else {
				$response = new ViewResponse('login/register', $data);
				$response->addMessage(ViewMessage::error('Le nom d\'utilisateur est requis'));

				return $response;
			}
		}
	}

	public function get($id, $request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}