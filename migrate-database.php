<?php

class SuperDatabaseMigrator3000 {

	private $originalDb = null;
	private $originalDbHost = '172.17.0.3';
	private $originalDbUser = 'root';
	private $originalDbPass = 'root';
	private $originalDbName = 'dreamvids_v1';

	private $targetDb = null;
	private $targetDbHost = '172.17.0.3';
	private $targetDbUser = 'root';
	private $targetDbPass = 'root';
	private $targetDbName = 'dreamvids_migrated';

	public function connectToDatabase() {
		$this->originalDb = new PDO('mysql:host='.$this->originalDbHost.';dbname='.$this->originalDbName, $this->originalDbUser, $this->originalDbPass);
		$this->originalDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->targetDb = new PDO('mysql:host='.$this->targetDbHost.';dbname='.$this->targetDbName, $this->targetDbUser, $this->targetDbPass);
		$this->targetDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function processUsers() {
		$origUsers = $this->originalDb->query("SELECT * FROM users");
		$userId = 1;

		foreach($origUsers as $origUser) {
			$name = $origUser["username"];
			$mail = $origUser["email"];
			$pass = $origUser["pass"];
			$subscribers = $origUser["subscribers"];
			$subscriptions = $origUser["subscriptions"];
			$regTimestamp = $origUser["reg_timestamp"];
			$regIp = $origUser["reg_ip"];
			$actualIp = $origUser["actual_ip"];
			$rank = $origUser["rank"];
			$views = 0;
			$channelId = $this->generateId(6, "users_channels");
			$background = "uploads/$channelId/background.png";
			$avatar = "uploads/$channelId/avatar.png";

			if(empty($origUser["avatar"])) {
				$avatar = "/assets/img/default-avatar.png";
			}
			if(empty($origUser["background"])) {
				$background = "/assets/img/default-background.png";
			}

			$videos = $this->originalDb->query("SELECT * FROM videos WHERE user_id=".$origUser["id"]);
			foreach($videos as $origVideo) {
				$id = $origVideo["id"];
				$title = $origVideo["title"];
				$description = $origVideo["description"];
				$tags = $origVideo["tags"];
				$tumbnail = $origVideo["tumbnail"];
				$url = "uploads/$channelId/$id.".pathinfo($origVideo["url"], PATHINFO_EXTENSION);
				$views = $origVideo["views"];
				$likes = $origVideo["likes"];
				$dislikes = $origVideo["dislikes"];
				$timestamp = $origVideo["timestamp"];
				$visibility = $origVideo["visibility"];
				$flagged = $origVideo["flagged"];
				$duration = 0; //TODO

				$insStmt = $this->targetDb->prepare("INSERT INTO videos VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$insStmt->execute(array(
					$id,
					$channelId,
					$title,
					$description,
					$tags,
					$tumbnail,
					$duration,
					$url,
					$views,
					$likes,
					$dislikes,
					$timestamp,
					$visibility,
					$flagged,
					0
				));

				$comments = $this->originalDb->query("SELECT * FROM videos_comments WHERE video_id='$id'");
				foreach($comments as $origComment) {
					$commentId = $origComment["id"];
					$videoId = $origComment["video_id"];
					$comment = $origComment["comment"];	
					$timestamp = $origComment["timestamp"];	

					$insStmt = $this->targetDb->prepare("INSERT INTO videos_comments VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$insStmt->execute(array(
						$commentId,
						$channelId,
						$videoId,
						$comment,
						0,
						0,
						$timestamp,
						'',
						0
					));
				}

				$votes = $this->originalDb->query("SELECT * FROM videos_votes WHERE obj_id='$id' AND type='video'");
				foreach($votes as $vote) {
					$voteId = $this->generateId(6, "videos_votes");
					$objId = $vote["obj_id"];
					$action = $vote["action"];

					$insStmt = $this->targetDb->prepare("INSERT INTO videos_votes VALUES (?, ?, ?, ?, ?)");
					$insStmt->execute(array(
						$voteId,
						$userId,
						'video',
						$objId,
						$action
					));
				}

				$views += $origVideo["views"];
			}

			$insStmt = $this->targetDb->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$insStmt->execute(array(
				$userId,
				$name,
				$mail,
				$pass,
				$subscriptions,
				$regTimestamp,
				$regIp,
				$actualIp,
				$rank,
				'', // settings
				0, // last visit
				'' // log fail
			));

			$insStmt = $this->targetDb->prepare("INSERT INTO users_channels VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$insStmt->execute(array(
				$channelId,
				$name,
				"Chaîne de $name",
				$userId,
				";$userId;",
				$avatar,
				$background,
				$subscribers,
				$subscriptions,
				$views,
				0
			));

			$insStmt = $this->targetDb->prepare("INSERT INTO channels_actions VALUES (?, ?, ?, ?, ?, ?, ?)");
			$insStmt->execute(array(
				$this->generateId(6, "channels_actions"),
				$channelId,
				";$userId;",
				"welcomeback",
				"",
				"",
				time()
			));

			$userId++;
		}
	}

	private function generateId($length, $type) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			switch($type) {
				case "users_channels":
					$id = 'c_'.$id;
					break;
				case "channels_actions":
					break;
				case "videos_votes":
					$id = 'v_'.$id;
					break;
				default:
					$id = 'tg_'.$id;
					break;
			}

			$stmt = $this->targetDb->prepare("SELECT id FROM $type WHERE id=?");
			$stmt->execute(array($id));
			$idExists = $stmt->rowCount() != 0;
		}

		return $id;
	}
}

$lawl = new SuperDatabaseMigrator3000();
$lawl->connectToDatabase();
$lawl->processUsers();
