<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'statistic.php';
require_once MODEL.'comment.php';

class AdminStatisticController extends AdminSubController {
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
		//$data['video_graph_data'] = Video::getDataForGraphByDay();
		
		$counts = [];
		$counts['videos'] = Video::count();
		$counts['users'] = User::count();
		$counts['channels'] = UserChannel::count();
		$counts['comments'] = Comment::count();
		
		$counts['channel_user_ratio'] = round($counts['channels'] / $counts['users'], 2);
		
		$counts['videos_that_has_comments'] = Statistic::countVideosHavingComments();
		$counts['part_of_commented_videos'] = round($counts['videos_that_has_comments']/$counts['videos']*100, 2); 
		
		$counts['user_1_channel'] = Statistic::countUserHavingChannels('= 1');
		$counts['user_2_channel'] = Statistic::countUserHavingChannels('= 2');
		$counts['user_3_channel'] = Statistic::countUserHavingChannels('= 3');
		$counts['user_more3_channel'] = Statistic::countUserHavingChannels('> 3');
		

		$counts['user_1_channel_part'] = round($counts['user_1_channel']/$counts['users']*100, 2);
		$counts['user_2_channel_part'] = round($counts['user_2_channel']/$counts['users']*100, 2); 
		$counts['user_3_channel_part'] = round($counts['user_3_channel']/$counts['users']*100, 2); 
		$counts['user_more3_channel_part'] = round($counts['user_more3_channel']/$counts['users']*100, 2);
		
		$data['counts'] = $counts;
		
		return new ViewResponse('admin/Statistic/index', $data);
	}
	
	
	public function create($request){ }
	public function update($id, $request){ }
	public function destroy($id, $request){ }
	public function get($id, $request){ }
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['admin'];
	}
}