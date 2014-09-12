<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';

class PageController extends Controller {
	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function get($id, $request) {
		if (file_exists(ROOT.'app/views/pages/'.$id.'.php')) {
			return new ViewResponse('pages/'.$id);
		}
		else {
			return Utils::getNotFoundResponse();
		}
	}
	
	public function index($request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}