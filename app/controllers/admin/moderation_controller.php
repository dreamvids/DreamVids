<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL . 'comment.php';

class AdminModerationController extends Controller {
	public function __construct() {
		
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		return new ViewResponse('admin/moderation/index');
	}
	
	public function comments($id, $request){
		$data = [];
		$data['comments'] = Comment::getReportedComments();
		return new ViewResponse('admin/moderation/comments', $data);
	}
	
	public function videos($id, $request){
		$data = [];
		$data['videos'] = Video::getReportedVideos();
		return new ViewResponse('admin/moderation/videos', $data);
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
}