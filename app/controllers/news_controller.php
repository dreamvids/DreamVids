<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';

require_once MODEL.'video.php';
require_once MODEL.'live_access.php';

class NewsController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		$data = array();
		$data['currentPageTitle'] = 'Nouveautés';
		$data['vids'] = Video::getLastVideos(50);

		return new ViewResponse('news/news', $data);
	}
	
	public function lives($request) {
		$data = array();
		$data['lives'] = LiveAccess::getOnlines();
		
		return new ViewResponse('news/lives', $data);
	}

	// Denied actions
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}