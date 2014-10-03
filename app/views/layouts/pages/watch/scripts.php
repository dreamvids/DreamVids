<script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>

<script src="<?php echo JS."playlist.js"; ?>"></script>
<script src="<?php echo JS.'script.js'; ?>"></script>

<script src="<?php echo JS."utils.js"; ?>"></script>
<script src="<?php echo JS."interactions.js"; ?>"></script>
<script src="<?php echo JS."video.js"; ?>"></script>
<script src="<?php echo JS."comment.js"; ?>"></script>
<script src="<?php echo JS."player.js"; ?>"></script>
<script src="<?php echo JS."subscribe.js"; ?>"></script>
<script src="<?php echo JS.'admin.js'; ?>"></script>
<script src="<?php echo JS.'marmottajax.js'; ?>"></script>

<script>

	setVideo([

		{
			format: 360,
			mp4: "<?php echo $video->url; ?>_640x360p.mp4",
			webm: "<?php echo $video->url; ?>_640x360p.webm"
		},

		{
			format: 720,
			mp4: "<?php echo $video->url; ?>_1280x720p.mp4",
			webm: "<?php echo $video->url; ?>_1280x720p.webm"
		}

	]);
	
	/*setSubTitles([

		{
			text: "Nom Nom Nom Nom",
			start: 0,
			end: 3
		},

		{
			text: "Nom Nom Nom Nom Nom Nom",
			start: 4,
			end: 6
		}

	]);*/

	var _redirectAtEnd = "<?php echo @$nextVideo; ?>";

</script>