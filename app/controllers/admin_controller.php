<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';

class AdminController extends Controller {
	public function index($request) {
		return $this->handleAdminRequest('index', $request);
	}
	
	public function get($id, $request) {
		return $this->handleAdminRequest('get', $id, $request);
	}
	
	public function create($request) {
		return $this->handleAdminRequest('create', $request);
	}
	
	public function update($id, $request) {
		return $this->handleAdminRequest('update', $id, $request);
	}
	
	public function destroy($id, $request) {
		return $this->handleAdminRequest('destroy', $id, $request);
	}
	
	public function __call($name , $args){
		if (isset($args[0], $args[1])) {
			return $this->handleAdminRequest($name, $args[0], $args[1]);
		}
		return $this->handleAdminRequest($name, '', $args[0]);
	}
	
	private function handleAdminRequest() {
		$user = Session::get();
		if($user === -1){
			return Utils::getForbiddenResponse();
		}
		if ($user->isTeam() || $user->isModerator() || $user->isAdmin()) {
			$argc = func_num_args();
			$argv = func_get_args();
			$uri = explode('/', Utils::getCurrentURI());
			$controller = (isset($uri[1]) && file_exists(CONTROLLER.'admin/'.$uri[1].'_controller.php')) ? trim($uri[1], '/') : 'home';
			require_once CONTROLLER.'admin/'.$controller.'_controller.php';
			$ctrl = 'Admin'.ucfirst($controller).'Controller';
			$ctrl = new $ctrl();
	
			switch ($argc) {
				case 2:
					$resp = $ctrl->$argv[0]($argv[1]);
				break;
				
				case 3:			
					if(method_exists($ctrl, $argv[0])){
						$resp = $ctrl->$argv[0]($argv[1], $argv[2]);						
					}else{
						$resp = $this->handleAdminRequest('get', $argv[0], $argv[1]);
					}
				break;
			}
			
			return $resp;
		}
		else {
			return Utils::getForbiddenResponse();
		}
	}
}

/*
 * Old code bellow
 * DO NOT REMOVE
 * This is the most important piece of code in the world
 * ...
 * Not really
 * Maybe
 * It's classified.
 * Obama :P
 */

/*require_once MODEL.'user_channel.php';
require_once MODEL.'video.php';

class AdminController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(!Session::isActive())
			return new RedirectResponse(WEBROOT.'login');

		return $this->dashboard($request);
	}

	public function dashboard($request) {
		if(Session::get()->isModerator() || Session::get()->isAdmin()) {
			$data = array();
			$data['currentPage'] = 'admin';

			$data['rankStr'] = Session::get()->isModerator() ? 'Moderateur' : 'Admin';
			$data['isModo'] = Session::get()->isModerator();
			$data['isAdmin'] = Session::get()->isAdmin();
			$data['user'] = Session::get();
			$data['reportedVidsCount'] = Video::count(array('conditions' => array('flagged', 1)));
			$data['reportedCommentsCount'] = 0; //TEMP

			return new ViewResponse('admin/dashboard', $data, true, 'layouts/admin.php');
		}
		else
			return Utils::getUnauthorizedResponse();
	}

	public function videos($request) {
		if(Session::get()->isModerator() || Session::get()->isAdmin()) {
			$data = array();
			$data['currentPage'] = 'admin';

			$data['rankStr'] = Session::get()->isModerator() ? 'Moderateur' : 'Admin';
			$data['isModo'] = Session::get()->isModerator();
			$data['isAdmin'] = Session::get()->isAdmin();

			$data['reportedVids'] = Video::getReportedVideos();

			return new ViewResponse('admin/videos', $data, true, 'layouts/admin.php');
		}
		else
			return Utils::getUnauthorizedResponse();
	}

	public function channels($request) {
		if(Session::get()->isModerator() || Session::get()->isAdmin()) {
			$data = array();
			$data['currentPage'] = 'admin';

			$page = $request->getParameter('p') ? Utils::secure($request->getParameter('p')) : 1;
			$channelNumber = UserChannel::count('all');

			$data['rankStr'] = Session::get()->isModerator() ? 'Moderateur' : 'Admin';
			$data['isModo'] = Session::get()->isModerator();
			$data['isAdmin'] = Session::get()->isAdmin();
			$data['user'] = Session::get();
			$data['channels'] = UserChannel::find('all');

			return new ViewResponse('admin/channels', $data, true, 'layouts/admin.php');
		}
		else
			return Utils::getUnauthorizedResponse();
	}

	public function comments($request) {
		if(Session::get()->isModerator() || Session::get()->isAdmin()) {
			$data = array();
			$data['currentPage'] = 'admin';

			$page = $request->getParameter('p') ? Utils::secure($request->getParameter('p')) : 1;
			$channelNumber = UserChannel::count('all');

			$data['rankStr'] = Session::get()->isModerator() ? 'Moderateur' : 'Admin';
			$data['isModo'] = Session::get()->isModerator();
			$data['isAdmin'] = Session::get()->isAdmin();
			$data['user'] = Session::get();
			$data['comments'] = Comment::getReportedComments();

			return new ViewResponse('admin/comments', $data, true, 'layouts/admin.php');
		}
		else
			return Utils::getUnauthorizedResponse();
	}

	// Denied actions
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}*/