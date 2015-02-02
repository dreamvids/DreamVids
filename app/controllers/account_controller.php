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
			return new RedirectResponse(Utils::generateLoginURL());
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
					
					if (Utils::validateUsername($newUsername) && !User::exists(array('username' => $newUsername))) {
						$channel = Session::get()->getMainChannel();
						$user->username = $newUsername;
						$user->save();
						$channel->name = $newUsername;
						$channel->save();
						$data['username'] = $newUsername;
					}
					else {
						$response = new ViewResponse('account/profile', $data);
						$response->addMessage(ViewMessage::error('Le nom d\'utilisateur doit être disponible, contenir uniquement des lettres, des chiffres, des points, des traits d\'union et des _ et doit être compris entre 3 et 40 caractères.'));
					
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
						$currentPass = $req['currentPass'];
						$newPass = $req['newPass'];
						$data = $req;
						$data['current'] = 'password';

						if(password_verify($currentPass, Session::get()->pass)) {
							Session::get()->setPassword(password_hash($newPass, PASSWORD_BCRYPT));

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
		
		if($id == 'volume'){
			$data = $req;
			Session::get()->setSoundSetting($data["volume"]);
			return new Response(200);
		}
		if($id == 'definition'){
			$data = $req;
			Session::get()->setDefinitionSetting($data["definition"]);
			return new Response(200);
		}
		if($id == 'notifications'){
			$data = $request->getParameters();
			$data['current'] = 'notifications';
			Session::get()->setNotificationSettings($data);
			$data = array_merge($data, Session::get()->getNotificationSettings());
			$response = new ViewResponse('account/notifications', $data);
			$response->addMessage(ViewMessage::success("Paramètres de notifications sauvegardés"));
			return $response;
		}
		if($id == 'language'){
			
			$data['currentPageTitle'] = "Paramètre de langues";
			$data['current'] = 'language';
			
			Session::get()->setLanguageSetting($req['language']);
		
			$data['settings'] = Session::get()->getSettings();
			$data['avaiable_languages'] = Translator::getLanguagesList();
			$data['lang_setting'] = Session::get()->getLanguageSetting();
			
			return new RedirectResponse('account/language', $data);
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
			return new RedirectResponse(Utils::generateLoginURL());
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
			header('Location: ' . Utils::generateLoginURL());
			exit();
		}
	}
	
	public function channelslist($request) {
		if(Session::isActive()) {
			if (count(Session::get()->getOwnedChannels()) > 1) {
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
				return new RedirectResponse(WEBROOT.'account/videos/'.Session::get()->getMainChannel()->id);
			}
		}
		else {
			return new RedirectResponse(Utils::generateLoginURL());
		}
	}

	public function videos($id, $request) {
		if(Session::isActive()) {
			$data['videos'] = UserChannel::find($id)->getPostedVideos(0);
			$data['currentPageTitle'] = 'Mon compte';
			$data['current'] = 'videos';
			
			$response = new ViewResponse('account/videos', $data);
			if (empty($data['videos'])) {
				$response->addMessage(ViewMessage::error('Vous n\'avez posté aucune vidéo'));
			}
			return $response;
		}
		else {
			return new RedirectResponse(Utils::generateLoginURL());
		}
	}

	public function messages($param1, $param2='nope') {
		if ($param2 != 'nope') {
			$id = $param1;
			$request = $param2;
		}
		else {
			$request = $param1;
		}
		
		if(Session::isActive()) {
			$data = array();
			if (isset($id)) {
				$data['pre_load'] = $id;
			}
			$data['current'] = 'messages';
			$data['currentPageTitle'] = 'Mon compte';

			$data['channels'] = Session::get()->getOwnedChannels();
			Session::get()->last_visit = Utils::tps();
			Session::get()->save();
			return new ViewResponse('account/messages', $data);
		}
		else {
			return new RedirectResponse(Utils::generateLoginURL());
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
			return new RedirectResponse(Utils::generateLoginURL());
		}
	}
	
	public function notifications($request) {
		if(Session::isActive()) {
			$data['currentPageTitle'] = 'Paramètre de notifications';
			$data['settings'] = Session::get()->getSettings();
			$data['current'] = 'notifications';
			
			$data = array_merge($data, Session::get()->getNotificationSettings());
				
			return new ViewResponse('account/notifications', $data);
		}
		else
			return new RedirectResponse(Utils::generateLoginURL());
	}
	
	public function language($request) {
		if(Session::isActive()){
			$data['currentPageTitle'] = "Paramètre de langues";
			$data['settings'] = Session::get()->getSettings();
			$data['current'] = 'language';
			
			$data['avaiable_languages'] = Translator::getLanguagesList();
			$data['lang_setting'] = Session::get()->getLanguageSetting();
			return new ViewResponse('account/language', $data);
		}
		else{
			return RedirectResponse(WEBROOT.'login');
		}
	}

	public function get($id, $request) {}
	public function create($request) {}
	public function destroy($id, $request) {}

}
