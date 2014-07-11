<?php

require_once SYSTEM.'methods.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'response.php';

/**
 * Extend this class to create a ressource controller
 * The name of the controller should plural
 *
 * Example: PostsController for a Post ressource
 */
abstract class Controller {

	protected $allowedActions = array(Action::INDEX, Action::GET, Action::CREATE, Action::UPDATE, Action::DESTROY);

	public function __construct() {

	}

	/**
	 * Return a listing of the concerned ressource
	 * GET /ressource
	 * 
	 * @return Response
	 */
	abstract public function index($request);


	/**
	 * Return the conerned ressource's details
	 * GET /ressource/:id
	 * 
	 * @return Response
	 */
	abstract public function get($id, $request);


	/**
	 * Create a new ressource
	 * POST /ressource
	 * 
	 * @return Response
	 */
	abstract public function create($request);


	/**
	 * Update the specified ressource
	 * PUT /ressource/:id
	 * 
	 * @return Response
	 */
	abstract public function update($id, $request);


	/**
	 * Destroy the specified ressource
	 * DELETE /ressource/:id
	 * 
	 * @return Response
	 */
	abstract public function destroy($id, $request);

	protected function allowAction($action) {
		if(!in_array($action, $this->allowedActions))
			array_push($this->allowedActions, $action);
	}

	protected function denyAction($action) {
		if(($key = array_search($action, $this->allowedActions)) !== false)
			unset($this->allowedActions[$key]);
	}

	public function isActionAllowed($action) {
		return in_array($action, $this->allowedActions);
	}

	public function getAllowedActions() {
		return $this->allowedActions;
	}

}