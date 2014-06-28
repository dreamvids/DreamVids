<?php

class Channels extends Controller {

	private $channelId = 'lolnop'; // used to know which channel to edit on POST request
	
	public function index() {
		if(Session::isActive()) {
			$this->loadModel('channels_model');
			$data['user'] = Session::get();
			$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);
			$data['current'] = 'channels';
			$this->renderView('channels/list', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}
	
	public function add() {
		$data['current'] = 'channels';
		$this->renderView('channels/add');
	}

	public function edit($channelId = 'nope') {
		$this->loadModel('channels_model');

		if($channelId != 'nope' && UserChannel::exists(array('id' => $channelId))) {
			$channel = $this->model->getChannelById($channelId);
			$this->channelId = $channelId;

			$data['current'] = 'channels';
			$data['mainChannel'] = UserChannel::find($channelId)->isUsersMainChannel(Session::get()->id);
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['avatar'] = $channel->avatar;
			$data['banner'] = $channel->banner;
			$data['background'] = $channel->background;
			
			$this->renderView('channels/edit', $data);
		}
	}
	
	public function postRequest($request) {
		$this->loadModel('channels_model');
		$req = $request->getValues();
		$data = $req;
		$data['current'] = 'channels';
		$name = Utils::secure($req['name']);
		$descr = Utils::secure($req['description']);
		
		if(isset($req['createChannelSubmit']) && Session::isActive()) {
			if (isset($req['name'], $req['description'])) {
				if (strlen($name) >= 3 && strlen($name) <= 40) {
					if (preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if ($this->model->isChannelNameFree($name)) {
							$this->model->addChannel($name, $descr, '', '', '');
							$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);
							$this->renderViewWithSuccess('Votre nouvelle chaîne a bien été créée ! Faites-en bon usage !', 'channels/list', $data);
						}
						else {
							$this->renderViewWithError('Ce nom de chaine est déjà utilisé.', 'channels/add', $data);
						}
					}
					else {
						$this->renderViewWithError('Le nom de la chaîne doit contenir uniquement des lettres (majuscules et minuscules), des traits-d\'union, des _ et des points.', 'channels/add', $data);
					}
				}
				else {
					$this->renderViewWithError('Le nom de la chaîne doit être compris entre 3 et 40 caractères.', 'channels/add', $data);
				}
			}
			else
			{
				$this->renderViewWithError('Tous les champs doivent être remplis.', 'channels/add', $data);
			}
		}

		if(isset($req['editChannelSubmit']) && Session::isActive() && $this->channelId != 'lolnop') {
			if (isset($req['name'], $req['description'])) {
				if (strlen($name) >= 3 && strlen($name) <= 40) {
					if (preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if($this->model->isUserMainChannel(Session::get()->username, $this->channelId) && $this->model->getChannelName($this->channelId) != $req['name']) {
							$data['name'] = $this->model->getChannelName($this->channelId);

							$this->renderViewWithError('Vous ne pouvez pas changer le nom de votre chaîne principale !', 'channels/edit', $data);
							return;
						}

						$this->model->editChannel($this->channelId, $name, $descr, '', '', '');
						$data['channels'] = $this->model->getChannelsOwnedByUser(Session::get()->id);
						$this->renderViewWithSuccess('Votre nouvelle chaîne a bien été modifiée !', 'channels/list', $data);
					}
					else {
						$this->renderViewWithError('Le nom de la chaîne doit contenir uniquement des lettres (majuscules et minuscules), des traits-d\'union, des _ et des points.', 'channels/edit', $data);
					}
				}
				else {
					$this->renderViewWithError('Le nom de la chaîne doit être compris entre 3 et 40 caractères.', 'channels/edit', $data);
				}
			}
			else
			{
				$this->renderViewWithError('Tous les champs doivent être remplis.', 'channels/edit', $data);
			}
		}
	}
	
}