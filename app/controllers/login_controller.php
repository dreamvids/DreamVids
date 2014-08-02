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
		if(!Session::isActive()) {
			return new ViewResponse('login/login');
		}
		else {
			return new RedirectResponse(WEBROOT);
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
				$realPass = User::find_by_username($username)->getPassword();

				if(sha1($password) == $realPass) {
					if(isset($data['remember']))
						User::connect($username, 1);
					else
						User::connect($username, 0);

					return new RedirectResponse(WEBROOT);
				}
				else {
					$response = new ViewResponse('login/login', $_POST);
					$response->addMessage(ViewMessage::error('Mot de passe incorrect'));

					return $response;
				}
			}
			else {
				$response = new ViewResponse('login/login', $_POST);
				$response->addMessage(ViewMessage::error('Ce nom d\'utilisateur n\'existe pas'));

				return $response;
			}
		}
	}

	public function get($id, $request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}