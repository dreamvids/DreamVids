<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'user_channel.php';
require_once MODEL.'video.php';

class HomeController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(Session::isActive()) {
			$data = array();
			$data['currentPageTitle'] = 'Accueil';
			$channel = Session::get()->getMainChannel();

			$data['subscriptions'] = Session::get()->getSubscriptions();
			$data['subscriptions_vids'] = Video::getSubscriptionsVideos(Session::get()->id, 20);
			$data['discoverVids'] = Video::getDiscoverVideos(2);
			$data['bestVids'] = Video::getBestVideos(6);
			$data['channelId'] = $channel->id;
			$data['avatar'] = $channel->getAvatar();
			$data['background'] = $channel->getBackground();

			return new ViewResponse('home/logged', $data);
		}
		else {
			return new RedirectResponse(WEBROOT.'news');
		}
	}

	// Denied actions
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}
}