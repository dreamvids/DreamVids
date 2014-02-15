<?php
header('content-type: text/text/javascript');

include '../includes/bdd.class.php';
include '../classes/Video.php';
include '../classes/Annotation.php';

if(isset($_GET['vid'])) {
	$video = Video::get(htmlentities($_GET['vid']));
	$title = $video->getTitle();

	if($title) {
		$path = $video->getPath();
		$Annotation = Annotation::get(htmlentities($_GET['vid']));
		$Annot = $Annotation->getAnnot();
		$convertion = ConvertionState(htmlentities($_GET['vid']));
		$videojs = '';
		$annotjs = '';
		/*if (count($convertion) > 0) {
			$annotjs .= "setAnnotations([";
			foreach ($Annot as $tmp) {
				$position = explode(";", $tmp['position']);
				$size = explode(";", $tmp['size']);
				$time = explode(";", $tmp['time']);
				$color = '';
				if ($tmp['color'] != "") {
					$color = ", color: '".$tmp['color']."'";
				}
				$annotjs .= '{text: "'.$tmp['txt'].'", left: '.$position[0].', top: '.$position[1].',	width: '.$size[0].', height: '.$size[1].',	start: '.$time[0].', end: '.$time[1].$color.'},';
			}
			$annotjs .= "{}]);";
		}*/

		//if ($convertion[0] == '2' and $convertion[1] == '2') {
			$videojs = "setVideo([{format: 360,	mp4: '".$path."_640x360p.mp4', webm: '".$path."_640x360p.webm'},{format: 720,mp4:'".$path."_1280x720p.mp4', webm:'".$path."_1280x720p.webm'}]);";
	/*	}elseif ($convertion[0] == '2' and $convertion[1] < '2') {
			$videojs = "setVideo([{format: 360,	mp4: '".$path."_640x360p.mp4', webm: '".$path."_640x360p.webm'}]);";
		}elseif ($convertion[0] < '2' and $convertion[1] < '2') {
			$videojs = "setVideo([]);";
			$annotjs = 'setAnnotations([{text: "Video en Cours de Convertion !",left: 0, top: 0, width: 100, height: 100,start: 0, end: 90}]);';
		}
	*/
		
		echo $videojs.$annotjs;

	}
}

function ConvertionState($id){
	$db = new BDD();
    $result = $db->select("*", "videos_convert", "WHERE video_id='".$db->real_escape_string($id)."'") or die(mysql_error());
    $out = array();
    while($row = $db->fetch_array($result)) {
    	$out[0] = array($row['sd'],$row['hd']);
    }
    return $out;
}
?>