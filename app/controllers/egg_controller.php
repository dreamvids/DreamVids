<?php 
require_once SYSTEM . "controller.php";
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'javascript_response.php';
require_once SYSTEM.'json_response.php';
require_once MODEL.'event_eggs.php';

/**
 * <strong>Done : </strong>
 * <ul>
 *	<li>Database structure</li>
 *	<li>Really basic egg showing (in layout)</li>
 *	<li>Egg scoring (by clicking on it)</li>
 *	<li>Multiple validation (timestamp/found)</li>
 *	<li>Error and Success page</li>
 *	<li>Ranking</li>
 * 	<li> Link to login or register if we win find an egg but aren't logged in</li>
 * 	<li> Panel admin</li>
 * </ul>
 * <strong>To improve : </strong>
 * <ul>
 * 	<li> Integration of the eggs (randomly on the page ? or may be the position can be set in event_eggs.emplacement in a json string ?)</li>
 * </ul>
 * @todo
 * <ul> 
 * 	<li> JS generation for CAVIcon </li>
 * </ul>
 */

class EggController extends Controller {
	public function __construct() {
		
	}
	public function index($request) { //Explain the game and show the ten best users
		
		return new ViewResponse("egg/index");
		
	}
	
	public function showCaviEggs($request){ //List the eggs for the cavicon's website 
		$eggs = Eggs::getCaviconEggs();
		$data = [];
		return new JavaScriptResponse("egg/index.js", ['eggs' => ['a', 'b', 'c']]);
	}
	
	public function check($id, $request){ //Check if an egg has been found or not
		$available = Eggs::isAvailable($id);
		
		return new JsonResponse(['available' => $available]);
	}
	
	public function get($id, $request) { //Triggered when an egg is clicked to add the point(s)
		$data = [];
		if(Eggs::isAvailable($id)){
			$data['egg'] = Eggs::find($id);
			if(Session::isActive()){
				$data['egg']->user_id = Session::get()->id;
				$data['egg']->found = true;
				$data['egg']->save();
				$data['pts'] = Eggs::countUserScore(Session::get());
			}

			return new ViewResponse('egg/found', $data);
			//echo 'You won ' . $pts . ' point' . $pts > 1 ? 's' : '';
		}else{
			if(Session::isActive()){
				$data['pts'] = Eggs::countUserScore(Session::get());
			}
			return new ViewResponse('egg/error', $data);
		}
		
	}
	
	public function rank(){
		$data = ['bests' => Eggs::getBestUsers()];
		
		return new ViewResponse('egg/rank', $data);
	}
	
	public function create($request) {}
	public function update($id, $request) {}
	public function destroy($id, $request) {}
	

}