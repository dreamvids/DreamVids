<?php
class StorageServer extends ActiveRecord\Model {

	static $table_name = 'storage_servers';
	static $filepath = 'server.json';
	
	public static function backup($filename, $channelId, $removeAfterBackup = false) {
		$distantpath = '/var/www/';
		
		$serv = StorageServer::getFreestServer();
		if ($serv !== false) {
			$hash = hash_hmac('sha256', $serv->address, $serv->private_key);
			$err = file_get_contents($serv->address.'mkdir.php?cid='.$channelId.'&hash='.$hash);
			if ($err == 0) {
				$relativepath = "uploads/$channelId/$filename";
				$filepath = ROOT.$relativepath;
				$addr = preg_replace("#^https?://([a-zA-Z0-9.-]+)(/.*)?$#", "$1", $serv->address);
				shell_exec("scp $filepath www-data@$addr:$distantpath$relativepath");
				if ($removeAfterBackup) {
					unlink($filepath);
				}
				
				if (class_exists('Backup')) {
					Backup::create(array(
						'channel_id' => $channelId,
						'filepath' => $filepath,
						'server' => $serv->address
					));
				}
			}
		}
		
		return $serv->address.$relativepath;
	}

	public static function setFreestServer() {
		$best = array (
			'id' => 0,
			'address' => null,
			'private_key' => null,
			'free_space' => 0
		);
		
		if (!StorageServer::isFreestServerLocked()) {
			$servers = StorageServer::all(array('conditions' => 'critical=0'));
			
			foreach ($servers as $serv) {
				$opts = array('http' =>
					array(
						'method'  => 'GET',
						'timeout' => 5
					)
				);
				
				$context  = stream_context_create($opts);
				$content = @file_get_contents($serv->address.'index.php', null, $context);
				
				if ($content !== false) {
					if ($content == 'CRITICAL_ALERT') {
						$serv->critical = 1;
						$serv->save();
					}
					else {
						if ($content > $best['free_space']) {
							$best = array(
								'id' => $serv->id,
								'address' => $serv->address,
								'private_key' => $serv->private_key,
								'free_space' => $content
							);
						}
					}
				}
			}
		}

		return $best['id'];
	}
	
	public static function getFreestServer() {
		$serv = json_decode(file_get_contents(CACHE.self::$filepath));
		return ($serv->id != 0) ? StorageServer::find($serv->id) : false;
	}
	
	public static function lockFreestServer() {
		$serv = json_decode(file_get_contents(CACHE.self::$filepath));
		if ($serv != null) {
			$serv->in_use++;
			file_put_contents(CACHE.self::$filepath, json_encode($serv));
		}
	}
	
	public static function unlockFreestServer() {
		$serv = json_decode(file_get_contents(CACHE.self::$filepath));
		if ($serv != null) {
			$serv->in_use = ($serv->in_use > 0) ? $serv->in_use - 1 : 0;
			file_put_contents(CACHE.self::$filepath, json_encode($serv));
		}
	}
	
	public static function isFreestServerLocked() {
		$serv = (file_exists(CACHE.self::$filepath)) ? json_decode(file_get_contents(CACHE.self::$filepath)) : array('in_use' => 0);
		return (@$serv->in_use > 0);
	}
}