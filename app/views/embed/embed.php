<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">

		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title>DreamVids</title>

	</head>

	<body class="embeded">

		<script>

			var _currentpage_ = "<?php echo  isset($currentPage) ? $currentPage : 'default'; ?>";

		</script>

		<div id="player">
			<video x-webkit-airplay="allow" autobuffer preload="auto" poster="http://puu.sh/6Tf6f.png"></video>
			<div id="annotationsElement"></div>
			<span id="repeat">
				<span class="icon"></span>
			</span>
			<span id="qualitySelection" class="show"></span>
			<span id="waitForPlay"></span>
			<span id="bigPlay"></span>
			<span id="bigPause"></span>
			<div id="controls">
				<span id="progress">
					<span id="buffered"></span>
					<span id="viewed"></span>
					<span id="current"></span>
				</span>
				<span id="play-pause" class="play"></span>
				<span id="time"></span>
				<a href="http://dreamvids.fr/&t0dnj1" target="_blank" id="DreamVidsIconEmbed"></a>
				<span id="annotationsButton" style="display: none"></span>
				<span id="qualityButton">SD</span>
				<span id="volume">
					<span id="barre"></span>
					<span id="icon"></span>
				</span>
				<span id="separation"></span>
				<span id="widescreen" class="widescreen"></span>
				<span id="fullscreen" class="fullscreen"></span>
			</div>
		</div>

		<script>var embeded = true;</script>
		<script src="<?php echo JS.'player.js'; ?>"></script>

		<script>

			setVideo([

				{

					format: 360,
					mp4: "http://media.jilion.com/videos/demo/midnight_sun_sv1_360p.mp4",
					webm: "http://media.jilion.com/videos/demo/midnight_sun_sv1_360p.webm"

				},

				{

					format: 720,
					mp4: "http://media.jilion.com/videos/demo/midnight_sun_sv1_720p.mp4",
					webm: "http://media.jilion.com/videos/demo/midnight_sun_sv1_720p.webm"

				}

			]);

			setAnnotations([

				{

					text: "Oh une annotation !",
					left: 20, top: 20,
					width: 45, height: 10,
					start: 5, end: 12

				}

			]);

			setVolume(1);

		</script>

	</body>

</html>