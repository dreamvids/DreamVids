<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL . 'comment.php';

class AdminModerationController extends AdminSubController {
	public function __construct() {
		
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}
	
	public function index($request) {
		$appConfig = new Config(CONFIG.'app.json');
		$appConfig->parseFile();
		$data = [];
		$data['stats'] = [
				"videos_suspended" => ["Vidéo(s) suspendue(s)", Video::getSizeOfSuspendedVideos(), 'videos/suspended'],
				"videos_flagged" => ["Vidéo(s) reportée(s)", Video::getSizeOfReportedVideos(), 'videos/reported'],
				"comments_flagged" => ["Commentaire(s) reporté(s)", Comment::count(['flagged' => 1]), 'comments']
		];
		
		$data['view_icons'] = ["videos_suspended" => ["fa-ban", "fa-video-camera"],
							   "videos_flagged" => ["fa-flag", "fa-video-camera"],
							   "comments_flagged" => ["fa-flag","fa-comments"]];
		
		$data['view_colors'] = ["videos_suspended" => "red",
								"videos_flagged" => "yellow",
								"comments_flagged" => "yellow"];
		
		return new ViewResponse('admin/moderation/index', $data);
	}
	
	public function comments($id, $request){
		$data = [];
		$data['comments'] = Comment::getReportedComments();
		return new ViewResponse('admin/moderation/comments', $data);
	}
	
	public function videos($type, $request){
		$data = [];
		
		switch ($type) {
			case 'suspended': 
				$data['videos'] = Video::getSuspendedVideos();
			break;
			
			case 'reported':
				$data['videos'] = Video::getReportedVideos();
			break;
		}
		return new ViewResponse('admin/moderation/videos', $data);
	}
	
	public function get($id, $request){}
	public function create($request){}
	public function update($id, $request){}
	public function destroy($id, $request){}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['modo_or_more'];
	}
	
}