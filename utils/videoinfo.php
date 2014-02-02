<?php
header('content-type: text/text/javascript');
include '../includes/bdd.class.php';
include '../classes/Video.php';
if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	if($title) {
		$path = $video->getPath();
		echo "	
		setVideo([
		{
			format: 360,
			mp4: '".$path."_640x360p.mp4',
			webm: '".$path."_640x360p.webm',
			ogg: '".$path."_640x360p.ogg'
		},
		{
			format: 720,
			mp4:'".$path."_1280x720p.mp4',
			webm:'".$path."_1280x720p.webm',
			ogg:'".$path."_1280x720p.ogg'
		}]);
		";
	}
}
?>