<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

class AdminHomeController extends Controller {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		echo 'It works.';
		exit();
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}