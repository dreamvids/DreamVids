<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'json_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'user_channel.php';
require MODEL.'live_access.php';

class LiveController extends Controller {

	public function __construct() {
		
	}

	public function index($request) {
		if(Session::isActive()) {
			$data = array();
			$data['currentPage'] = 'live';
			$data['currentPageTitle'] = 'Mes lives';

			if(LiveAccess::grantedForUser(Session::get())) {
				$data['accessGranted'] = true;
				$data['liveAccesses'] = LiveAccess::all(array('user_id' => Session::get()->id));
				$data['channels'] = Session::get()->getOwnedChannels();
			}
			else {
				$data['accessGranted'] = false;
				$data['channels'] = Session::get()->getOwnedChannels();
			}

			return new ViewResponse('live/create', $data);
		}
		else {
			return new RedirectResponse(Utils::generateLoginURL());
		}
	}

	public function get($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

		if($channel) {
			$access = LiveAccess::find(array('channel_id' => $channel->id));

			if(is_object($access)) {
				$data = array();
				$data['currentPage'] = 'live';

				$data['channel'] = $channel;
				$data['viewers'] = $access->viewers;
				$data['currentPageTitle'] = 'Live de '.$channel->name;
				$data['subscribers'] = $channel->subscribers;
				$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
				$data['onAir'] = is_object($access) ? $access->isOnline() : false;
				$data['liveKey'] = is_object($access) ? $access->key : '';
			}
			else {
				$data['channel'] = $channel;
				$data['viewers'] = 0;
				$data['currentPageTitle'] = 'Live de '.$channel->name;
				$data['subscribers'] = $channel->subscribers;
				$data['subscribed'] = Session::isActive() ? Session::get()->hasSubscribedToChannel($channel->id) : false;
				$data['onAir'] = false;
				$data['liveKey'] = '';
			}

			return new ViewResponse('channel/live', $data);
		}
		else {
			return Utils::getNotFoundResponse();
		}
	}

	public function create($request) {
		$params = $request->getParameters();

		if(Session::isActive()) {
			if(isset($params['channel-id']) && UserChannel::exists(Utils::secure($params['channel-id']))) {
				$channel = UserChannel::find(Utils::secure($params['channel-id']));

				if(!$channel->hasLiveAccess() && $channel->belongToUser(Session::get()->id)) {
					$access = LiveAccess::create(array(
						'channel_id' => $channel->id,
						'user_id' => Session::get()->id,
						'key' => hash_hmac('sha256', mt_rand(), mt_rand()),
						'timestamp' => time()
					));

					return new RedirectResponse(WEBROOT.'lives');
					exit();
					//return new JsonResponse(array('key' => $access->key, 'channel' => $channel->name, 'id' => $access->id));
				}
				else
					return new Response(500);
			}
			else
				return new Response(500);
		}
		else
			return Utils::getUnauthorizedResponse();
	}

	public function update($id, $request) {

	}

	public function destroy($id, $request) {
		if(Session::isActive()) {
			if($access = LiveAccess::find($id)) {
				$access->delete();
				return new Response(200);
			}
			else
				return new Response(404);
		}
		else
			return Utils::getUnauthorizedResponse();
	}
	
	public function viewers($id, $request) {
		if (UserChannel::exists($id)) {
			$channel_id = $id;
		}
		elseif (UserChannel::exists(array('name' => $id))) {
			$channel_id = UserChannel::find(array('name' => $id))->id;
		}
		else {
			return Utils::getNotFoundResponse();
		}
		
		return new JsonResponse(array(LiveAccess::find(array('channel_id' => $channel_id))->viewers));
	}

}
