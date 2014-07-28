<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';

require_once MODEL.'video.php';

class DiscoverController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		$data = array();
		$data['vids'] = Video::getDiscoverVideos();

		return new ViewResponse('discover/discover', $data);
	}

	// Denied actions
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}