<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'view_message.php';

class AdminUserController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		$data = [];
		$data['users'] = User::find('all');
		return new ViewResponse('admin/user/index', $data);
	}
	public function edit($id, $request) {
		$data = [];
		
		if(User::exists(['id' => $id])){
			$data['user'] = User::find($id);
			$r = new ViewResponse("admin/user/edit", $data);
		}else{
			$r = new ViewResponse("admin/user/edit");
			$r->addMessage(ViewMessage::error("L'utilisateur n'existe pas."));
		}
		return $r;
	}
	public function get($id, $request){
		
		return new RedirectResponse(WEBROOT . "admin/user/edit/$id");
		
	}
	public function create($request){
		echo 1;
	}
	public function update($id, $request) {
		$config = new Config(CONFIG.'app.json');
		$config->parseFile();
		
		$data = $request->getParameters();
	
		if(isset($data['userSubmit'])){
			
			$deny_fields = ['id', 'rank'];
			if (User::exists($id)) {
				$user = User::find($id);
				foreach ($data as $k => $value) {
					if(isset($user->$k) && !in_array($k, $deny_fields)){
						switch ($k) {
							case 'username':
								$u_c = $user->getMainChannel();
								$u_c->name = $value;
								$u_c->save();
							break;
							case 'pass':
								$value = !empty($value) ? password_hash($value, PASSWORD_BCRYPT) : $user->pass;
							break;
						}
						
						$user->$k = $value;
					}
					$user->save();
				}
				$r = new ViewResponse("admin/user/edit", ['user' => $user]);
				
			}
			return $r;
		}
	}
	public function destroy($id, $request){}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['modo_or_more'];
	}
	
}