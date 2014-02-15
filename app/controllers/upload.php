<?php

class Upload extends Controller {

	public function index() {
		if(Session::isActive()) {
			$data = array();
			$this->renderView('upload/upload', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function preprocess() { // called from JS when file starts to upload
		if(Session::isActive()) {
			$this->loadModel('upload_model');
			$this->model->createTempVideo(Session::get()->id);
		}
	}

	public function process() { // called from JS upload script when the video file uploaded
		if(isset($_FILES['videoFile']) && Session::isActive() && isset($_SESSION['VIDEO_UPLOAD_ID']) && $_SESSION['VIDEO_UPLOAD_ID'] != -1) {
			$this->loadModel('upload_model');

			$vidId = $_SESSION['VIDEO_UPLOAD_ID'];
			$name = $_FILES['videoFile']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$username = Session::get()->username;
			$path = 'uploads/'.$username.'/'.$vidId.'.'.$ext;

			if(!file_exists('uploads/')) {
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username)) {
				mkdir('uploads/'.$username);
			}

			if(move_uploaded_file($_FILES['videoFile']['tmp_name'], ROOT.$path)) {
				$this->model->updateTempURL($vidId, $path);	
			}
			else $this->model->updateTempURL($vidId, '[error_during_file_moving]');
		}
	}

	public function postRequest($request) {
		$this->clearView();
		$this->loadModel('upload_model');

		$req = $request->getValues();

		if(isset($req['uploadDataSubmit'])) {
			if(isset($req['videoTitle'])) {
				if(isset($req['videoDescription'])) {
					if(isset($req['videoTags'])) {

						if(isset($req['videoThumbnail'])) $thumb = $req['videoThumbnail'];
						else $thumb = '';

						$userId = Session::get()->id;
						$title = Utils::secure($req['videoTitle']);
						$desc = Utils::secure($req['videoDescription']);
						$tags = Utils::secure($req['videoTags']);
						$visibility = $req['videoVisibility'];
						$vidId = $_SESSION['VIDEO_UPLOAD_ID'];

						$this->model->registerVideo($vidId, $userId, $title, $desc, $tags, $thumb, Utils::tps(), $visibility);
					}
					else {
						$data['error'] = 'Please enter some tags';
						$this->clearView();
						$this->renderView('upload/upload', $data);
					}
				}
				else {
					$data['error'] = 'Please enter a description';
					$this->clearView();
					$this->renderView('upload/upload', $data);
				}
			}
			else {
				$data['error'] = 'Please enter a title';
				$this->clearView();
				$this->renderView('upload/upload', $data);
			}
		}
	}

	public static function uploadThumbnail($username) {
		if(isset($_FILES['videoThumbnail']) && isset($username)) {
			$name = $_FILES['videoThumbnail']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.Session::get()->username.'.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['videoThumbnail']['tmp_name'], $path);
			
			return $path;
		}
	}

}