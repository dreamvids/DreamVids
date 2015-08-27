<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

class AdminConversionController extends AdminSubController {
	public function __construct() {
		
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
	    
	 return new ViewResponse('admin/conversion/index');   
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
	
	public function progress($request){
	    Utils::streamCmdOutput('ping 8.8.8.8 -c 10 -i 0.5', true, 'test');
	}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['admin'];
	}
	
}