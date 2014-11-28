<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';

class SearchController extends Controller {
	
	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function get($id, $request) {
		
		$q = urldecode($id);
		$data = array();
		$data['currentPageTitle'] = $q.' - Recherche';
		$data['search'] = $q;
		$data['videos'] = Video::getSearchVideos($q);
		$data['channels'] = UserChannel::getSearchChannels($q);
		
		$_SESSION["last_search"] = $q;
		if(empty($data['videos']) && empty($data['channels'])){
			
			$data['error']= array(
					"message" => "La recherche n'a retourné aucun resultat.",
					"level" => "error"
			);
			
			return new ViewResponse('search/error', $data);
		}
		return new ViewResponse('search/search', $data);
	}
	
	public function index($request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}
}