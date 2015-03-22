-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `backups`;
CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(10) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `server` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `tech` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `channels_actions`;
CREATE TABLE `channels_actions` (
  `id` varchar(6) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `recipients_ids` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` text NOT NULL,
  `complementary_id` varchar(20),
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `channels_posts`;
CREATE TABLE `channels_posts` (
  `id` varchar(6) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `chat_mutes`;
CREATE TABLE `chat_mutes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `contributors`;
CREATE TABLE `contributors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations` (
  `id` varchar(6) NOT NULL,
  `object` varchar(255) NOT NULL,
  `members_ids` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `event_eggs` (
	`id` VARCHAR(250) NOT NULL,
	`site` VARCHAR(250) NOT NULL DEFAULT 'dreamvids',
	`emplacement` VARCHAR(250) NULL DEFAULT NULL,
	`show_timestamp` BIGINT(20) NOT NULL,
	`points` BIGINT(20) NOT NULL DEFAULT '1',
	`found` TINYINT(1) NOT NULL DEFAULT '0',
	`user_id` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


DROP TABLE IF EXISTS `live_accesses`;
CREATE TABLE `live_accesses` (
  `id` bigint(20) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `key` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` bigint(20) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `stream_name` varchar(255) NOT NULL,
  `viewers` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` varchar(6) NOT NULL,
  `sender_id` varchar(6) NOT NULL,
  `conversation_id` varchar(6) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `modos_actions`;
CREATE TABLE `modos_actions` (
  `id` varchar(6) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `partners`;
CREATE TABLE `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `passwords`;
CREATE TABLE `passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `playlists`;
CREATE TABLE `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `videos_ids` varchar(255) NOT NULL DEFAULT ';',
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pre_inscriptions`;
CREATE TABLE `pre_inscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `utilisateur` tinyint(1) NOT NULL,
  `videaste` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `storage_servers`;
CREATE TABLE `storage_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `critical` tinyint(1) NOT NULL,
  `private_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` varchar(6) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `video_id` varchar(6) NOT NULL,
  `expire` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `subscriptions` text NOT NULL,
  `reg_timestamp` bigint(20) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `actual_ip` varchar(15) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  `settings` text NOT NULL,
  `last_visit` bigint(20) NOT NULL,
  `log_fail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users_channels`;
CREATE TABLE `users_channels` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `admins_ids` text NOT NULL,
  `avatar` longtext NOT NULL,
  `background` longtext NOT NULL,
  `subscribers` int(11) NOT NULL,
  `subs_list` text NOT NULL,
  `views` bigint(20) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users_sessions`;
CREATE TABLE `users_sessions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  `remember` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` varchar(6) NOT NULL,
  `poster_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `tumbnail` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `views` bigint(20) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `visibility` int(11) NOT NULL,
  `flagged` int(11) NOT NULL DEFAULT '0',
  `discover` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos_annot`;
CREATE TABLE `videos_annot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos_comments`;
CREATE TABLE `videos_comments` (
  `id` varchar(6) NOT NULL,
  `poster_id` varchar(6) NOT NULL,
  `video_id` varchar(6) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `last_updated_timestamp` bigint(20) NULL,
  `parent` varchar(6) NOT NULL,
  `flagged` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos_convert`;
CREATE TABLE `videos_convert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` text NOT NULL,
  `sd` int(11) NOT NULL,
  `hd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos_view`;
CREATE TABLE `videos_view` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) NOT NULL,
  `hash` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `videos_votes`;
CREATE TABLE `videos_votes` (
  `id` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(7) NOT NULL,
  `obj_id` varchar(6) NOT NULL,
  `action` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `staff_contact_details` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`tel_1` VARCHAR(50) NULL DEFAULT NULL,
	`tel_2` VARCHAR(50) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`push_bullet_email` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `user_id` (`user_id`)
) ENGINE=InnoDB;

-- 2014-11-17 19:49:15
