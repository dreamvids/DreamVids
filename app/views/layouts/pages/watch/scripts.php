<!-- <script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script> -->

<script src="<?php echo JS."playlist.js"; ?>"></script>
<script src="<?php echo JS.'script.js'; ?>"></script>

<script src="<?php echo JS."utils.js"; ?>"></script>
<script src="<?php echo JS."interactions.js"; ?>"></script>
<script src="<?php echo JS."video.js"; ?>"></script>
<script src="<?php echo JS."comment.js"; ?>"></script>
<!-- <script src="<?php echo JS."player.js"; ?>"></script> -->
<script src="<?php echo JS."dreamplayer.min.js"; ?>"></script>
<script src="<?php echo JS."subscribe.js"; ?>"></script>
<script src="<?php echo JS.'admin.js'; ?>"></script>
<script src="<?php echo JS.'marmottajax.js'; ?>"></script>

<script>

	new DreamPlayer({
	
	    cible: document.getElementById("player-div"),
	    poster: "<?php echo $thumbnail; ?>",
	
	    <?php if (Session::isActive()) {

		echo "source: _last_definition_setting_,";
	    	echo "volume: _last_volume_setting_,";

	    } ?>
	
	    sources: [
	
	        {
	
	            format: 360,
	            text: "SD",
	            mp4: "<?php echo $video->url; ?>_640x360p.mp4",
	            webm: "<?php echo $video->url; ?>_640x360p.webm"
	
	        },
	
	        {
	
	            format: 720,
	            text: "HD",
	            mp4: "<?php echo $video->url; ?>_1280x720p.mp4",
	            webm: "<?php echo $video->url; ?>_1280x720p.webm"
	
	        }
	
	    ]
	
	});


	// var _redirectAtEnd = "<?php echo @$nextVideo; ?>";

<?php if (Session::isActive()) { ?>

	/*setQuality(_last_definition_setting_);
	setVolume(_last_volume_setting_);*/

<?php } ?>

</script>
