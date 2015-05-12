<!-- <script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script> -->

<script src="<?php echo JS."playlist.js"; ?>"></script>
<script src="<?php echo JS.'script.js'; ?>"></script>

<script src="<?php echo JS."utils.js"; ?>"></script>
<script src="<?php echo JS."interactions.js"; ?>"></script>
<script src="<?php echo JS."video.js"; ?>"></script>
<script src="<?php echo JS."comment.js"; ?>"></script>
<!-- <script src="<?php echo JS."player.js"; ?>"></script> -->
<script src="<?php echo JS."dreamplayer.min.js?r=2"; ?>"></script>
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

	    <?php if (isset($nextVideo)) {

		echo 'redirectAtEnd: "' . @$nextVideo . '",';

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


	marmottajax(_webroot_ + 'videos/<?php echo $video->id; ?>/status').then(
			function(data){
				data = JSON.parse(data);
				switch (data.sd.status) {
				case "no" : console.log('No resolution availlable yet');
					break;
				case "doing" : console.log('SD may not be totally done');
					break;
				case "ok" : console.log('SD fully availlable... Checking HD');
					switch (data.hd.status) {
						case "no" : console.log('No hd availiable yet, but sd is ok');
							break;
						case "doing" : console.log('HD may not be totally done');
							break;
						case "ok" : console.log('HD fully availiable');
					}
				}					
			}
	);

</script>
