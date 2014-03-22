<?php

class Properties extends Controller {

	private $videoId = 'lolnop';

	public function index($videoId='nope') {
		if($videoId != 'nope') {

			if(Video::exists(array('id' => $videoId))) {
				$this->videoId = $videoId;
				$data['video'] = Video::find_by_id($videoId);

				$this->renderView('account/videoproperties', $data);
			}
			else {
				Application::instance()->throwNotFoundError();
				return;
			}
		}
		else {
			header('Location: '.WEBROOT);
			exit();
		}
	}

	public function postRequest($request = 'nope') {
		echo $this->videoId;
		if($request != 'nope' && is_object($request)) {
			$req = $request->getValues();

			if(isset($req['videoPropertiesSubmit']) && Session::isActive()) {
				$this->loadModel('videoproperties_model');

				$newTitle = $req['videoTitle'];
				$newDescription = $req['videoDescription'];
				$newTags = $req['videoTags'];

				if(Video::exists(array('id' => $this->videoId)) && Video::find_by_id($this->videoId)->poster_id == Session::get()->id) {
					$this->model->updateVideoInfo($this->videoId, $newTitle, $newDescription, $newTags);
				}
			}
		}
	}

}