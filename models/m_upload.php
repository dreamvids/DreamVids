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

			if (move_uploaded_file($_FILES['videoInput']['tmp_name'], $path)) {
				// Genial ça a marché !
			}

			else if ($_FILES['videoInput']["error"] === 1) {
				// La taille de la vidéo excède le upload_max_filesize dans php.ini
			}

			else if ($_FILES['videoInput']["error"] === 2) {
				// La taille de la vidéo excède la taille maximum définie dans le formulaire html
			}

			else if ($_FILES['videoInput']["error"] === 3) {
				// La vidéo n'a pas été uploadée entierement
			}

			else if ($_FILES['videoInput']["error"] === 4) {
				// Aucun fichier n'a été envoyé
			}

			// Pas de 5...

			else if ($_FILES['videoInput']["error"] === 6) {
				// Le dossier temporaire n'existe pas
			}

			else if ($_FILES['videoInput']["error"] === 7) {
				// Impossible d'enregistrer la vidéo sur le disque dur
			}

			else if ($_FILES['videoInput']["error"] === 8) {
				// Une extension php a empêché l'upload du fichier
			}

			// Pour en savoir plus : http://www.php.net/manual/fr/features.file-upload.errors.php

			// Ce serait bien  d'enregistrer  ces erreurs  dans la bdd ou même
			// prévenir l'utilisateur qu'il peut réessayer ou tout abandonner.
			// Mais bon, c'est pas mon boulot à moi :P
			//
			// Dimou.

			$video = Video::create($_SESSION['vid_id'], $userId, '', '', '', '', $path, 0);
		}
	}
	
	public static function addDbInfos($tumbnailPath) {
		if (isset($_POST['submit']) ) {
			$title = $_POST['videoTitle'];
            $description = $_POST['videoDescription'];
            $tags = $_POST['videoTags'];
            $visibility = (in_array($_POST['videoVisibility'], array(0,1,2) ) ) ? $_POST['videoVisibility'] : 2;
            $video = Video::get($_SESSION['vid_id']);
            $video->setTitle($title);
            $video->setDescription($description);
            $video->setTags($tags);
            $video->setTumbnail($tumbnailPath);
            $video->setVisibility($visibility);
            $video->saveDataToDatabase();
			convert(getcwd().'/'.$video->getPath());
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
}

?>
