<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

class AdminSettingsController extends Controller {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		return new ViewResponse('admin/settings/index');
	}
	
	public function users($id, $request) {
		$config = new Config(CONFIG.'app.json');
		$config->parseFile();
		$data = [];
		
		if($id && User::exists($id)){
			$data['user'] = User::find($id);
			
			$data['ranks'][$config->getValue('rankAdmin')] = 'Administrateur';
			$data['ranks'][$config->getValue('rankModo')] = 'Modérateur';
			$data['ranks'][$config->getValue('rankTeam')] = 'Equipe';
			
			return new ViewResponse('admin/settings/edit_user', $data);
		}
		
		$data['staff'] = ['admin'=>[null], 'modo'=>[null], 'team'=>[null]];
		$data['staff']['admin'] = User::find_by_rank($config->getValue('rankAdmin'));
		$data['staff']['modo'] = User::find_by_rank($config->getValue('rankModo'));
		$data['staff']['team'] = User::find_by_rank($config->getValue('rankTeam'));
		
		$data['rank_name'] = ['admin' => 'Administrateur', 'modo' => 'Modérateur', 'team' => 'Equipe'];
		$data['rank_color'] = ['admin' => 'danger', 'modo' => 'warning', 'team' => 'green'];
		
		foreach ($data['staff'] as $k => $v) {
			if(!is_array($v)){
				$data['staff'][$k] = [$v];
			}
		}

		return new ViewResponse('admin/settings/users', $data);
	}
	public function emergency($id, $request) {
		return new ViewResponse("admin/settings/emergency");
	}
	public function update($id, $request){

		$config = new Config(CONFIG.'app.json');
		$config->parseFile();
		
		$data = $request->getParameters();
		if(isset($data['userRankSubmit'])){
			if(User::exists($id)){
				$user = User::find($id);
				$data['ranks'][$config->getValue('rankAdmin')] = 'Administrateur';
				$data['ranks'][$config->getValue('rankModo')] = 'Modérateur';
				$data['ranks'][$config->getValue('rankTeam')] = 'Equipe';
				
				$user->rank = $data['rank'];
				$user->save();
				$data['user']= $user;
				$r = new ViewResponse("admin/settings/edit_user", $data);
				$r->addMessage(ViewMessage::success($user->username . " désormais {$data['ranks'][$user->rank]}"));
				return $r;
			}
				
		}
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function destroy($id, $request){}
}