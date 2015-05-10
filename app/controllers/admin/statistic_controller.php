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
		$data = [];

		$counts = [];
		$counts['videos'] = Video::count();
		$counts['users'] = User::count();
		$counts['channels'] = UserChannel::count();
		$counts['comments'] = Comment::count();
		
		$counts['channel_user_ratio'] = round($counts['channels'] / $counts['users'], 2);
		
		$counts['videos_that_has_comments'] = Statistic::countVideosHavingComments();
		$counts['channels_having_videos'] = Video::find_by_sql('SELECT count(DISTINCT poster_id) as count from `videos`')[0]->count;
		
		$counts['part_of_commented_videos'] = round($counts['videos_that_has_comments']/$counts['videos']*100, 2); 
		$counts['part_of_channels_having_videos'] = round($counts['channels_having_videos']/$counts['channels']*100, 2);
		
		$counts['user_1_channel'] = Statistic::countUserHavingChannels('= 1');
		$counts['user_2_channel'] = Statistic::countUserHavingChannels('= 2');
		$counts['user_3_channel'] = Statistic::countUserHavingChannels('= 3');
		$counts['user_more3_channel'] = Statistic::countUserHavingChannels('> 3');
		

		$counts['user_1_channel_part'] = round($counts['user_1_channel']/$counts['users']*100, 2);
		$counts['user_2_channel_part'] = round($counts['user_2_channel']/$counts['users']*100, 2); 
		$counts['user_3_channel_part'] = round($counts['user_3_channel']/$counts['users']*100, 2); 
		$counts['user_more3_channel_part'] = round($counts['user_more3_channel']/$counts['users']*100, 2);
		
		
		$data['counts'] = $counts;
		
		return new ViewResponse('admin/statistic/index', $data);
	}
	
	public function accesses($request){
		header("Location: http://dv.x-share.ga/stats.html");
		die();
	}
	
	public function graph(){
		$data = [];
		$data['data_for_graph']['videos'] = Statistic::getDataForGraph('Video');
		$data['data_for_graph']['users'] = Statistic::getDataForGraph('User', 'reg_timestamp');
		$data['data_for_graph']['videos_year'] = Statistic::getDataForGraph('Video', 'timestamp', 3600*24*30*12, 3600*24*30, "Y-m");
		$data['data_for_graph']['users_year'] = Statistic::getDataForGraph('User', 'reg_timestamp', 3600*24*30*12, 3600*24*30, "Y-m");
		return new ViewResponse('admin/statistic/graph', $data);
	}
	
	public function create($request){ }
	public function update($id, $request){ }
	public function destroy($id, $request){ }
	public function get($id, $request){ }
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['team_or_more'];
	}
}
