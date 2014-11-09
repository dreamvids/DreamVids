<?php
Config::addValue('dbHost', '127.0.0.1');
Config::addValue('dbUser', 'root');
Config::addValue('dbPass', '');
Config::addValue('dbName', 'dreamvids_v2');

Config::addValue('vid_visibility_private', '0');
Config::addValue('vid_visibility_non_listed', '1');
Config::addValue('vid_visibility_public', '2');
Config::addValue('vid_visibility_suspended', '3');

if (defined('WEBROOT')) {
	Config::addValue('default-avatar', IMG.'default-avatar.png');
	Config::addValue('default-background', IMG.'default-background.png');
	Config::addValue('default-thumbnail', IMG.'default-thumbnail.png');
}

Config::addValue('livestream-source', 'rtmp://192.168.33.10/stream/');
Config::addValue('livechat-address', '192.168.33.10');
Config::addValue('livechat-port', '8080');
