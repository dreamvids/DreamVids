<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

class AdminConversionController extends AdminSubController {
	public function __construct() {
		
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function get($id, $request) {
		// TODO: Désactiver GZip
		
		$vid = Video::find($id);
		echo '<!doctype html><html><head><title>Conversion en cours...</title><meta charsat="utf-8" /></head><body>';
		if (Utils::getHTTPStatusCodeFromURL($vid->url.'_640x360p.mp4') == 200 && Utils::getHTTPStatusCodeFromURL($vid->url.'_640x360p.webm') == 200 && Utils::getHTTPStatusCodeFromURL($vid->url.'_1280x720p.mp4') == 200 && Utils::getHTTPStatusCodeFromURL($vid->url.'_1280x720p.mp4') == 200) {
			echo '<script>window.close()</script>';
			die();
		}
		$vid_path = preg_replace("#^https?://stor[1-9]+\.dreamvids\.fr/#", '', $vid->url);
		Utils::streamCmdOutput('convert.sh '.ROOT.$vid_path);
		echo '<script>window.close()</script></body></html>';
	}
	
	public function index($request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}