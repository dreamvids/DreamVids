<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once MODEL.'ticket.php';
require_once MODEL.'staff_notifications.php';

class AdminHomeController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	

	
	public function index($request) {
		
		$data['storage_server'] = ['local_server', 'stor1'];
		$data['tickets'] = Ticket::getSize(Session::get());
		$data['all_tickets'] = Ticket::getSize();
		$data['news'] = News::getLastNews();
		$data['notifs'] = StaffNotification::getInternStaffNotifications();
		
		return new ViewResponse('admin/dashboard/index', $data);
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}