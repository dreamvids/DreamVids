<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'view_message.php';

class AdminEggController extends AdminSubController{
	public function __construct() {
	}
	public function get($id, $request){
		return $this->edit($id, $request);
	}
	
	public function index($request) {
		$data = [];
		$data['dv_eggs'] = Eggs::getDreamvidsEggs();
		$data['cavi_eggs'] = Eggs::getCaviconEggs();
		return new ViewResponse('admin/egg/index', $data);
	}
	
	public function add($site, $request){
		$data = ['site' => $site];
		switch ($site){
			case 'dreamvids' : $data['readable_site'] = 'Dreamvids';
			break;
			case 'cavicon' : $data['readable_site'] = 'CAVIcon';
			break;
			default : $data['readable_site'] = "[inconnu]";
		}
		return new ViewResponse('admin/egg/add', $data);
	}
	
	public function edit($id, $request){
		$data= [];
		if($id == '' || !Egg::exists(['id' => $id])) return new RedirectResponse(WEBROOT . 'admin/egg');
		
		$channel = UserChannel::find_by_id($id);
		$data['channel_admin']= User::find($channel->owner_id);
		$data['channel'] = $channel;
		
		return new ViewResponse('admin/egg/edit', $data);
	}
	public function update($id, $request){
		$data = $request->getParameters();
		$channel = UserChannel::find($id);
		
		$channel->verified = $data['verified'];
		$channel->description = $data['description'];
		$channel->save();
		$data['channel'] = $channel;
		$data['channel_admin']= User::find($channel->owner_id);
		$r = new ViewResponse('admin/egg/edit', $data);
		$r->addMessage(ViewMessage::success("Chaîne modifiée"));
		return $r;
	}
	
	public function create($request){}
	public function destroy($id, $request){}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['team_or_more'];
	}
}