<?php

class Register extends Controller {

	public function index() {
		if(!Session::isActive()) {
			$this->renderView('login/register');
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function postRequest($request) {
		$req = $request->getValues();

		if(isset($req['submitRegister'])) {
			if(isset($req['username'])) {
				if(isset($req['pass'])) {
					if(isset($req['pass-confirm'])) {
						if(isset($req['mail'])) {
							$this->loadModel('register_model');

							$username = Utils::secure($req['username']);
							$pass = Utils::secure($req['pass']);
							$pass2 = Utils::secure($req['pass-confirm']);
							$mail = Utils::secure($req['mail']);

							if($this->validateUser($username) && $this->validateMail($mail) && $pass2 != '' && $pass != '') {
								if($pass == $pass2) {
									if(!$this->model->userExists($username)) {
										if(!$this->model->mailRegistered($mail)) {
											$this->model->register($username, $pass, $mail);
											
											header('Location: '.WEBROOT.'login');
											exit();
										}
										else {
											$data = array();
											$data['error'] = 'Cette adresse e-mail est déjà occupée';
											$this->clearView();
											$this->renderView('login/register', $data);
										}
									}
									else {
										$data = array();
										$data['error'] = 'Ce nom d\'utilisateur est déjà pris';
										$this->clearView();
										$this->renderView('login/register', $data);
									}
								}
								else {
									$data = array();
									$data['error'] = 'Les mots de passe ne correspondent pas';
									$this->clearView();
									$this->renderView('login/register', $data);
								}
							}
							else {
								$data = array();
								$data['error'] = 'Veuillez saisir des informations valides (a-z/A-Z/0-9)';
								$this->clearView();
								$this->renderView('login/register', $data);
							}
						}
						else {
							$data = array();
							$data['error'] = 'L\'adresse e-mail est requise';
							$this->clearView();
							$this->renderView('login/register', $data);
						}
					}
					else {
						$data = array();
						$data['error'] = 'Veuillez confirmer le mot de passe';
						$this->clearView();
						$this->renderView('login/register', $data);
					}
				}
				else {
					$data = array();
					$data['error'] = 'Le mot de passe est requis';
					$this->clearView();
					$this->renderView('login/register', $data);
				}
			}
			else {
				$data = array();
				$data['error'] = 'Le nom d\'utilisateur est requis';
				$this->clearView();
				$this->renderView('login/register', $data);
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

}