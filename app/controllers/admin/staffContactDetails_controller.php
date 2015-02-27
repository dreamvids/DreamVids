<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'staff_contact.php';
require_once MODEL.'comment.php';


class AdminStaffContactDetailsController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Method::DELETE);
		$this->denyAction(Method::GET);
		$this->denyAction(Method::POST);
	}
	
	public function index($request) {
		$data = [];
		$conf = new Config(CONFIG . 'app.json');
		$conf->parseFile();
		$ranks = ['rankTeam', 'rankModo', 'rankAdmin'];
		
		foreach ($ranks as $k => $rank) {
			$ranks[$k] = $conf->getValue($rank);
		}

		$ranks_str = implode(' ,', $ranks);
		
		$data['infos'] = User::find('all',['conditions' => "rank in ($ranks_str)", 'order' => 'id=' . Session::get()->id. ' DESC']);
		
		return new ViewResponse('admin/staffContactDetails/index', $data);
	}
	
	public function edit($user_id){
		if(User::exists($user_id)){
			$data = ['user' => User::find($user_id)];
			if($data['user']->getStaffDetails()){
				$temp = $data['user']->details;
				$temp = Utils::secureActiveRecordModel($temp);				
			}
		}else{
			return new RedirectResponse(WEBROOT . 'admin/staffContactDetails');
		}
		return new ViewResponse("admin/staffContactDetails/edit", $data);
	}
	
	public function update($id, $request){ 
		if(Session::get()->id != $id){
			return $this->index($request);
		}
		
		if(StaffContact::exists(['user_id' => $id])){
			$infos = Session::get()->details;
			$param = $request->getParameters();
			$infos->tel_1 = $param['tel_1'];
			$infos->tel_2 = $param['tel_2'];
			$infos->email = $param['email'];
			$infos->push_bullet_email = $param['push_bullet_email'];

			$infos->save();
			return $this->edit($id);
		}else{
			return $this->create($request);
		}
		
	}

	public function create($request){
		
		$param = $request->getParameters();
		
		$detail = StaffContact::create([
			'user_id' => Session::get()->id,
			'tel_1' => $param['tel_1'],
			'tel_2' => $param['tel_2'],
			'email' => $param['email'],
			'push_bullet_email' => $param['push_bullet_email']
		]);
		return $this->edit($detail->user_id);
	}
	public function destroy($id, $request){ }
	public function get($id, $request){ }
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['team_or_more'];
	}
}
