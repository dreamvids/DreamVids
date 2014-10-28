<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'user_channel.php';

class AccountController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		return $this->infos($request);
	}

	public function update($id, $request) {
		if(!Session::isActive()) {
			return new RedirectResponse(WEBROOT.'login');
		}

		$req = $request->getParameters();
		$data = $req;
		$data['current'] = 'account';
		$data['email'] = Session::get()->email;
		$data['currentPageTitle'] = 'Mon compte';

		if($id == 'infos') {
			if(isset($req['profileSubmit']) && Session::isActive()) {
				$user = Session::get();
				$currentMail = Session::get()->email;
				$currentUsername = Session::get()->username;

				if(isset($req['email']) && $req['email'] != $currentMail) {
					$newMail = Utils::secure($req['email']);

					if(Utils::validateMail($newMail)) {
						$user->email = $newMail;
						$user->save();
						$data['email'] = $newMail;
					}
					else {
						$response = new ViewResponse('account/profile', $data);
						$response->addMessage(ViewMessage::error('L\'adresse E-Mail n\'est pas valide'));

						return $response;
					}
				}
			
				if (isset($req['username']) && $req['username'] != $currentUsername) {
					$newUsername = Utils::secure($req['username']);
					
					if (Utils::validateUsername($newUsername)) {
						$channel = Session::get()->getMainChannel();
						$user->username = $newUsername;
						$user->save();
						$channel->name = $newUsername;
						$channel->save();
						$data['username'] = $newUsername;
					}
					else {
						$response = new ViewResponse('account/profile', $data);
						$response->addMessage(ViewMessage::error('Le nom d\'utilisateur doit contenir uniquement des lettres, des chiffres, des points, des traits d\'union et des _ et doit être compris entre 3 et 40 caractères.'));
					
						return $response;
					}
				}
					
				$response = new ViewResponse('account/profile', $data);
				$response->addMessage(ViewMessage::success('Préférences enregistrées !'));

				return $response;
			}
		}

		if($id == 'password') {
			if(isset($req['passwordSubmit']) && Session::isActive()) {
				if(isset($req['newPass']) && isset($req['newPassConfirm']) && isset($req['currentPass'])) {
					if($req['newPass'] == $req['newPassConfirm']) {
						$currentPass = sha1($req['currentPass']);
						$newPass = sha1($req['newPass']);
						$data = $req;
						$data['current'] = 'password';
						
						if($currentPass == Session::get()->pass) {
							Session::get()->setPassword($newPass);

							$response = new ViewResponse('account/password', $data);
							$response->addMessage(ViewMessage::success('Préférences enregistrées !'));

							return $response;
						}
						else {
							$response = new ViewResponse('account/password', $data);
							$response->addMessage(ViewMessage::error('Le mot de passe actuel est erroné'));

							return $response;
						}
					}
					else {
						$response = new ViewResponse('account/password', $data);
						$response->addMessage(ViewMessage::error('Les mots de passe ne sont pas identiques'));

						return $response;
					}
				}
			}
		}
		else
			return new ViewResponse('account/profile', $data);
	}

	public function infos($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['currentPageTitle'] = 'Mon compte';
			$data['username'] = Session::get()->username;
			$data['email'] = Session::get()->email;
			$data['settings'] = Session::get()->getSettings();
			$data['current'] = 'account';
			
			return new ViewResponse('account/profile', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function password($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['currentPageTitle'] = 'Mon compte';
			$data['username'] = Session::get()->username;
			$data['current'] = 'password';

			return new ViewResponse('account/password', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}
	
	public function channelslist($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['currentPageTitle'] = 'Mon compte';
			$data['channel'] = Session::get()->getOwnedChannels();
			$data['videos_count'] = array();
			foreach($data['channel'] as $chan) {
				$data['videos_count'][$chan->id] = Video::count(array('conditions' => array('poster_id = ?', $chan->id)));
			}
			$data['current'] = 'videos';
			
			$response = new ViewResponse('account/channels_videos', $data);
			if (empty($data['channel'])) {
				$response->addMessage(ViewMessage::error('Vous n\'avez aucune chaîne'));
			}
			return $response;
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}

	public function videos($id, $request) {
		if(Session::isActive()) {
			$data['videos'] = UserChannel::find($id)->getPostedVideos();
			$data['currentPageTitle'] = 'Mon compte';
			$data['current'] = 'videos';
			
			$response = new ViewResponse('account/videos', $data);
			if (empty($data['videos'])) {
				$response->addMessage(ViewMessage::error('Vous n\'avez posté aucune vidéo'));
			}
			return $response;
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}

	public function messages($request) {
		if(Session::isActive()) {
			$data = array();
			$data['current'] = 'messages';
			$data['currentPageTitle'] = 'Mon compte';

			$data['channels'] = Session::get()->getOwnedChannels();

			return new ViewResponse('account/messages', $data);
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}

	public function channels($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['currentPageTitle'] = 'Mon compte';
			$data['channels'] = Session::get()->getOwnedChannels();
			$data['current'] = 'channels';

			return new ViewResponse('account/channels', $data);
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}

	public function get($id, $request) {}
	public function create($request) {}
	public function destroy($id, $request) {}

}