<?php

class Controller {

	protected $model = -1;

	public function Controller() {

	}

	public function index() {
		
	}

	public function loadModel($modelName) {
		require MODEL.$modelName.'.php';
		$modelName = ucfirst($modelName);
		$this->model = new $modelName;
	}

	public function postRequest($request) {
		
	}

	public function getRequest($request) {
		
	}

	public function clearView() {
		if(ob_get_contents()) ob_end_clean();
	}

	public function renderView($viewName, $data='', $renderLayout=true) {
		if(ob_get_contents()) return;
		
		if($data != '' && is_array($data)) {
			extract($data);
		}
		if($renderLayout) {
			$content = VIEW.$viewName.'.php';
			include VIEW.'layouts/main.php';
		}
		else {
			include VIEW.$viewName.'.php';
		}
	}

}