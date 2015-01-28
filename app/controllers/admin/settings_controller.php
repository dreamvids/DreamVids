<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

class AdminSettingsController extends AdminSubController {
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
			
			$data['ranks'][$config->getValue('rankAdmin')] = ['Administrateur', 'danger'];
			$data['ranks'][$config->getValue('rankModo')] = ['Modérateur', 'warning'];
			$data['ranks'][$config->getValue('rankTeam')] = ['Equipe', 'success'];
			$data['ranks'][$config->getValue('rankContributor')] = ['Contributeur', 'primary'];
			$data['ranks'][$config->getValue('rankUser')] = ['Utilisateur', 'info'];
			return new ViewResponse('admin/settings/edit_user', $data);
		}
		
		$data['staff'] = ['admin'=>[null], 'modo'=>[null], 'team'=>[null], 'contributor'=>[null]];
		
		
		
		$data['staff']['admin'] = User::find('all', ['rank' => $config->getValue('rankAdmin')]);
		$data['staff']['modo'] = User::find('all', ['rank' => $config->getValue('rankModo')]);
		$data['staff']['team'] = User::find('all', ['rank' => $config->getValue('rankTeam')]);
		$data['staff']['contributor'] = User::find('all', ['rank' => $config->getValue('rankContributor')]);
		
		$data['rank_name'] = ['admin' => 'Administrateur', 'modo' => 'Modérateur', 'team' => 'Equipe', 'contributor'=>'Contributeur'];
		$data['rank_color'] = ['admin' => 'red', 'modo' => 'yellow', 'team' => 'green', 'contributor' => 'primary'];
		
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
				$data['ranks'][$config->getValue('rankAdmin')] = ['Administrateur', 'danger'];
				$data['ranks'][$config->getValue('rankModo')] = ['Modérateur', 'warning'];
				$data['ranks'][$config->getValue('rankTeam')] = ['Equipe', 'success'];
				$data['ranks'][$config->getValue('rankContributor')] = ['Contributeur', 'info'];
				$data['ranks'][$config->getValue('rankUser')] = ['Utilisateur', 'primary'];
				
				$user->rank = $data['rank'];
				$user->save();
				$data['user']= $user;
				$r = new ViewResponse("admin/settings/edit_user", $data);
				$r->addMessage(ViewMessage::success($user->username . " désormais {$data['ranks'][$user->rank][0]}"));
				return $r;
			}
				
		}
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function destroy($id, $request){}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['admin'];
	}
}