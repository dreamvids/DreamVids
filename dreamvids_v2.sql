-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 23 Juillet 2014 à 16:16
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `dreamvids_v2`
--

-- --------------------------------------------------------

--
-- Structure de la table `bugs`
--

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `resolution` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `channels_actions`
--

CREATE TABLE IF NOT EXISTS `channels_actions` (
  `id` varchar(6) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `channels_posts`
--

CREATE TABLE IF NOT EXISTS `channels_posts` (
  `id` varchar(6) NOT NULL,
  `channel_id` varchar(6) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contributors`
--

CREATE TABLE IF NOT EXISTS `contributors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `int_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(6) NOT NULL,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modos_actions`
--

CREATE TABLE IF NOT EXISTS `modos_actions` (
  `id` varchar(6) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pre_inscriptions`
--

CREATE TABLE IF NOT EXISTS `pre_inscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `utilisateur` tinyint(1) NOT NULL,
  `videaste` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `followings` text NOT NULL,
  `subscriptions` text NOT NULL,
  `reg_timestamp` bigint(20) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `actual_ip` varchar(15) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users_actions`
--

CREATE TABLE IF NOT EXISTS `users_actions` (
  `id` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users_channels`
--

CREATE TABLE IF NOT EXISTS `users_channels` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `admins_ids` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `background` varchar(255) NOT NULL,
  `subscribers` int(11) NOT NULL,
  `views` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  `remember` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_annot`
--

CREATE TABLE IF NOT EXISTS `videos_annot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_comments`
--

CREATE TABLE IF NOT EXISTS `videos_comments` (
  `id` varchar(6) NOT NULL,
  `poster_id` varchar(6) NOT NULL,
  `video_id` varchar(6) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_convert`
--

CREATE TABLE IF NOT EXISTS `videos_convert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` text NOT NULL,
  `sd` int(11) NOT NULL,
  `hd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_view`
--

CREATE TABLE IF NOT EXISTS `videos_view` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) NOT NULL,
  `hash` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_votes`
--

CREATE TABLE IF NOT EXISTS `videos_votes` (
  `id` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(7) NOT NULL,
  `obj_id` varchar(6) NOT NULL,
  `action` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
