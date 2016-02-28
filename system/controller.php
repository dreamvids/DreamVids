<?php
abstract class Controller {
	public static function renderView(string $path, bool $layout = true) {
		$file = VIEWS.$path.'.php';
		if (file_exists($file) ) {
			$appView = $file;
			extract(Data::get()->getData());
			if ($layout) {
				require_once VIEWS.'mainView.php';
			}
			else {
				require_once $appView;
			}
		}
		else {
			self::error500();
		}
	}

	public static function error401() {
		header('HTTP/1.1 401 Authorization Required');
		self::renderView('error/401');
	}

	public static function error403() {
		header('HTTP/1.1 403 Forbidden');
		self::renderView('error/403');
	}

	public static function error404() {
		header('HTTP/1.1 404 Not Found');
		self::renderView('error/404');
	}

	public static function error500() {
		header('HTTP/1.1 500 Internal Server Error');
		self::renderView('error/500');
	}
}