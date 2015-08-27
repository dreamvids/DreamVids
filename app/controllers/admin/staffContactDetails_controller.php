<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'view_message.php';
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
		$data['infos'] = User::getTeam(true);
		
		return new ViewResponse('admin/staffContactDetails/index', $data);
	}
	
	public function edit(){
		$data = ['user' => Session::get()];
		$data['infos'] = Session::get()->details;
		return new ViewResponse("admin/staffContactDetails/edit", $data);
	}
	
	public function edit_public_infos($param, $request){
		$data['infos'] = Session::get()->details;
		return new ViewResponse('admin/staffContactDetails/edit_public_infos', $data);
		
	}
	
	public function update($id, $request){ 
		if(Session::get()->details !== null){
			$infos = Session::get()->details;
			$param = $request->getParameters();
			$data['infos'] = Session::get()->details;
			switch($param['type']){
				case 'contact' : 
					$infos->tel_1 = $param['tel_1'];
					$infos->tel_2 = $param['tel_2'];
					$infos->email = $param['email'];
					$infos->push_bullet_email = $param['push_bullet_email'];
					$path = "edit";
					break;
				case 'public' : 
					$img_url = $this->_handleUpload($request);
					$infos->shown_name = isset($param['shown_name']) ? $param['shown_name'] : null;
					$infos->description = isset($param['description']) ? $param['description'] : null;
					
					if(!is_null($img_url)){
						$infos->team_img_name = $img_url;
					}
					$path = "edit_public_infos";
					break;
			}

			$infos->save();
			$response = new ViewResponse('admin/staffContactDetails/'.$path, $data);
			$response->addMessage(ViewMessage::success('Informations modifiées'));
			
			return $response;
		}else{
			return $this->create($request);
		}
		
	}

	public function create($request){
		$param = $request->getParameters();
		$img_url = $this->_handleUpload($request);
		
		$detail = StaffContact::create([
			'user_id' => Session::get()->id,
			'tel_1' => isset($param['tel_1']) ? $param['tel_1'] : "",
			'tel_2' => isset($param['tel_2']) ? $param['tel_2'] : "",
			'email' => isset($param['email']) ? $param['email'] : "",
			'push_bullet_email' => isset($param['push_bullet_email']) ? $param['push_bullet_email'] : "",
			'shown_name' => isset($param['shown_name']) ? $param['shown_name'] : null,
			'description' => isset($param['description']) ? $param['description'] : null,
			'team_img_name' => $img_url
		]);
		
		return new RedirectResponse(WEBROOT . 'admin/staffContactDetails');
		
	}
	public function destroy($id, $request){ }
	public function get($id, $request){ }
	
	public function _handleUpload($request){
		$req = $request->getParameters();
		if(!isset($req['_FILES_']['team_img_name'])){
			return null;
		}
		$ext = pathinfo($req['_FILES_']['team_img_name']['name'], PATHINFO_EXTENSION);
		if(!in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg'])){
			return null;
		}
		$file_name = Session::get()->username . '_'. Utils::tps() . '.' . $ext;
		if(move_uploaded_file($req['_FILES_']['team_img_name']['tmp_name'], ROOT . 'assets/img/team/'.$file_name)){
			return $file_name;
		}else{
			return null;
		}
		
	}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['team_or_more'];
	}
}
