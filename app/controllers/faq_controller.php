<?php
require_once SYSTEM . "controller.php";
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';

class FaqController extends Controller {
	public function __construct() {
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::GET);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		$data = [];
		$data['faqs'] = Faq::find('all', ['conditions' => ['showed' => 1]]);
		$data['empty'] = empty($data['faqs']);

		return new ViewResponse('faq/index', $data);
	}
	
	public function get($id, $request) {}
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}
	
}