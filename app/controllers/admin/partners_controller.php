<?php
require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'json_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'partners.php';

class AdminPartnersController extends AdminSubController {
	public function __construct() {	}
	
	public function index($request) {
		$data = [];
		$data['partners'] = Partners::find('all');
		return new ViewResponse('admin/partners/index', $data);
	}
	
	public function get($id, $request){
	    return new RedirectResponse(WEBROOT . 'admin/partners');
	}
	public function create($request){
	    $params = $request->getParameters();
        if($params['name'] == ''){
            $data['params'] = $params = $request->getParameters();
    		$data['partners'] = Partners::find('all');
		    $r = new ViewResponse('admin/partners/index', $data);
    	    $r->addMessage(ViewMessage::error("Champs 'Nom' manquant"));
    	    
	    }else{
    	    Partners::create([
    	            'name' => $params['name'],
    	            'url' => $params['url'],
    	            'contact_email' => $params['contact_email']
    	        ]);
    	    $r = $this->index($request);
    	    $r->addMessage(ViewMessage::success("Partenaire ajouté"));
	    }

	   return $r;
	}
	public function update($id, $request){
	    var_dump($request->getParameters());
	}
	public function destroy($id, $request){
	    if(Partners::exists($id)){
	        $partner = Partners::find($id);
	        $partner->delete();
	    }
	    
	    return new JsonResponse([]);
	}
	
	public function hasPermission($user) {
		return Utils::getRankArray($user)['modo_or_more'];
	}
}