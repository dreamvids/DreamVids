<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'view_message.php';
class AdminChannelController extends Controller {
	public function __construct() {
		
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::DESTROY);
	}
	public function get($id, $request){
		return $this->edit($id, $request);
	}
	
	public function index($request) {
		$data = [];
		$data['channels'] = UserChannel::find('all');
		return new ViewResponse('admin/channel/index', $data);
	}
	
	public function edit($id, $request){
		$data= [];
		if($id == '' || !UserChannel::exists(['id' => $id])) return new RedirectResponse(WEBROOT . 'admin/channel');
		
		$channel = UserChannel::find_by_id($id);
		$data['channel_admin']= User::find($channel->owner_id);
		$data['channel'] = $channel;
		
		return new ViewResponse('admin/channel/edit', $data);
	}
	public function update($id, $request){
		$data = $request->getParameters();
		$channel = UserChannel::find($id);
		
		$channel->verified = $data['verified'];
		$channel->description = $data['description'];
		$channel->save();
		$data['channel'] = $channel;
		$data['channel_admin']= User::find($channel->owner_id);
		$r = new ViewResponse('admin/channel/edit', $data);
		$r->addMessage(ViewMessage::success("Chaîne modifiée"));
		return $r;
	}
	
	public function create($request){}
	public function destroy($id, $request){}
}