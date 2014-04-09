<?php

class Channels extends Controller {
	
	public function index() {
		if(Session::isActive()) {
			$this->loadModel('channels_model');
			
			$data['user'] = Session::get();
			$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);
			$this->renderView('channels/list', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}
	
	public function add() {
		$this->renderView('channels/add');
	}
	
	public function postRequest($request) {
		$this->loadModel('channels_model');
		$req = $request->getValues();
		
		$name = Utils::secure($req['name']);
		$descr = Utils::secure($req['description']);
		
		if(isset($req['createChannelSubmit']) && Session::isActive()) {
			if (isset($req['name'], $req['description'])) {
				if (strlen($name) >= 3 && strlen($name) <= 40) {
					if ($this->model->isChannelNameFree($name)) {
						$this->model->addChannel($name, $descr);
						$this->renderViewWithSuccess('Votre nouvelle chaîne a bien été créée ! Faites-en bon usage ;o)', 'channels/list', $req);
					}
					else {
						$this->renderViewWithError('Ce nom de chaine est déjà utilisé.', 'channels/add', $req);
					}
				}
				else {
					$this->renderViewWithError('Le nom de la chaîne doit être compris entre 3 et 40 caractères.', 'channels/add', $req);
				}
			}
			else
			{
				$this->renderViewWithError('Tous les champs doivent être remplis.', 'channels/add', $req);
			}
		}
	}
	
	private function renderViewWithError($error, $view, $data) {
		foreach ($data as $key => $value) {
			$data[$key] = Utils::secure($value);
		}
		$data['error'] = $error;
		$this->clearView();
		$this->renderView($view, $data);
	}

	private function renderViewWithSuccess($success, $view, $data) {
		foreach ($data as $key => $value) {
			$data[$key] = Utils::secure($value);
		}
		$data['success'] = $success;
		$this->clearView();
		$this->renderView($view, $data);
	}
	
}