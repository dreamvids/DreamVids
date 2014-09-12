<?php
/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';

require_once MODEL.'bug.php';

class BugController extends Controller {

	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function create($request) {
		$req = $request->getParameters();
		if (!empty($req['bug']) && !empty($req['url'])) {
			Bug::create(array(
				'username' => Session::get()->username,
				'description' => $req['bug'],
				'url' => $req['url'],
				'ip' => $_SERVER['REMOTE_ADDR']
			));
			return new Response(200);
		}
		else {
			return new Response(500);
		}
	}

	public function index($request){}
	public function get($id, $request){}
	public function update($id, $request){}
	public function destroy($id, $request){}

}
/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */