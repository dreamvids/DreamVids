<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'ticket_levels.php';

class AdminTicketlevelsController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::GET);
	}
	
	public function index($request) {
	    
		return new ViewResponse('admin/ticket_levels/index');
	}
	
	public function edit_levels(){
	    $data['levels'] = TicketLevels::find('all');
	    return new ViewResponse('admin/ticket_levels/edit_levels', $data);
	}
	
	public function edit_users(){
	    $data['users'] = User::getTeam();
	    $data['levels'] = TicketLevels::find('all');
	    return new ViewResponse('admin/ticket_levels/edit_users', $data);
	}
	
	public function update($id, $request){

		$param = $request->getParameters();
		switch($id){
			case 'edit_users' : 
				$ticket_levels = TicketLevels::find('all');
				$team = User::getTeam();
				
				foreach($team as $user){
					foreach($ticket_levels as $tkt_lvls){
						$hasLevel = isset($param[$tkt_lvls->id . '_' . $user->id]);
						UserTicketsCapability::setLevel($user->id, $tkt_lvls->id, $hasLevel);
					}
				}
				$r = $this->edit_users();
				$r->addMessage(ViewMessage::success('Modifications enregistrées'));
				return $r;
			break;
			case 'edit_levels' :
				$id = $param['id'];
				$lvl = TicketLevels::find($id);
				$lvl->label = $param['label'];
				$lvl->save();
				$r = $this->edit_levels();
				$r->addMessage(ViewMessage::success('Modifications enregistrées'));
				return $r;
			break;
		}
	}
	
	public function get($id, $request){}
	public function create($request){
		$name = $request->getParameters()['label'];
		TicketLevels::create([
			'label' => $name
			]);
		$r =  $this->edit_levels($request);
		$r->addMessage(ViewMessage::success('Niveau de ticket ajouté'));
		return $r;
	}
	
	public function destroy($id, $request){
		$level = TicketLevels::find($id);
		$level->delete();
		
		$r = $this->edit_levels();
		$r->addMessage(ViewMessage::success('Supprimé'));
		return $r;
	}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['admin'];
	}
}