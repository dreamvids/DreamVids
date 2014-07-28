<?php

require_once SYSTEM.'methods.php';
require_once SYSTEM.'utils.php';
require_once CONFIG.'routes.php';

class Router {

	private $customRoutes = array();

	public function executeRequest($request) {
		if(!is_object($request) || get_class($request) != 'Request')
			return false;

		$uri = $request->getURI();

		if(strpos($uri, '/') !== false) {
			$parameters = explode('/', $uri);

			$controllerName = $parameters[0];
			$controller = $this->matchRoute($controllerName);

			if(is_object($controller)) {
				$this->executeAction($request, $controller, $parameters);
			}
		}
		else {
			$controller = $this->matchRoute($uri);

			if($controller && is_object($controller)) {
				$this->executeAction($request, $controller, array());
			}
		}
	}

	private function matchRoute($uri) {
		if(Route::getByURL($uri)) {
			$route = Route::getByURL($uri);
			$routeName = $route->getController();
			$file = $routeName.'_controller.php';

			if(file_exists(CONTROLLER.$file)) {
				require_once CONTROLLER.$file;

				$className = ucfirst($routeName).'Controller';

				if(class_exists($className)) {
					return new $className;
				}
				else {
					while($underscorePos = strpos($className, '_')) {
						if(strlen($className) > $underscorePos + 1) {	
							$className[$underscorePos + 1] = strtoupper($className[$underscorePos + 1]);
							$className = str_replace('_', '', $className);
						}
					}

					if(class_exists($className)) {
						return new $className;
					}
					else
						Utils::getNotFoundResponse()->send();
				}
			}
		}
		else if(strtolower($uri) == '' && ($route = Route::getByURL('default'))) {
			$file = $route->getController().'_controller.php';

			if(file_exists(CONTROLLER.$file)) {
				require_once CONTROLLER.$file;

				$className = ucfirst($route->getController()).'Controller';

				if(class_exists($className)) {
					return new $className;
				}
			}
		}
		else {
			Utils::getNotFoundResponse()->send();
		}

		return false;
	}

	private function executeAction($request, $controller, $uriParameters) {
		switch ($request->getMethod()) {
			case Method::GET:
				// Example: /posts/
				if(count($uriParameters) < 1) {
					if($controller->isActionAllowed(Action::INDEX)) {
						$response = call_user_func_array(array($controller, 'index'), array($request));
						Utils::sendResponse($response);
					}
					else
						Utils::getForbiddenResponse()->send();
				}
				// Example: /posts/42 or /posts/latest
				else if(count($uriParameters) == 2) {
					// Example: /posts/latest --> calls the 'latest' method from controller
					if(method_exists($controller, $uriParameters[1])) {
						unset($uriParameters[0]);

						$response = call_user_func_array(array($controller, $uriParameters[1]), array($request));
						Utils::sendResponse($response);
					}
					// Exemple: /posts/42
					else {
						if($controller->isActionAllowed(Action::GET)) {
							$response = call_user_func_array(array($controller, 'get'), array(Utils::secure($uriParameters[1]), $request));
							Utils::sendResponse($response);
						}
						else
							Utils::getForbiddenResponse()->send();
					}
				}
				else if(count($uriParameters) > 2) {
					// Example: /posts/recents/4 --> calls recents(4) from PostsController, to retrive the 4 most recent posts
					if(method_exists($controller, $uriParameters[1])) {
						$methodName = $uriParameters[1];

						unset($uriParameters[0]);
						unset($uriParameters[1]);

						$parameters = array_merge(array($request), $uriParameters);

						$response = call_user_func_array(array($controller, $methodName), $parameters);
						Utils::sendResponse($response);
					}
					// Example: /posts/42/edit --> call function edit (if it exists)
					else {
						$methodName = $uriParameters[2];

						if(method_exists($controller, $methodName)) {
							unset($uriParameters[0]);
							unset($uriParameters[2]);

							$response = call_user_func_array(array($controller, $methodName), array(Utils::secureArray($uriParameters), $request));
							Utils::sendResponse($response);
						}
						else {
							Utils::getNotFoundResponse()->send();
						}
					}
				}
				break;

			case Method::POST:
				if($controller->isActionAllowed(Action::CREATE)) {
					$request->setParameters($_POST);
					$response = call_user_func_array(array($controller, 'create'), array($request));

					Utils::sendResponse($response);
				}
				else
					Utils::getForbiddenResponse()->send();

				break;

			case Method::PUT:
				if(count($uriParameters) == 2) {
					if($controller->isActionAllowed(Action::UPDATE)) {
						$parameters = array();
						parse_str(file_get_contents('php://input'), $parameters);
						$request->setParameters($parameters);

						if(empty($parameters) && !empty($_POST)) { // If the request is not a real PUT request but needs to be handled like one (html form)
							$request->setParameters($_POST);
						}

						$response = call_user_func_array(array($controller, 'update'), array(Utils::secure($uriParameters[1]), $request));

						Utils::sendResponse($response);
					}
					else
						Utils::getForbiddenResponse()->send();
				}
				break;

			case Method::DELETE:
				if(count($uriParameters) == 2) {
					if($controller->isActionAllowed(Action::DESTROY)) {
						$response = call_user_func_array(array($controller, 'destroy'), array(Utils::secure($uriParameters[1]), $request));
						Utils::sendResponse($response);
					}
					else
						Utils::getForbiddenResponse()->send();
				}
				break;
			
			default:
				break;
		}
	}

}