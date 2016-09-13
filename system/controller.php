<?php

abstract class Controller {
	public static function renderView(string $path, bool $layout = true) {
		$file = VIEWS.$path.'.php';
		
		if (file_exists($file) ) {
			$appView = $file;
			$data = Utils::secure(Data::get()->getData());
			
			extract($data);
			
			if ($layout) {
				require_once VIEWS.'mainView.php';
			}
			else {
				require_once $appView;
			}
		}
		else {
			self::error('500');
		}
	}


	public static function error($number){
		switch ($number) {
			case '401':
				header('HTTP/1.1 401 Authorization Required');
				self::renderView('error/401');
				break;
			
			case '403':
				header('HTTP/1.1 404 Not Found');
				self::renderView('error/404');
				break;
			
			case '404':
				header('HTTP/1.1 404 Not Found');
				self::renderView('error/404');
				break;
			
			case '500':
				header('HTTP/1.1 500 Internal Server Error');
				self::renderView('error/500');
				break;
			
			default:
				header('HTTP/1.1 404 Not Found');
				self::renderView('error/404');
				break;
		}
	}
}