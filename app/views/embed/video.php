<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />
		<title>DreamVids</title>
	</head>

	<body class="embeded" style="overflow: hidden;">

		<script>

			var _currentpage_ = "<?php echo  isset($currentPage) ? $currentPage : 'default'; ?>";

		</script>


    	<div id="player-div" class="watch-page-player" style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; overflow: hidden;"></div>

		<script src="<?php echo JS."dreamplayer.min.js"; ?>"></script>
		<script src="<?php echo JS.'marmottajax.js'; ?>"></script>

		<script>

			new DreamPlayer({
			
			    cible: document.getElementById("player-div"),
			    poster: "<?php echo $video->getThumbnail(); ?>",

			    autoplay: <?php echo ($autoplay) ? 'true' : 'false'; ?>,
			    embed: true,
			
			    sources: [
			
			        {
			
			            format: 360,
			            text: "SD",
			            mp4: "<?php echo $url; ?>_640x360p.mp4",
			            webm: "<?php echo $url; ?>_640x360p.webm"
			
			        },
			
			        {
			
			            format: 720,
			            text: "HD",
			            mp4: "<?php echo $url; ?>_1280x720p.mp4",
			            webm: "<?php echo $url; ?>_1280x720p.webm"
			
			        }
			
			    ]
			
			});

		</script>


	</body>

</html>