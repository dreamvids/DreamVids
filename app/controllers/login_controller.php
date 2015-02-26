<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

class LoginController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
				
		$redirect = Utils::getRedirect();
		
		if(!Session::isActive()) {
			$data = array();
			$data['currentPageTitle'] = 'Connexion';
			$data['redirect'] = $redirect;
			return new ViewResponse('login/login', $data);
		}
		else {
			return new RedirectResponse($redirect ? $redirect : WEBROOT);
		}
	}

	public function signout() {
		User::logoutCurrent();
		return new RedirectResponse(WEBROOT);
	}

	// Called by a POST request
	public function create($request) {
		$data = $request->getParameters();

		if(isset($data['submitLogin']) && !Session::isActive()) {
			$username = Utils::secure($data['username']);
			$password = Utils::secure($data['pass']);

			if(User::find_by_username($username)) {
				
				$user = User::find_by_username($username);
				 
				$current_log_fail = $user->getLogFails();
				if(!$user->isAllowedToAttemptLogin()){
					

					$next_timestamp = $current_log_fail['next_try'];
					$last_try_timestamp = $current_log_fail['last_try'];
					$nb_try = $current_log_fail['nb_try'];
				
					$next_try_tps = $next_timestamp - Utils::tps();
					$next_try_min = floor($next_try_tps/60);
					$next_try_sec = round(($next_try_tps - $next_try_min*60));
					$next_try_str = "$next_try_min m et $next_try_sec s";
				
					$data = array();
					$data['currentPageTitle'] = 'Connexion';
					$response = new ViewResponse('login/login', $data);
					$response->addMessage(ViewMessage::error($nb_try . " de tentatives de connexions à la suite pour ce compte. Veuillez patienter $next_try_str"));
						
					return $response;
					
				}

				$realPass = User::find_by_username($username)->getPassword();

				if(password_verify($password, $realPass)) {
					User::connect($username, 1);
					
					$user->resetLogFails();
					
					return new RedirectResponse($data['redirect'] ? urldecode($data['redirect']) : WEBROOT );
				}
				else {
					if(sha1($password) == $realPass) {
						$user->resetLogFails();
						User::connect($username, 1)->setPassword(password_hash($password, PASSWORD_BCRYPT));
						
						return new RedirectResponse($data['redirect'] ? urldecode($data['redirect']) : WEBROOT );
					}
					
					if(!$user->isIntervalBetweenTwoLogAttemptElapsed() || !$current_log_fail){
						$user->addLogFail();						
					}else{
						$user->resetLogFails();
						$user->addLogFail();
					}
					$data = array();
					$data['currentPageTitle'] = 'Connexion';
					$response = new ViewResponse('login/login', $data);
					$response->addMessage(ViewMessage::error('Mot de passe incorrect'));

					return $response;
				}
			}
			else {
				$data = array();
				$data['currentPageTitle'] = 'Connexion';
				$response = new ViewResponse('login/login', $data);
				$response->addMessage(ViewMessage::error('Ce nom d\'utilisateur n\'existe pas'));

				return $response;
			}
		}
	}

	public function get($id, $request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}