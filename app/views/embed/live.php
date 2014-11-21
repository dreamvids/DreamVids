<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'video-js.css'; ?>">
		<script src="//vjs.zencdn.net/4.7/video.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />
		<title>DreamVids</title>

		<style>

			html,
			body {

				width: 100%;
				height: 100%;

				padding: 0;
				margin: 0;

			}			

		</style>
	</head>

	<body class="embeded">
		<video id="live-player" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="100%" data-setup='{ "techOrder": ["flash"] }'>
			<source src="rtmp://alpha.dreamvids.fr/stream/<?php echo $chaine; ?>" type="rtmp/flv" />
		</video>
	</body>
</html>