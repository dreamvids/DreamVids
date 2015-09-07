<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';
require_once MODEL.'pushbullet.php';
require_once MODEL.'staff_notifications.php';

class AdminNotificationsController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::DESTROY);
	}
	

	
	public function index($request) {
		
		$data['notif_page'] = true;
		$data['notifs'] = StaffNotification::getInternStaffNotifications();
		$data['is_notif_enabled'] = StaffNotification::isEnabled(Session::get());
		$data['push_mail'] = Session::get()->details->push_bullet_email;
		return new ViewResponse('admin/notifications/index', $data);
	}
	public function update($id, $request){
		$params = $request->getParameters();
		switch($id){
			case 'enable' : 
				Session::get()->setPushNotificationSetting($params['enable']);
				return new JsonResponse(['success' => true]);
				break;
		}
	}
	public function create($request){
		$notif = new PushBulletNotification('Dreamvids', "Test de notification !", [Session::get()->details->push_bullet_email]);
		$notif->send();
	}
	
	public function get($id, $request){}
	public function destroy($id, $request){}
}