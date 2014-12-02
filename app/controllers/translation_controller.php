<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'json_response.php';

class TranslationController extends Controller {

	public function __construct() {
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::UPDATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		$data["result"] = Translator::get();
		return new JsonResponse($data);
	}

	public function get($id, $request) {
		$data["result"] = Translator::get($id);
		return new JsonResponse($data);
	}

	
	// Denied actions
	public function update($id, $request) {}
	public function destroy($id, $request) {}
	public function create($request) {}

}