<?php
$liveRecordingsSource = '/tmp/rec/';
$liveRecordingsDestination = '/tmp/rec/';
$liveRecordingsSourceExt = 'flv';

if(!isset($argv)) exit();

if(count($argv) >= 4 && count($argv) <= 5) {
	$type = $argv[2];
	$media = $argv[3];
	$quality = $argv[4];

	switch ($type) {
		case 'video':
			$splited = explode('/', $media);
			$filename = $splited[count($splited)-1];
			$channelId = $splited[count($splited)-2];
			$resolution = ($quality == 'hd') ? '19200x1080p' : '640x360p';
			$url = StorageServer::backup($filename.'_'.$resolution.'.mp4', $channelId, true);
			$url = StorageServer::backup($filename.'_'.$resolution.'.webm', $channelId, true);
			StorageServer::unlockFreestServer();
			break;

		case 'live-record':
			$input = $liveRecordingsSource.$media.'.'.$liveRecordingsSourceExt;
			$output = $liveRecordingsDestination.$media.'-live.mp4';

			if(file_exists($input) && file_exists($liveRecordingsDestination)) {
				$commandOut = array();
				$exit_code = -1;

				exec('ffmpeg -y -i '.escapeshellarg($input).' -acodec libmp3lame -ar 44100 -ac 1 -vcodec libx264 '.escapeshellarg($output), $output, $exit_code);

				if($exit_code == 0) {
					liveRecordConvertedCallback($media);
				}
			}
			break;
	}
}
else {
	echo 'Usage: php converter.php <action: video|live-record> <media: video-id|live-author> [quality: sd|hd]'.PHP_EOL;
}

function liveRecordConvertedCallback($media) {
	//TODO: Create database entry for the recorded video, tu publish it on dreamvids
}
