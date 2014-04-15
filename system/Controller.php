<?php

class Controller {

	protected $model = -1;

	public function Controller() {

	}

	protected function index() {
		
	}

	protected function loadModel($modelName) {
		require MODEL.$modelName.'.php';
		$modelName = ucfirst($modelName);
		$this->model = new $modelName;
	}

	public function postRequest($request) {
		
	}

	public function getRequest($request) {
		
	}

	protected function clearView() {
		if(ob_get_contents()) ob_end_clean();
	}

	protected function renderView($viewName, $data='', $renderLayout=true) {
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
	
	protected function renderViewWithError($error, $view, $data='') {
		if ($data == '')
			$data = array();
		else
		{
			foreach ($data as $key => $value) {
				$data[$key] = Utils::secure($value);
			}
		}
		
		$data['error'] = $error;
		$this->clearView();
		$this->renderView($view, $data);
	}

	protected function renderViewWithSuccess($success, $view, $data='') {
		if ($data == '')
			$data = array();
		else
		{
			foreach ($data as $key => $value) {
				$data[$key] = Utils::secure($value);
			}
		}
		
		$data['success'] = $success;
		$this->clearView();
		$this->renderView($view, $data);
	}
	
}