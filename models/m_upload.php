<?php

class Upload {
	public static function uploadVideo($userId, $username) {
		if(isset($_FILES['videoInput']) && isset($username)) {
			$name = $_FILES['videoInput']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.$_SESSION['vid_id'].'.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['videoInput']['tmp_name'], $path);
			convert(getcwd().'/'.$video->getPath());
		}
	}
	
	public static function addDbInfos($tumbnailPath, $userId) {
		if (isset($_POST['submit']) ) {
			$title = $_POST['videoTitle'];
            $description = $_POST['videoDescription'];
            $tags = $_POST['videoTags'];
            $visibility = (in_array($_POST['videoVisibility'], array(0,1,2) ) ) ? $_POST['videoVisibility'] : 2;
            $video = Video::create($_SESSION['vid_id'], $userId);
            $video->setTitle($title);
            $video->setDescription($description);
            $video->setTags($tags);
            $video->setTumbnail($tumbnailPath);
            $video->setPath($_SESSION['SERVER_ADDR'].'uploads/'.$userId.'/'.$_SESSION['vid_id'].'.'.$ext);
            $video->setVisibility($visibility);
            $video->saveDataToDatabase();
			header('Location: /&'.$video->getId() );
			exit();
		}
	}
	
	public static function countVideos() {
		$db = new BDD();
		$return = $db->select("id", "videos", "WHERE id='".$_SESSION['vid_id']."'");
		$db->close();
		return $db->num_rows($return);
	}
	
	public static function uploadTumbnail($username) {
		if(isset($_FILES['videoTumbnail']) && isset($username)) {
			$name = $_FILES['videoTumbnail']['name'];
			$exp = explode('.', $name);
			$ext = $exp[count($exp)-1];
			$path = 'uploads/'.$username.'/'.$_SESSION['vid_id'].'.'.$ext;

			if(!file_exists('uploads/')){
				mkdir('uploads/');
			}
			if(!file_exists('uploads/'.$username) ) {
				mkdir('uploads/'.$username);
			}

			move_uploaded_file($_FILES['videoTumbnail']['tmp_name'], $path);
			
			return $path;
		}
	}
	
	public static function getFreestServer() {
		$db = new BDD();
		$rep = $db->select("*", "storage_servers", "WHERE critical=0");
		$best_serv = array('addr' => null, 'free' => 0);
		while ($data = $db->fetch_array($rep) )
		{
			$resp = file_get_contents($data['address']);
			if ($resp != 'CRITICAL_ALERT')
			{
				if ($resp > $best_serv['free'])
				{
					$best_serv['addr'] = $data['address'];
					$best_serv['free'] = $resp;
				}
			}
			else
			{
				$db->update("storage_servers", "critical=1", "WHERE id='".$data['id']."'");
			}
		}
		$db->close();
		return $best_serv['addr'];
	}
}