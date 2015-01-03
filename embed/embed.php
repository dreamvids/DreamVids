<!DOCTYPE html>
<html>
<head>
	<title>Embed player</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/player.css">
	<meta charset="UTF-8">
</head>
<body>
	<div id="player">
		<video x-webkit-airplay="allow" autobuffer preload="true" <?php echo isset($_GET['autoplay']) ? 'autoplay' : false ?>>
			<source id="srcMp4" type="video/mp4"/>
			<source id="srcWebm" type="video/webm"/>
		</video>
		<div id="errorLoading"><p>Oops ! Ça n'a pas l'air de fonctionner.<br />Réessayez plus tard ;)</p></div>
		<div id="annotationsElement"></div>
		<span id="repeat">
			<span class="icon"></span>
		</span>
		<span id="qualitySelection" class="show"></span>
		<span id="bigPlay"></span>
		<span id="bigPause"></span>
		<div id="controls">
			<span id="progress">
			<span id="buffered"></span>
			<span id="viewed"></span>
			<span id="current"></span>
			</span>
			<span id="play-pause"></span>
			<span id="time"></span>
			<span id="annotationsButton" style="display: none"></span>
			<span id="qualityButton">SD</span>
			<span id="volume">
			<span id="barre"></span>
			<span id="icon"></span>
			</span>
			<span id="widescreen"></span>
			<span id="fullscreen"></span>
		</div>
	</div>
	<script type="text/javascript" src="js/player.js"></script>
	<?php
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		} else {
			$id = "2rGC0m";
		}
		echo '<script src="http://dreamvids.fr/utils/videoinfo.php?vid='.$id.'"></script>';
	?>
</body>
</html>