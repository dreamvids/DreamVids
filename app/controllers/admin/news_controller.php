<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'news.php';

class AdminNewsController extends AdminSubController {
	public function __construct() {
		$this->denyAction(Action::INDEX);
		$this->denyAction(Action::GET);
	}
	
	public function create($request){
	    $params = $request->getParameters();
	    $data = ['success' => false];
	    
	    $user = Session::get();
	    
	    if($params['title'] != '' && $params['content'] != ''){
    	    $new = News::create([
    	            'user_id' => $user->id,
    	            'title' => $params['title'],
    	            'content' => $params['content'],
    	            'icon' => $params['icon'],
    	            'level' => $params['level'],
    	            'timestamp' => Utils::tps()
    	        ]);
    	        $data['success'] = is_object($new);
	    }
	    
	    return new JsonResponse($data);
	}
	public function update($id, $request){
	    $params = $request->getParameters();
	    
	    $data = $data = ['success' => false];
	    if(News::exists($id)){
	        $new = News::find($id);
	        if($new->belongsToUser(Session::get())){
	            $new->title = isset($params['title']) ? $params['title'] : $new->title;
	            $new->content = isset($params['content']) ? $params['content'] : $new->content;
	            $new->icon = isset($params['icon']) ? $params['icon'] : $new->icon;
	            $new->level = isset($params['level']) ? $params['level'] : $new->level;
	            $data['success'] = $new->save();
	        }
	    }
	    return new JsonResponse($data);
	}
	public function destroy($id, $request){
	    $data = ['success' => false];
	    if(News::exists($id)){
	        $new = News::find($id);
	        if($new->belongsToUser(Session::get())){
	            $data['success'] = $new->delete();
	        }
	    }
	    
	    return new JsonResponse($data);
	}

	public function index($request) {}
	public function get($id, $request){}
}