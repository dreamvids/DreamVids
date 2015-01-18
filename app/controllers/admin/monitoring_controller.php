<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

class AdminMonitoringController extends Controller {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		return $this->graph(0, $request);
	}
	
	public function graph($id, $request){
		$data = [];
		$data['video_graph_data'] = Video::getDataForGraphByDay();
	
		return new ViewResponse('admin/monitoring/graph', $data);
	}
	
	
	public function create($request){ }
	public function update($id, $request){ }
	public function destroy($id, $request){ }
	public function get($id, $request){ }
}