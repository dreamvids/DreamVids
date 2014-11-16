<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'user_channel.php';

class ChannelController extends Controller {

	public function __construct() {
		$this->denyAction(Action::INDEX);
	}

	public function get($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

		if(!is_object($channel))
			return Utils::getNotFoundResponse();

		if($request->acceptsJson()) {
			$channelData = array(
				'id' => $channel->id,
				'name' => $channel->name,
				'description' => $channel->description,
				'owner_id' => $channel->owner_id,
				'admins_ids' => $channel->admins_id,
				'avatar' => $channel->avatar,
				'background' => $channel->getBackground(),
				'subscribers' => $channel->subscribers,
				'views' => $channel->views,
				'total_views' => $channel->getAllViews(),
				'verified' => $channel->verified
			);

			return new JsonResponse($channelData);
		}
		else {
			$data = array();
			$data['currentPage'] = 'channel';
			$data['currentPageTitle'] = $channel->name;
			$data['current'] = 'videos';
			$data['id'] = $channel->id;
			$data['name'] = $channel->name;
			$data['avatar'] = $channel->getAvatar();
			$data['background'] = $channel->getBackground();
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['videos'] = $channel->getPostedVideos();
			$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
			$data['channelBelongsToUser'] = Session::isActive() ? $channel->belongToUser(Session::get()->id) : false;
			$data['total_views'] = $channel->getAllViews();
			$data['owner_id'] = $channel->owner_id;

			return new ViewResponse('channel/channel', $data);
		}

	}

	public function create($request) {
		$req = $request->getParameters();
		$data = $req;
		$data['current'] = 'channels';
		$name = @Utils::secure($req['name']);
		$descr = @Utils::secure($req['description']);
		
		if(isset($req['createChannelSubmit']) && Session::isActive()) {
			$data = array();
			$data['currentPageTitle'] = 'Créer une chaine';
			if(isset($req['name'], $req['description'])) {
				if(strlen($name) >= 3 && strlen($name) <= 40) {
					if(preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if(UserChannel::isNameFree($name)) {
							UserChannel::addNew($name, $descr, $req['_FILES_']['avatar'], $req['_FILES_']['background']);
							$data['channels'] = Session::get()->getOwnedChannels();
							$data['currentPageTitle'] = 'Mes chaines';
							$response = new ViewResponse('account/channels', $data);
							$response->addMessage(ViewMessage::success('Votre nouvelle chaîne a bien été créée ! Faites-en bon usage !'));

							return $response;
						}
						else {
							$response = new ViewResponse('channel/create', $data);
							$response->addMessage(ViewMessage::error('Ce nom de chaine est déjà utilisé.'));

							return $response;
						}
					}
					else {
						$response = new ViewResponse('channel/create', $data);
						$response->addMessage(ViewMessage::error('Le nom de la chaîne doit contenir uniquement des lettres (majuscules et minuscules), des traits-d\'union, des _ et des points.'));

						return $response;
					}
				}
				else {
					$response = new ViewResponse('channel/create', $data);
					$response->addMessage(ViewMessage::error('Le nom de la chaîne doit être compris entre 3 et 40 caractères.'));

					return $response;
				}
			}
			else {
				$response = new ViewResponse('channel/create', $data);
				$response->addMessage(ViewMessage::error('Tous les champs doivent être remplis.'));

				return $response;
			}
		}

		$response = new ViewResponse('channel/create', $data);
		return $response;
	}

