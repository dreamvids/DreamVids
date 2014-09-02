<?php

$liveRecordingsSource = '/tmp/rec/';
$liveRecordingsDestination = '/tmp/rec/';
$liveRecordingsSourceExt = 'flv';

if(!isset($argv)) exit();

if(count($argv) == 3) {
	$type = $argv[1];
	$media = $argv[2];

	switch ($type) {
		case 'video':
			break;

		case 'live-record':
			$input = $liveRecordingsSource.$media.'.'.$liveRecordingsSourceExt;
			$output = $liveRecordingsDestination.$media.'-live.mp4';

			if(file_exists($input) && file_exists($liveRecordingsDestination)) {
				$commandOut = array();
				$exit_code = -1;

				exec('ffmpeg -y -i '.escapeshellarg($input).' -acodec libmp3lame -ar 44100 -ac 1 -vcodec libx264 '.escapeshellarg($output), $output, $exit_code);

				if($exit_code == 0)
					liveRecordConvertedCallback($media);
			}
			break;
		
		default:
			break;
	}
}
else {
	echo 'Usage: php converter.php <action: video|live-record> <media: video-id|live-author>'.PHP_EOL;
}

function videoConvertedCallback($media) {
	//TODO: Move the video to the storage node
	//TODO: Create database entry to set the status of the video as 'converted'
}

function liveRecordConvertedCallback($media) {
	//TODO: Create database entry for the recorded video, tu publish it on dreamvids
}