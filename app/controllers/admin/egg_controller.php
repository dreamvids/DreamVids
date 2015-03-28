<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';
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
		$now = Utils::tps();
		$date_now = new DateTime(date("c", $now));
		foreach ($data as $k => $eggs) {
			foreach ($eggs as $k2 => $egg) {
				if($egg->show_timestamp < $now){
					$data['intervals'][$egg->id] = '';
				}else{
					$interval = abs($now - $egg->show_timestamp);
					
					$futur = new DateTime(date("c", $egg->show_timestamp));
					$diff = $futur->diff($date_now)->format("%Y ans, %m mois, %d j et %H:%I:%S restant");
					$data['intervals'][$egg->id] = $diff;
				}
			}
		}
		return new ViewResponse('admin/egg/index', $data);
	}
	
	public function add($site, $request){
		$data = ['site' => $site];
		switch ($site){
			case 'dreamvids' : $data['readable_site'] = 'Dreamvids';
			break;
			case 'cavicon' : $data['readable_site'] = 'CAVIcon';
			break;
			default : return $this->index($request);
		}
		return new ViewResponse('admin/egg/add', $data);
	}
	
	public function edit($id, $request){
		$data= [];
		if($id == '' || !Eggs::exists(['id' => $id])) return new RedirectResponse(WEBROOT . 'admin/egg');
		
		$egg = Eggs::find_by_id($id);
		$data['egg']= $egg;
		$data['edit'] = true;
		$r = new ViewResponse('admin/egg/edit', $data);
		if($egg->found){
			$r->addMessage(ViewMessage::error("Attention, cet oeuf a déjà été trouvé par quelqu'un !"));
		}
		return $r;
	}
	public function update($id, $request){
		$req = $request->getParameters();
		$egg = Eggs::find_by_id($id);
		$str_time = $this->preZero($req['day']).'-'.$this->preZero($req['month']).'-'.$req['year'].' '.$this->preZero($req['hour']).':'.$this->preZero($req['minute']); 
		$timestamp = strtotime($str_time);

		$egg->show_timestamp = $timestamp;
		$egg->points = $req['points'];
		$egg->emplacement = $req['emplacement'];
		$egg->save();
		
		$response = $this->edit($id, $request);
		$response->addMessage(ViewMessage::success('Modifications sauvegardées'));
		return $response;
		
	}
	
	public function create($request){
		$req = $request->getParameters();

		$str_time = $this->preZero($req['day']).'-'.$this->preZero($req['month']).'-'.$req['year'].' '.$this->preZero($req['hour']).':'.$this->preZero($req['minute']); 
		$timestamp = strtotime($str_time);

		$egg = Eggs::createNewEgg($timestamp, $req['emplacement'], $req['site'], $req['points']);
		$response = $this->index($request);
		$response->addMessage(ViewMessage::success('Nouvel oeuf ajouté'));
		return $response;
	}
	public function destroy($id, $request){
		$egg = Eggs::find($id);
		$result = $egg->delete();

		return new JsonResponse(['result' => $result]);
	}
	
	private function preZero($input, $number_of_zero = 2) {
		return str_pad($input, $number_of_zero, 0, STR_PAD_LEFT);
	}
	
}