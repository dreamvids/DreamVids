<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';
require_once MODEL.'live_access.php';

class EmbedController extends Controller {
	
	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function video($id, $param2, $param3='nope') {
		$autoplay = ($param3 != 'nope');
		if ($autoplay) {
			$request = $param3;
		}
		else {
			$request = $param2;
		}

		$video = Video::find($id);
		$url = (preg_match("#^http#isU", $video->url)) ? $video->url : 'http://dreamvids.fr/'.$video->url;
		$data = array();
		$data['video'] = $video;
		$data['url'] = $url;
		$data['autoplay'] = $autoplay;
		return new ViewResponse('embed/video', $data, false);
	}
	
	public function live($id, $request) {
		if (UserChannel::exists(array('name' => $id))) {
			$data = array('chaine' => $id);
			return new ViewResponse('embed/live', $data, false);
		}
		else {
			return new RedirectResponse(WEBROOT);
			exit();
		}
	}
	
	public function chat($id, $request) {
		if (UserChannel::exists(array('name' => $id))) {
			$data = [];
			$channel = UserChannel::find(['name' => $id]);
			$data['channel']= $channel;
			
			$access = LiveAccess::find(array('channel_id' => $channel->id));
			
			if(is_object($access)){
				$data['viewers'] = $access->viewers;
			}else{
				$data['viewers'] = 0;
			}
			
			return new ViewResponse('embed/chat', $data, false);
		}
		else {
			return Utils::getNotFoundResponse();
		}
	}
	
	public function index($request){}
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}