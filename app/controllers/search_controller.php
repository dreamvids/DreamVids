<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';

class SearchController extends Controller {
	
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		$q = preg_replace('/^(.+)search(.+)q=/i', "", $_SERVER['REQUEST_URI']);
		$q = preg_replace('/&(.+)$/i', "", $q);
		$q = urldecode($q);
		$data['search'] = $q;
		$data['videos'] = Video::getSearchVideos($q);
		return new ViewResponse('search/search', $data);
	}
	
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}
}