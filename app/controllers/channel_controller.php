<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'user_channel.php';

class ChannelController extends Controller {

	public function __construct() {
		$this->denyAction(Action::INDEX);
	}

	public function get($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

		if(!is_object($channel))
			return Utils::getNoutFoundResponse();

		$data = array();
		$data['id'] = $channel->id;
		$data['name'] = $channel->name;
		$data['description'] = $channel->description;
		$data['subscribers'] = $channel->subscribers;
		$data['videos'] = $channel->getPostedVideos();
		$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
		$data['channelBelongsToUser'] = Session::isActive() ? $channel->belongToUser(Session::get()->id) : false ;

		return new ViewResponse('channel/channel', $data);
	}

	public function create($request) {
		$req = $request->getParameters();
		$data = $req;
		$data['current'] = 'channels';
		$name = @Utils::secure($req['name']);
		$descr = @Utils::secure($req['description']);
		
		if(isset($req['createChannelSubmit']) && Session::isActive()) {
			if(isset($req['name'], $req['description'])) {
				if(strlen($name) >= 3 && strlen($name) <= 40) {
					if(preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if(UserChannel::isNameFree($name)) {
							UserChannel::addNew($name, $descr, '', '', '');
							$data['channels'] = Session::get()->getOwnedChannels();

							$response = new ViewResponse('accout/channel_list', $data);
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
		$name = @Utils::secure($req['name']);
		$descr = @Utils::secure($req['description']);

		if(isset($req['editChannelSubmit']) && Session::isActive()) {
			$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

			if(!is_object($channel))
				return Utils::getNotFoundResponse();
			if(!$channel->belongToUser(Session::get()->id))
				return Utils::getForbiddenResponse();

			$data['mainChannel'] = $channel->isUsersMainChannel(Session::get()->id);
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;

			if(isset($req['name'], $req['description'])) {
				if(strlen($name) >= 3 && strlen($name) <= 40) {
					if(preg_match("#^[a-zA-Z0-9\_\-\.]+$#", $name) ) {
						if($channel->isUsersMainChannel(Session::get()->id) && $channel->name != $req['name']) {
							$data['name'] = $channel->name;

							$response = new ViewResponse('channel/edit', $data);
							$response->addMessage(ViewMessage::error('Vous ne pouvez pas changer le nom de votre chaîne principale !'));

							return $response;
						}

						UserChannel::edit($channel->id, $name, $descr, '', '', ''); //TODO: Support logo/background/banner
						$data['channels'] = Session::get()->getOwnedChannels();

						$response = new ViewResponse('account/channels', $data);
						$response->addMessage(ViewMessage::success('Votre chaîne '.$name.' a bien été modifiée !'));

						return $response;
					}
					else {
						$response = new ViewResponse('channel/edit', $data);
						$response->addMessage(ViewMessage::error('Le nom de la chaîne doit contenir uniquement des lettres (majuscules et minuscules), des traits-d\'union, des _ et des points.'));

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
	}

	public function destroy($id, $request) {

	}

	// "GET /channel/:id/social"
	public function social($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find_by_id($id) : UserChannel::find_by_name($id);

		if(is_object($channel)) {
			$data = array();
			$data['id'] = $channel->id;
			$data['name'] = $channel->name;
			$data['description'] = $channel->description;
			$data['subscribers'] = $channel->subscribers;
			$data['videos'] = $channel->getPostedVideos();
			$data['subscribed'] = Session::get()->hasSubscribedToChannel($channel->id);
			$data['posts'] = $channel->getPostedMessages();
			$data['isUsersChannel'] = Session::isActive() ? $channel->belongToUser(Session::get()->id) : '';

			return new ViewResponse('channel/social', $data);
		}
		else
			return Utils::getNotFoundResponse();
	}

	public function add($request) {
		if(Session::isActive()) {
			$data = array();
			$data['current'] = 'channels';

			return new ViewResponse('channel/create', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	// Called by URL /channel/:id/edit
	public function edit($id, $request) {
		if(Session::isActive()) {
			$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

			if(is_object($channel)) {
				$data = array();
				$data['current'] = 'channels';

				$data['mainChannel'] = $channel->isUsersMainChannel(Session::get()->id);
				$data['name'] = $channel->name;
				$data['description'] = $channel->description;

				return new ViewResponse('channel/edit', $data);
			}
			else
				return Utils::getNotFoundResponse();
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function subscribe($id, $request) {
		var_dump($id);
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

	public function unsubscribe($id, $request) {
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

	public function index($request) {}

}