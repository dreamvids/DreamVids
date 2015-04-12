<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- <link href="//vjs.zencdn.net/4.7/video-js.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'video-js.css'; ?>">
<script src="//vjs.zencdn.net/4.7/video.js"></script>
<script>
	videojs('live-player').ready(function(){
	  var myPlayer = this; 
	  myPlayer.play();
	});
</script>