<?php
header('content-type: text/text/javascript');
include '../classes/Video.php';
if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();
	if($title) {
		$path = $video->getPath();
		echo "	
		videoQuality([
		{
			format: 360,
			mp4: '".$path."_360p.mp4',
			webm: '".$path."_360p.webm',
			ogg: '".$path."_360p.ogg'
		},
		{
			format: 720,
			mp4:'".$path."_720p.mp4',
			webm:'".$path."_720p.webm',
			ogg:'".$path."_720p.ogg'
		}]);
		";
	}
}
?>