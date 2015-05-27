<?php
require_once SYSTEM . "controller.php";
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once MODEL.'faq.php';

class AdminFaqController extends AdminSubController {
			
	private static $fields = ['ask', 'answer', 'showed'];
	
	public function __construct(){}

	public function index($request){
		$data['faqs'] = Faq::find('all', ['order' => "`timestamp` DESC"]);
		return new ViewResponse('admin/faq/index', $data);
		
	}
	
	public function add($request){
		return new ViewResponse("admin/faq/add");
	}
	
	public function edit($id, $request){
		$data = [];
		if(!Faq::exists($id)){
			$r = $this->index($request);
			$r->addMessage(ViewMessage::error("Id inexistant."));
			return $r;
		}
		$data['faq'] = Faq::find($id);
		return new ViewResponse('admin/faq/edit', $data);
	}
	
	public function create($request){
		$req = $request->getParameters();
		$data = [];
		$new_question = ['timestamp' => Utils::tps()];
		foreach (self::$fields as $field) {
			$new_question[$field] = isset($req[$field]) ? $req[$field] : 0; 
		}
		
		$faq = Faq::create($new_question);
		$r = $this->edit($faq->id, $request);
		$r->addMessage(ViewMessage::success("Nouvelle Question/Réponse créée. <a href=\"".WEBROOT."admin/faq\">Retour à la liste</a>"));
		return $r;
		
	}
	public function update($id, $request){
		$req = $request->getParameters();
			if(Faq::exists($id)){
				$faq = Faq::find($id);
			}else{
				$r = $this->index($request);
				$r->addMessage(ViewMessage::error("Id inexistant."));
				return $r;
			}
			
			foreach (self::$fields as $field) {
				if(isset($req[$field])){
					$faq->$field = $req[$field];
				}
			}

			$faq->save();
			$r = new ViewResponse('admin/faq/edit', ['faq' => $faq]);
			$r->addMessage(ViewMessage::success("Cette question réponse à bien été sauvegardée. <a href=\"".WEBROOT."admin/faq\">Retour à la liste</a>"));
			return $r;
		
	}
		
	public function destroy($id, $request){
		$result = Faq::exists($id);
		
		if($result){
			$faq = Faq::find($id);
			$faq->erase();
		}
		
		return new JsonResponse(['result' => $result]);
	}
		
	public function get($id, $request) { return $this->edit($id, $request); }
	

}