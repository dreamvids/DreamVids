<?php

class Account extends Controller {

	public function index() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			
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
			$data['videos'] = $this->model->getVideosFromUser(Session::get()->id);

			$this->renderView('account/videos', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function channels() {
		if(Session::isActive()) {
			$this->loadModel('account_model');
			
			$data['user'] = Session::get();
			$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);

			$this->renderView('account/channels', $data);
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

				if(isset($req['email']) && $req['email'] != $currentMail) {
					$newMail = $req['email'];

					if($this->validateMail($newMail)) {
						$this->model->setMail(Session::get()->id, $newMail);

						$this->renderViewWithSuccess('Préférences enregistrées !');
					}
					else {
						$this->renderViewWithError('Le mot de pass actuel n\'est pas valide');
					}
				}

				if(isset($req['username']) && $req['username'] != $currentUsername) {
					$newUsername = $req['username'];

					if($this->validateUser($newUsername)) {
						$this->model->setUsername(Session::get()->id, $newUsername);

						$this->renderViewWithSuccess('Préférences enregistrées !');
					}
					else {
						$this->renderViewWithError('Le nom d\'utilisateur n\'est pas valide');
					}
				}

				if(isset($_FILES['avatarFile'])) {

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
							$this->model->setUserAvatar(Session::get()->id, ROOT.$path);

							$this->renderViewWithSuccess('Préférences enregistrées !');
						}
						else {
							$this->renderViewWithError('Erreur inconnue lors du déplacement du fichier. Contactez un administrateur.');
						}
					}
					else {
						$this->renderViewWithError('Veuillez choisir un fichier de type jpeg, jpg, png, gif, tiff, svg');
					}
				}

				if(isset($_FILES['channelBgFile'])) {
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
							$this->model->setUserBackground(Session::get()->id, ROOT.$path);

							$this->renderViewWithSuccess('Préférences enregistrées !');
						}
						else {
							$this->renderViewWithError('Erreur inconnue lors du déplacement du fichier. Contactez un administrateur.');
						}
					}
					else {
						$this->renderViewWithError('Veuillez choisir un fichier de type jpeg, jpg, png, gif, tiff, svg');
					}
				}
			}

			if(isset($req['passwordSubmit']) && Session::isActive()) {
				if(isset($req['newPass']) && isset($req['newPassConfirm']) && isset($req['currentPass'])) {
					if($req['newPass'] == $req['newPassConfirm']) {
						$currentPass = sha1($req['currentPass']);
						$newPass = sha1($req['newPass']);

						if($currentPass == Session::get()->pass) {
							$this->model->setPassword(Session::get()->id, $newPass);

							$this->renderViewWithSuccess('Préférences enregistrées !');
						}
						else {
							$this->renderViewWithError('Le mot de pass actuel n\'est pas valide');
						}
					}
					else {
						$this->renderViewWithError('Les mots de passe ne sont pas identiques');
					}
				}
			}

			if(isset($req['avatarSubmit']) && Session::isActive()) {
				
			}

			if(isset($req['backgroundSubmit']) && Session::isActive()) {
				
			}

			if(isset($req['createChannelSubmit']) && Session::isActive()) {
				
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

	private function renderViewWithError($error) {
		$data = array();
		$data['user'] = Session::get();
		$data['username'] = Session::get()->username;
		$data['error'] = $error;
		$this->clearView();
		$this->renderView('account/profile', $data);
	}

	private function renderViewWithSuccess($success) {
		$data = array();
		$data['user'] = Session::get();
		$data['username'] = Session::get()->username;
		$data['success'] = $success;
		$this->clearView();
		$this->renderView('account/profile', $data);
	}

}