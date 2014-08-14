<?php

Config::addValue('vid_visibility_private', '0');
Config::addValue('vid_visibility_non_listed', '1');
Config::addValue('vid_visibility_public', '2');
Config::addValue('vid_visibility_suspended', '3');

Config::addValue('default-avatar', IMG.'default-avatar.png');
Config::addValue('default-background', IMG.'default-background.jpg');
Config::addValue('default-thumbnail', IMG.'default-thumbnail.png');

Config::addValue('livestream-source', 'rtmp://192.168.56.101/live/');