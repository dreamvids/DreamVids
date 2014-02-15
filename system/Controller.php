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
		try {
			ob_end_clean();
		}
		catch(Exception $e) {}
	}

	public function renderView($viewName, $data='', $renderLayout=true) {
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