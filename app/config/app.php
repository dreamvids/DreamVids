<?php
Config::addValue('dbHost', '127.0.0.1');
Config::addValue('dbUser', 'root');
Config::addValue('dbPass', '');
Config::addValue('dbName', 'dreamvids_v2');

Config::addValue('vid_visibility_private', '0');
Config::addValue('vid_visibility_non_listed', '1');
Config::addValue('vid_visibility_public', '2');
Config::addValue('vid_visibility_suspended', '3');

Config::addValue("recaptcha_public", "6Lcd4f4SAAAAAOkSp8erYm27K2FE5x6e16gmb-en"); // <- Change them on prod (ask Snap)
Config::addValue("recaptcha_private", "6Lcd4f4SAAAAABSaIe3Oc3xjVPfe2uLFMXZrTTHY"); 

if (defined('WEBROOT')) {
	Config::addValue('default-avatar', IMG.'default-avatar.png');
	Config::addValue('default-background', IMG.'default-background.png');
	Config::addValue('default-thumbnail', IMG.'default-thumbnail.png');
}

Config::addValue('livestream-source', 'rtmp://192.168.33.10/stream/');
Config::addValue('livechat-address', '192.168.33.10');
Config::addValue('livechat-port', '8080');

Config::addValue("time_between_comments", "10"); //seconds

Config::addValue("max_login_try", "10"); 
Config::addValue("login_fail_intervalle", "20"); //seconds
Config::addValue("login_fail_wait", 5*60); //seconds (5min)

//Pushover part
Config::addValue("po_all", "a-pushover-group-key");
Config::addValue("po_dev", "dev-team-key");
Config::addValue("po_sys", "sysadmin-team-key");
Config::addValue("po_others", "some-other-group-key");