<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';

class EmbedController extends Controller {
	
	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function video($id, $request) {
		$video = Video::find($id);
		$url = (preg_match("#^http#isU", $video->url)) ? $video->url : 'http://dreamvids.fr/'.$video->url;
		$data = array();
		$data['video'] = $video;
		$data['url'] = $url;
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
	
	public function index($request){}
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}