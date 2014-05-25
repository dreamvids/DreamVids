<?php

class Account extends Controller {

	public function index() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			$data['email'] = Session::get()->email;
			$data['current'] = 'account';
			
			$this->renderView('account/profile', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function password() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			$data['current'] = 'password';

			$this->renderView('account/password', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function videos() {
		if(Session::isActive()) {
			$this->loadModel('account_model');
			
			$data['user'] = Session::get();
			$data['videos'] = $this->model->getVideosFromChannel(Session::get()->getMainChannel()->id);
			$data['current'] = 'videos';

			$this->renderView('account/videos', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function messages() {
		if(Session::isActive()) {
			$data['current'] = 'messages';
			$this->renderView('account/messages');
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function postRequest($request) {
		if(is_object($request)) {
			$this->loadModel('account_model');
			$req = $request->getValues();

			if(isset($req['profileSubmit']) && Session::isActive()) {

				$currentMail = $this->model->getUserMail(Session::get()->id);
				$currentUsername = Session::get()->username;
				$data = $req;
				$data['current'] = 'account';

				if(isset($req['email']) && $req['email'] != $currentMail) {
					$newMail = Utils::secure($req['email']);

					if($this->validateMail($newMail)) {
						$this->model->setMail(Session::get()->id, $newMail);
					}
					else {
						$this->renderViewWithError('L\'adresse E-Mail n\'est pas valide', 'account/password', $data);
						return;
					}
				}

				/*if(isset($req['username']) && $req['username'] != $currentUsername) {
					$newUsername = Utils::secure($req['username']);

					if($this->validateUser($newUsername)) {
						$this->model->setUsername(Session::get()->id, $newUsername);
					}
					else {
						$this->renderViewWithError('Le nom d\'utilisateur n\'est pas valide', 'account/profile', $data);
						return;
					}
				}

				if(isset($_FILES['avatarFile']) && $_FILES['avatarFile']['size'] != 0) {
					$username = Session::get()->username;

					if(!file_exists('uploads/')) {
						mkdir('uploads/');
					}
					if(!file_exists('uploads/'.$username)) {
						mkdir('uploads/'.$username);
					}

					$name = $_FILES['avatarFile']['name'];
					$exp = explode('.', $name);
					$ext = $exp[count($exp)-1];
					$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
					$path = 'uploads/'.$username.'/avatar.'.$ext;

					if(in_array(strtolower($ext), $acceptedExts)) {
						if(move_uploaded_file($_FILES['avatarFile']['tmp_name'], ROOT.$path)) {
							$this->model->setUserAvatar(Session::get()->id, $path);
						}
						else {
							$this->renderViewWithError('Erreur inconnue lors du déplacement du fichier. Contactez un administrateur.', 'account/profile', $data);
							return;
						}
					}
					else {
						$this->renderViewWithError('Veuillez choisir un fichier de type jpeg, jpg, png, gif, tiff, svg.', 'account/profile', $data);
						return;
					}
				}

				if(isset($_FILES['channelBgFile']) && $_FILES['channelBgFile']['size'] != 0) {
					$username = Session::get()->username;
					
					if(!file_exists('uploads/')) {
						mkdir('uploads/');
					}
					if(!file_exists('uploads/'.$username)) {
						mkdir('uploads/'.$username);
					}

					$name = $_FILES['channelBgFile']['name'];
					$exp = explode('.', $name);
					$ext = $exp[count($exp)-1];
					$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
					$path = 'uploads/'.$username.'/background.'.$ext;

					if(in_array(strtolower($ext), $acceptedExts)) {
						if(move_uploaded_file($_FILES['channelBgFile']['tmp_name'], ROOT.$path)) {
							$this->model->setUserBackground(Session::get()->id, $path);
						}
						else {
							$this->renderViewWithError('Erreur inconnue lors du déplacement du fichier. Contactez un administrateur.', 'account/profile', $data);
							return;
						}
					}
					else {
						$this->renderViewWithError('Veuillez choisir un fichier de type jpeg, jpg, png, gif, tiff, svg', 'account/profile', $data);
						return;
					}
				}*/

				$this->renderViewWithSuccess('Préférences enregistrées !', 'account/profile', $data);
			}

			if(isset($req['passwordSubmit']) && Session::isActive()) {
				if(isset($req['newPass']) && isset($req['newPassConfirm']) && isset($req['currentPass'])) {
					if($req['newPass'] == $req['newPassConfirm']) {
						$currentPass = sha1($req['currentPass']);
						$newPass = sha1($req['newPass']);
						$data = $req;
						$data['current'] = 'password';
						
						if($currentPass == Session::get()->pass) {
							$this->model->setPassword(Session::get()->id, $newPass);

							$this->renderViewWithSuccess('Préférences enregistrées !', 'account/password', $data);
						}
						else {
							$this->renderViewWithError('Le mot de passe actuel n\'est pas valide', 'account/password', $data);
							return;
						}
					}
					else {
						$this->renderViewWithError('Les mots de passe ne sont pas identiques', 'account/password', $data);
						return;
					}
				}
			}

			if(isset($req['avatarSubmit']) && Session::isActive()) {
				
			}

			if(isset($req['backgroundSubmit']) && Session::isActive()) {
				
			}
		}
	}

	private function validateUser($string='') {
		if($string != '') {
			if(!preg_match('/[^0-9A-Za-z]/',$string)) return true;
		}

		return false;
	}

	private function validateMail($string='') {
		if($string != '') {
			if(filter_var($string, FILTER_VALIDATE_EMAIL)) return true;
		}

		return false;
	}

	/*private function renderViewWithError($error) {
		$data = array();
		$data['user'] = Session::get();
		$data['username'] = Session::get()->username;
		$data['mail'] = Session::get()->email;
		$data['avatarPath'] = Session::get()->avatar != '' ? Session::get()->avatar : 'https://fr.gravatar.com/userimage/57826048/c82ae77d5ac9635e8ace8071f81941b9.png?size=100';
		$data['bgPath'] = Session::get()->background != '' ? Session::get()->background : 'http://dreamvids.fr/uploads/Dimou/background.JPG';
		$data['error'] = $error;
		$this->clearView();
		$this->renderView('account/profile', $data);
	}

	private function renderViewWithSuccess($success) {
		$data = array();
		$data['user'] = Session::get();
		$data['username'] = Session::get()->username;
		$data['mail'] = Session::get()->email;
		$data['avatarPath'] = Session::get()->avatar != '' ? Session::get()->avatar : 'https://fr.gravatar.com/userimage/57826048/c82ae77d5ac9635e8ace8071f81941b9.png?size=100';
		$data['bgPath'] = Session::get()->background != '' ? Session::get()->background : 'http://dreamvids.fr/uploads/Dimou/background.JPG';
		$data['success'] = $success;
		$this->clearView();
		$this->renderView('account/profile', $data);
	}*/

}