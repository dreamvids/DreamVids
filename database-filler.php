<?php

/*
*	Little WTF Script by Quadrifoglio
*	Use it to fill a test DreamVids database (version 2)
*/

class DatabaseFiller {
	private $dbHost = 'localhost';
	private $dbUser = 'root';
	private $dbPass = '';
	private $dbName = 'dreamvids_v2';

	private $names = array('Robert', 'Norbert', 'Roger', 'Papidabowi', 'Lawl', 'Dantresangle', 'Jean-Eude', 'Dimou', 'Peter', 'DarkWos', 'Benji', 
		'Jerem', 'Charlie', 'Delta', 'Gwomos', 'Brezh', 'Michel', 'Kass', 'Pierre', 'Snapcube', 'Thib', 'Vincent',
		'Quadri', 'Olivier', 'Carglass', 'Maman', 'Grmble', 'NyanCat', 'Pedobear', 'PedoDream', 'DreamMec', 'DreamTruc', 'DreamBidule');


	public function connectToDatabaseWithAnAwfulTool() {
		mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
		mysql_select_db($this->dbName);
	}

	public function generateUsersAndChannels() {
		foreach ($this->names as $username) {
			mysql_query("INSERT INTO users VALUES (
				'',
				'".$username."',
				'mail@wtf.com',
				'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',
				'',
				'',
				'1398787741',
				'lol.lol.lol.lol',
				'lol.lol.lol.lol',
				'0'
			)");

			$channelId = $this->generateChannelId(6);
			$userId = -1;
			$res = mysql_query("SELECT * FROM users WHERE username='".$username."'");
			while($data = mysql_fetch_array($res, MYSQL_ASSOC)) {
				$userId = $data['id'];
			}

			if($userId != -1) {
				mysql_query("INSERT INTO users_channels VALUES (
					'".$channelId."',
					'".$username."',
					'Chaine de ".$username."',
					'".$userId."',
					'".$userId.";',
					'',
					'',
					'',
					'0',
					'0'
				)");
			}
		}
	}

	public function generateVideos() {
		$res = mysql_query("SELECT * FROM users_channels");

		while($data = mysql_fetch_array($res, MYSQL_ASSOC)) {
			$channelId = $data['id'];
			$channelName = $data['name'];
			$vidsPerUser = 3;

			for($i = 0; $i < $vidsPerUser; $i++) {
				$vidId = $this->generateVideoId(6);
				$posterId = $channelId;
				$vidTitle = 'Video trop cool '.$i.' de '.$channelName;
				$vidDesc = 'Description de la video: '.$vidTitle;
				$vidTags = 'lol lol2';

				mysql_query("INSERT INTO videos VALUES (
					'".$vidId."',
					'".$posterId."',
					'".$vidTitle."',
					'".$vidDesc."',
					'".$vidTags."',
					'lool',
					'0',
					'uploads/".$channelId."/videos/".$vidId.".mp4',
					'0',
					'0',
					'0',
					'1398947680',
					'2',
					'0'
				)");

				mysql_query("INSERT INTO channels_actions VALUES (
					'".$this->generateChannelActionId(6)."',
					'".$posterId."',
					'upload',
					'".$vidId."',
					'1398947680'
				)");
			}
		}
	}

	private function generateChannelId($length) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$id = '';
	
		for ($i = 0; $i < $length - 2; $i++) {
			$id .= $chars[rand(0, strlen($chars) - 1)];
		}

		$id = 'c_'.$id;

		return $id;
	}

	private function generateVideoId($length) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$id = '';
	
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[rand(0, strlen($chars) - 1)];
		}

		return $id;
	}

	private function generateChannelActionId($length) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$id = '';
	
		for ($i = 0; $i < $length - 2; $i++) {
			$id .= $chars[rand(0, strlen($chars) - 1)];
		}

		$id = 'a_'.$id;

		return $id;
	}

}

function letsDoThisMotherFucker() {
	$lawl = new DatabaseFiller();

	$lawl->connectToDatabaseWithAnAwfulTool();
	$lawl->generateUsersAndChannels();
	$lawl->generateVideos();
}

letsDoThisMotherFucker();

?>
