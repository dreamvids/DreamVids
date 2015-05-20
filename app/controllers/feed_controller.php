<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'video.php';
require_once MODEL.'user_channel.php';
require_once MODEL.'comment.php';

class FeedController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(Session::isActive()) {
			$sess = Session::get();
			$data = array();
			$data['currentPageTitle'] = 'Flux d\'activité';
			$data['actions'] = array();
			$data['subscriptions'] = array();
			$data['last_visit'] = $sess->last_visit;
			$sess->last_visit = Utils::tps();
			$sess->save();
			
			$actions = Session::get()->getNotifications();
			
			$data['subscriptions'] = Session::get()->getSubscribedChannels();
			if(count($actions) > 0) {
				$data['actions'] = $actions;
			}
			
			$data = $this->regroupPmFeeds($data);
			$data = $this->regroupLikeFeeds($data);
			$data = $this->regroupSubscribeFeeds($data);

			return new ViewResponse('feed/feed', $data);
		}
		else {
			return new RedirectResponse(Utils::generateLoginURL());
		}
	}

	public function subscription($subscriptionId) {
		$subscription = UserChannel::exists($subscriptionId) ? UserChannel::find($subscriptionId) : UserChannel::find_by_name($subscriptionId);

		if(is_object($subscription) && !$subscription->belongToUser(Session::get()->id)) {
			$data = array();

			$data['subscriptions'] = Session::get()->getSubscribedChannels();
			$data['vids'] = Session::get()->getSubscriptionsVideosFromChannel($subscription->id, 6);

			return new ViewResponse('feed/feed', $data);
		}
	}
	
	private function regroupPmFeeds($data) {
		
		$last_timestamp = 0;
		$interval = 5*3600; //secondes
		$first_streak = true;
		$first_streak_id = -1;
		foreach ($data["actions"] as $k => $action) {
			if($action->type != 'pm') { continue; } //on s'occupe que des pm
			if($first_streak_id<0){
				$first_streak_id = $k;
			}
		
			if($first_streak){
				$first_streak = false;
				$first_streak_id=$k;
				$data["actions"][$first_streak_id]->infos['nb_msg']= 1;
			}else{
				if($action->timestamp+$interval>=$last_timestamp){
					unset($data["actions"][$k]);
					$data["actions"][$first_streak_id]->infos['nb_msg']++;
				}else{
					$first_streak_id=$k;
					$data["actions"][$first_streak_id]->infos['nb_msg']= 1;
				}
					
			}
			$last_timestamp = $action->timestamp;
		}
		
		
		return $data;
	}
	
	private function regroupSubscribeFeeds(&$data, $starting_index=-1, &$skip = array()){

		$last_timestamp = 0;
		$interval = 3*24*3600; //secondes
		$first_streak = true;
		$first_streak_id = -1;
		$last_channel = "";
		foreach ($data["actions"] as $k => $action) {
			if($action->type != 'subscription' || $starting_index>$k || in_array($k, $skip)) { continue; } 
			
			if($first_streak){
				if($first_streak_id<0){
					$first_streak_id = $k;
				}
				$first_streak = false;
				$last_channel = $action->target;
				$data["actions"][$first_streak_id]->infos['nb_subscription'] = 1;
				$last_timestamp = $action->timestamp;
			}else{
				if($last_channel != $action->target){
					$data = $this->regroupSubscribeFeeds($data, $k, $skip);
				}else{
					if($action->timestamp+$interval>=$last_timestamp){
						unset($data["actions"][$k]);
						$data["actions"][$first_streak_id]->infos['nb_subscription']++;
						$skip[]=$k;
					}else{
						$first_streak_id=$k;
						$data["actions"][$first_streak_id]->infos['nb_subscription']= 1;
					}
				}
			}
			
		}
		
		return $data;
	}
	
	
	private function regroupLikeFeeds(&$data, $starting_index=-1, &$skip = array()){
		
		$last_timestamp = 0;
		$interval = 3*24*3600; //secondes 3 jours
		$first_streak = true;
		$first_streak_id = -1;
		$last_video = "";
		foreach ($data["actions"] as $k => $action) {
			if($action->type != 'like' || $starting_index>$k || in_array($k, $skip)) { continue; }
				
			if($first_streak){
				if($first_streak_id<0){
					$first_streak_id = $k;
				}
				$first_streak = false;
				$last_video = $action->target;
				$data["actions"][$first_streak_id]->infos['nb_like'] = 1;
				$last_timestamp = $action->timestamp;
			}else{
				if($last_video != $action->target){
					$data = $this->regroupLikeFeeds($data, $k, $skip);
				}else{
					if($action->timestamp+$interval>=$last_timestamp){
						unset($data["actions"][$k]);
						$data["actions"][$first_streak_id]->infos['nb_like']++;
						$skip[]=$k;
					}else{
						$first_streak_id=$k;
						$data["actions"][$first_streak_id]->infos['nb_like']= 1;
					}
				}
			}
				
		}
	
		return $data;
	}
	
	
	// Denied actions
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}

}