	public function update($id, $request) {
		$req = $request->getParameters();
		$data = $req;
		$data['current'] = 'channels';
		$name = @$req['name'];
		$descr = @$req['description'];
		$admins = @json_decode($req['_admins']);
		
		if(isset($req['editChannelSubmit']) && Session::isActive()) {
			$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

			if(!is_object($channel))
				return Utils::getNotFoundResponse();
			if(!$channel->belongToUser(Session::get()->id))
				return Utils::getForbiddenResponse();

			$data['mainChannel'] = $channel->isUsersMainChannel(Session::get()->id);
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['currentPageTitle'] = $channel->name.' - Edition';
			$data['owner_id'] = $channel->owner_id;
			
			
			$admins_array_ids = explode(';', trim($channel->admins_ids, ';'));
			$data['admins_ids'] = $admins_array_ids;
			$data['admins'] = array();
			foreach ($admins_array_ids as $adm) {
				$data['admins'][] = User::find_by_id($adm)->getMainChannel();
			}
						
			if(isset($req['name'], $req['description'])) {
				if(strlen($name) >= 3 && strlen($name) <= 40) {
					if(preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if($channel->isUsersMainChannel(Session::get()->id)) {
							if ($channel->name != $req['name']) {
								$data['name'] = $channel->name;
								$response = new ViewResponse('channel/edit', $data);
								$response->addMessage(ViewMessage::error('Vous ne pouvez pas changer le nom de votre chaîne principale !'));
	
								return $response;
							}
						}
						else {
							$adm = trim($adm, ';');
							$adm = explode(';', $adm);
							foreach ($admins as $admin) {
								if ($admin > 0) {
									if (!in_array($admin, $adm)) {
										$adm[] = $admin;
										ChannelAction::create(array(
											'id' => ChannelAction::generateId(6),
											'channel_id' => $channel->id,
											'recipients_ids' => ';'.$admin.';',
											'type' => 'admin',
											'target' => $channel->id,
											'timestamp' => Utils::tps()
										));
									}
								}
								else {
									$value = -1 * $admin;
									if (in_array($value, $adm) && $channel->owner_id != $value) {
										$id = array_keys($adm, $value);
										unset($adm[$id[0]]);
										ChannelAction::create(array(
											'id' => ChannelAction::generateId(6),
											'channel_id' => $channel->id,
											'recipients_ids' => ';'.$admin.';',
											'type' => 'unadmin',
											'target' => $channel->id,
											'timestamp' => Utils::tps()
										));
									}
								}
							}
							$adm = ';'.implode(';', $adm).';';
						}
						
						UserChannel::edit($channel->id, $name, $descr, $adm, $req['_FILES_']['avatar'], $req['_FILES_']['background']); //TODO: Support logo/background
						$data['channels'] = Session::get()->getOwnedChannels();
						$data['currentPageTitle'] = 'Mes chaines';
						$response = new ViewResponse('account/channels', $data);
						$response->addMessage(ViewMessage::success('Votre chaîne '.$name.' a bien été modifiée !'));

						return $response;
					}
					else {
						$response = new ViewResponse('channel/edit', $data);
						$response->addMessage(ViewMessage::error('Le nom de la chaîne doit contenir uniquement des lettres (majuscules et minuscules), des traits-d\'union, des _ et des points.'));
// 						die(var_dump($data));	
						return $response;
					}
				}
				else {
					$response = new ViewResponse('channel/edit', $data);
					$response->addMessage(ViewMessage::error('Le nom de la chaîne doit être compris entre 3 et 40 caractères.'));

					return $response;
				}
			}
			else {
				$response = new ViewResponse('channel/edit', $data);
				$response->addMessage(ViewMessage::error('Tous les champs doivent être remplis.'));

				return $response;
			}
		}
		else if(isset($req['subscribe'])) {
			if(Session::isActive()) {
				$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

				if(is_object($channel) && !$channel->belongToUser(Session::get()->id)) {
					$channel->subscribe(Session::get()->id);

					$response = new Response(200);
					return $response;
				}
			}
			else {
				return new Response(500);
			}
		}
		else if(isset($req['unsubscribe'])) {
			if(Session::isActive()) {
				$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

				if(is_object($channel) && !$channel->belongToUser(Session::get()->id)) {
					$channel->unsubscribe(Session::get()->id);

					$response = new Response(200);
					return $response;
				}

			}
			else {
				return new Response(500);
			}
		}
			else if(isset($req['admin_edit'])){
				
	
					if(Session::isActive()){
						$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);
						if(!$channel){
							return Utils::getNotFoundResponse();
						}
						if(!$channel->isUsersMainChannel(Session::get()->id) && $channel->owner_id!=Session::get()->id){
							if(in_array($channel, Session::get()->getOwnedChannels())){
								$current_admins=$channel->admins_ids;
								$current_admins = trim($current_admins, ";");
								$current_admins = explode(";", $current_admins);
								foreach ($current_admins as $k => $admin){
									if($admin==Session::get()->id){
										unset($current_admins[$k]);
										$channel->admins_ids=";".implode($current_admins, ";").";";
										$channel->save();
										return new RedirectResponse(WEBROOT."channel/$id");
									}
								}
												
							}
						}
					}
					return Utils::getForbiddenResponse();
			}
	}

	public function destroy($id, $request) {
		$channel = UserChannel::find($id);
		if ($channel->owner_id == Session::get()->id && $channel->id != Session::get()->getMainChannel()->id) {
			$channel->delete();
			Video::delete_all(array('conditions' => 'poster_id = ?'), $channel->id);
			return new Response(200);
		}
		else {
			return new Response(500);
		}
	}

	// "GET /channel/:id/social"
	public function social($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find_by_id($id) : UserChannel::find_by_name($id);

		if(is_object($channel)) {
			$data = array();
			$data['currentPage'] = 'channel';
			$data['currentPageTitle'] = $channel->name.' - Social';
			$data['current'] = 'social';
			$data['id'] = $channel->id;
			$data['name'] = $channel->name;
			$data['avatar'] = $channel->getAvatar();
			$data['background'] = $channel->getBackground();
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
			$data['posts'] = $channel->getPostedMessages();
			$data['channelBelongsToUser'] = Session::isActive() ? $channel->belongToUser(Session::get()->id) : false;
			$data['total_views'] = $channel->getAllViews();
			$data['videos'] = $channel->getPostedVideos();
			$data['owner_id'] = $channel->owner_id;

			return new ViewResponse('channel/social', $data);
		}
		else
			return Utils::getNotFoundResponse();
	}
	
	public function playlists($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find_by_id($id) : UserChannel::find_by_name($id);

		if(is_object($channel)) {
			$data = array();
			$data['currentPage'] = 'channel';
			$data['currentPageTitle'] = $channel->name.' - Playlists';
			$data['current'] = 'playlists';
			$data['id'] = $channel->id;
			$data['name'] = $channel->name;
			$data['avatar'] = $channel->getAvatar();
			$data['background'] = $channel->getBackground();
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
			$data['playlists'] = Playlist::all(array('conditions' => array('channel_id = ?', $channel->id)));
			$data['channelBelongsToUser'] = Session::isActive() ? $channel->belongToUser(Session::get()->id) : false;
			$data['total_views'] = $channel->getAllViews();
			$data['videos'] = $channel->getPostedVideos();
			$data['owner_id'] = $channel->owner_id;

			return new ViewResponse('channel/playlists', $data);
		}
		else
			return Utils::getNotFoundResponse();
	}

	public function add($request) {
		if(Session::isActive()) {
			$data = array();
			$data['current'] = 'channels';
			$data['currentPageTitle'] = 'Créer une chaine';

			return new ViewResponse('channel/create', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	// Called by URL /channel/:id/edit
	public function edit($id, $request) {
		if(Session::isActive()) {
			$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);
			if(!$channel->belongToUser(Session::get()->id))
				return Utils::getForbiddenResponse();
			if(is_object($channel)) {
				$data = array();
				$data['currentPage'] = 'channel';
				$data['current'] = 'channels';
				$data['currentPageTitle'] = $channel->name.' - Edition';
				$data['id'] = $channel->id;
				$data['mainChannel'] = $channel->isUsersMainChannel(Session::get()->id);
				$data['owner_id'] = $channel->owner_id;
				$data['name'] = $channel->name;
				$data['description'] = $channel->description;
				$data['avatar'] = $channel->getAvatar();
				$data['background'] = $channel->getBackground();
				$admins = explode(';', trim($channel->admins_ids, ';'));
				$data['admins_ids'] = $admins;
				$data['admins'] = array();
				foreach ($admins as $adm) {
					$data['admins'][] = User::find_by_id($adm)->getMainChannel();
				}
								
				return new ViewResponse('channel/edit', $data);
			}
			else
				return Utils::getNotFoundResponse();
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function subscribe($id, $request) {
		
	}

	public function unsubscribe($id, $request) {
		
	}
	
	public function autocomplete($prefix, $request) {
		if (strlen($prefix) >= 3) {
			$channels = UserChannel::find_by_sql("SELECT * FROM users_channels WHERE name LIKE ?", array($prefix.'%'));
			$array = array();
			foreach ($channels as $chan) {
				$array[] = array(
					'user_id' => $chan->owner_id,
					'name' => $chan->name,
					'avatar' => $chan->avatar
				);
			}
			
			return new JsonResponse($array);
		}
		else {
			return new JsonResponse(array());
		}
	}

	public function index($request) {}

}
