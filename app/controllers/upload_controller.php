<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';
require_once MODEL.'user_channel.php';
require_once MODEL.'upload.php';
//require_once MODEL.'predefined_description.php';

class UploadController extends Controller {
	public function __construct() {
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		if (Session::isActive() ) {
			if (count(Session::get()->getOwnedChannels()) > 1) {
				return new RedirectResponse(WEBROOT.'upload/channelSelection');
			}
			else {
				return new RedirectResponse(WEBROOT.'upload/'.Session::get()->getMainChannel()->id);
			}
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}
	
	public function channelSelection($request) {
		if (Session::isActive() ) {
			$data = array();
			$data['channel'] = Session::get()->getOwnedChannels();
			$data['currentPageTitle'] = 'Mettre en ligne';
			return new ViewResponse('upload/channels', $data);			
		}
		else {
			return new RedirectResponse(WEBROOT.'login');
		}
	}
	
	public function get($id, $request) {
		if (UserChannel::find($id)->belongToUser(Session::get()->id)) {
			$uploadId = Upload::generateId(6);
			Upload::create(array(
				'id' => $uploadId,
				'channel_id' => $id,
				'video_id' => Video::generateId(6),
				'expire' => Utils::tps() + 86400
			));
			
			$data = array();
			$data['currentPageTitle'] = 'Mettre en ligne';
			$data['uploadId'] = $uploadId;
			$data['thumbnail'] = Config::getValue_('default-thumbnail');
			$data['channelId'] = $id;
			$data['currentPage'] = 'upload';
			//$data['predefined_descriptions'] = PredefinedDescription::getDescriptionByChannelsids($id);
			
			return new ViewResponse('upload/upload', $data);
		}
		else {
			return new RedirectResponse(WEBROOT.'upload');
		}
	}
	
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}