-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2015 at 07:36 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zinnov_rti`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_groups`
--

CREATE TABLE IF NOT EXISTS `admin_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive, 3-Deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `admin_groups`
--

INSERT INTO `admin_groups` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `status`) VALUES
(1, 'Super Admin', 'Super Admin', '2015-04-13 06:08:49', NULL, '2015-04-13 11:38:49', NULL, NULL, NULL, 1),
(2, 'Admin', '', '2015-04-12 17:38:53', NULL, '2015-04-12 23:08:53', NULL, NULL, NULL, 1),
(3, 'Test123', 'Test', '2015-04-12 17:39:00', NULL, '2015-04-13 21:17:07', 1, '2015-04-13 21:17:07', 1, 3),
(4, 'DEF', '', '2015-04-12 18:25:54', NULL, '2015-04-14 01:50:47', 1, '2015-04-14 01:50:47', 1, 3),
(5, 'Guest', '', '2015-04-12 20:00:33', NULL, '2015-04-13 21:13:43', NULL, '2015-04-13 21:13:43', NULL, 1),
(6, 'Test', '', '2015-04-12 20:44:29', NULL, '2015-04-13 21:10:30', NULL, '2015-04-13 21:10:30', NULL, 1),
(7, 'Test12356', 'Test', '2015-04-12 20:45:46', 1, '2015-04-13 21:11:28', 1, '2015-04-13 21:11:28', NULL, 2),
(8, 'ABC', 'ABC', '2015-04-13 20:15:43', 1, '2015-04-14 01:45:43', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_group_access`
--

CREATE TABLE IF NOT EXISTS `admin_group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `sub_menu_id` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `access_right` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive, 3-Deleted',
  PRIMARY KEY (`id`),
  KEY `idx_aga_menu_id` (`menu_id`),
  KEY `idx_aga_sub_menu_id` (`sub_menu_id`),
  KEY `idx_aga_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_menus`
--

CREATE TABLE IF NOT EXISTS `admin_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `order_by` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive, 3-Deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_sub_menus`
--

CREATE TABLE IF NOT EXISTS `admin_sub_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `order_by` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive, 3-Deleted',
  PRIMARY KEY (`id`),
  KEY `IDX_asm_menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_groups_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(256) NOT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `last_signin` datetime DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive,3-Deleted',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_au_username` (`username`),
  UNIQUE KEY `IDX_au_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `admin_groups_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_signin`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_by`, `deleted_at`, `status`) VALUES
(1, 1, 'superuser', '$2a$10$65c2626058421e67cfba6uoJfBHkMQaOKfOzz3uWkK/3P1Widk7fO', 'superuser@test.com', NULL, NULL, NULL, '2012-06-05 17:01:57', 1, '2015-04-21 06:31:10', 1, NULL, '0000-00-00 00:00:00', 0),
(3, 1, 'radhika', '$2a$10$03183943e1fc285e6536duTKJEhv2iDj0AU9QMSVMctAgCRIeqxfC', '', NULL, NULL, NULL, '2015-04-21 00:57:19', 1, '2015-04-21 06:27:19', NULL, NULL, '0000-00-00 00:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/* ==================================== 23 april 2015 changes made by Ajey Simha ==============================================*/

CREATE TABLE `articles` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(512) NOT NULL,
 `summary` varchar(512) NOT NULL,
 `content` varchar(2048) NOT NULL,
 `is_featured` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '1->Yes 2->No',
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `created_by` int(11) unsigned NOT NULL,
 `updated_at` datetime DEFAULT NULL,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE  `articles` ADD  `video_id` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `content`;

/* ==================================== 23 april 2015 changes made by Ajey Simha ==============================================*/

/* ==================================== 23 april 2015 changes made by Radhika ==============================================*/
--
-- Table structure for table `admin_sessions`
--

CREATE TABLE IF NOT EXISTS `admin_sessions` (
  `token` varchar(255) NOT NULL,
  `username` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* ==================================== 23 april 2015 changes made by Radhika ==============================================*/
/*==================================== 23 april 2015 changes made by Ajey Simha ============================================*/

ALTER TABLE  `articles` CHANGE  `summary`  `summary` VARCHAR( 2048 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE  `content`  `content` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

	
/* table structure for categories */
CREATE TABLE `categories` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(512) NOT NULL,
 `summary` varchar(2048) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `created_by` int(11) unsigned NOT NULL,
 `updated_at` datetime DEFAULT NULL,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*==================================== 23 april 2015 changes made by Ajey Simha ============================================*/
/* ==================================== 24 april 2015 changes made by Radhika ==============================================*/

ALTER TABLE `articles` ADD `category_id` INT NOT NULL AFTER `id`;
ALTER TABLE `articles` ADD `type_id` TINYINT(1) NOT NULL COMMENT '1:text,2:image,3:video' AFTER `category_id`;
ALTER TABLE `articles` ADD INDEX(`category_id`);
ALTER TABLE `articles` ADD `perma_link` VARCHAR(2048) NULL COMMENT 'Article Perma Link' AFTER `is_featured`;


ALTER TABLE `admin_sessions` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `user_id`;
/* ==================================== 24 april 2015 changes made by Radhika ==============================================*/

/* ==================================== 27 april 2015 changes made by Ajey Simha ==============================================*/
ALTER TABLE `articles` ADD `video_id` VARCHAR( 256 ) NULL DEFAULT NULL AFTER `content`;
ALTER TABLE  `articles` ADD  `featured_image` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `video_id`;

CREATE TABLE `tags` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(512) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `created_by` int(11) unsigned NOT NULL,
 `updated_at` datetime DEFAULT NULL,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE  `articles` ADD  `banner_image` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `featured_image`;
ALTER TABLE  `articles` CHANGE  `featured_image`  `thumbnail_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
/* ==================================== 27 april 2015 changes made by Ajey Simha ==============================================*/

/* ==================================== 27 april 2015 changes made by Radhika ==============================================*/
ALTER TABLE `articles` ADD `view_count` INT NOT NULL DEFAULT '0' AFTER `perma_link`;

/* ==================================== 27 april 2015 changes made by Radhika ==============================================*/

/* ==================================== 28 april 2015 changes made by Ajey Simha ==============================================*/
CREATE TABLE `article_tags` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `article_id` int(11) unsigned NOT NULL,
 `tag_id` int(11) unsigned NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `created_by` int(11) unsigned NOT NULL,
 `updated_at` datetime DEFAULT NULL,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/* ==================================== 28 april 2015 changes made by Ajey Simha ==============================================*/

/* ==================================== 28 april 2015 changes made by Radhika ==============================================*/
ALTER TABLE `articles` ADD INDEX(`category_id`);
ALTER TABLE `articles` ADD  CONSTRAINT `rti_articles_category_id` FOREIGN KEY (`category_id`) REFERENCES `zinnov_rti`.`categories`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

CREATE TABLE `users` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(128) NOT NULL,
 `email` varchar(256) NOT NULL,
 `password` varchar(128) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `modified_at` datetime NOT NULL,
 `status` tinyint(1) NOT NULL COMMENT '1:Active,2:Blocked,3:Deleted',
 `linkedin_id` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `user_sessions` (
 `token` varchar(256) NOT NULL,
 `user_id` int(11) NOT NULL,
 `username` varchar(128) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `expires_at` datetime NOT NULL,
 `ip_address` varchar(20) NOT NULL,
 PRIMARY KEY (`token`)
) ENGINE=InnoDB;
/* ==================================== 28 april 2015 changes made by Radhika ==============================================*/

/* ==================================== 29 april 2015 changes made by Ajey Simha ==============================================*/
ALTER TABLE  `articles` ADD  `featured_image_small` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `is_featured` ,
ADD  `featured_image_large` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `featured_image_small`;
/* ==================================== 29 april 2015 changes made by Ajey Simha ==============================================*/

/* ==================================== 29 april 2015 changes made by Radhika ==============================================*/
ALTER TABLE `users` DROP `username`;
ALTER TABLE `users`
    ADD `activation_key` VARCHAR(256) NULL AFTER `password`,
    ADD `is_activated` BOOLEAN NOT NULL DEFAULT FALSE COMMENT '1: Activated, 0:not activated' AFTER `activation_key`,
    ADD `activated_at` DATETIME NULL AFTER `is_activated`;

ALTER TABLE `users` ADD `activation_key_expires_at` DATETIME NULL AFTER `activation_key`;
ALTER TABLE `users` ADD `first_name` VARCHAR(256) NULL AFTER `password`;
ALTER TABLE `users` ADD `last_name` VARCHAR(256) NULL AFTER `first_name`;

ALTER TABLE `users` ADD `deleted_at` DATETIME NULL AFTER `modified_at`;
ALTER TABLE `users` CHANGE `modified_at` `updated_at` DATETIME NOT NULL;
ALTER TABLE `users` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1:Active,2:Blocked,3:Deleted';

/* ==================================== 29 april 2015 changes made by Radhika ==============================================*/

/* ==================================== 4 may 2015 changes made by Ajey Simha ============================================== */
CREATE TABLE `comments` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `comment` varchar(1024) NOT NULL,
 `article_id` int(11) unsigned NOT NULL,
 `user_id` int(10) unsigned NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


ALTER TABLE  `comments` ADD  `approved_at` DATETIME NULL DEFAULT NULL AFTER  `deleted_by` ,
ADD  `approved_by` INT( 11 ) UNSIGNED NULL DEFAULT NULL AFTER  `approved_at` ,
ADD  `published_at` DATETIME NULL DEFAULT NULL AFTER  `approved_by` ,
ADD  `published_by` INT( 11 ) UNSIGNED NULL DEFAULT NULL AFTER  `published_at`;

ALTER TABLE  `comments` CHANGE  `status`  `status` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '1' COMMENT  '1->Published 2->Deleted';
/* ==================================== 4 may 2015 changes made by Ajey Simha ============================================== */

/* ==================================== 5 may 2015 changes made by Ajey Simha ============================================== */

ALTER TABLE  `users` CHANGE  `linkedin_id`  `linkedin_id` VARCHAR( 32 ) NULL DEFAULT NULL;

ALTER TABLE  `users` ADD  `linkedin_email` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `last_name` ,
ADD  `linkedin_job_title` VARCHAR( 512 ) NULL DEFAULT NULL AFTER  `linkedin_email` ,
ADD  `linkedin_picture_url` VARCHAR( 512 ) NULL DEFAULT NULL AFTER  `linkedin_job_title`;

ALTER TABLE  `users` ADD  `linkedin_profile_url` VARCHAR( 512 ) NULL DEFAULT NULL AFTER  `linkedin_picture_url`;

CREATE TABLE `skills` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(256) NOT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_skills` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(10) unsigned NOT NULL,
 `skill_id` int(11) unsigned NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `rti_user_skills_user_id` (`user_id`),
 KEY `rti_user_skills_skill_id` (`skill_id`),
 CONSTRAINT `rti_user_skills_skill_id` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
 CONSTRAINT `rti_user_skills_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `user_educations` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(10) unsigned NOT NULL,
 `school_name` varchar(256) DEFAULT NULL,
 `degree` varchar(256) DEFAULT NULL,
 `field_of_study` varchar(256) DEFAULT NULL,
 `start_year` varchar(256) DEFAULT NULL,
 `end_year` varchar(256) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `rti_user_educations_user_id` (`user_id`),
 CONSTRAINT `rti_user_educations_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `user_current_positions` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(10) unsigned NOT NULL,
 `title` varchar(256) DEFAULT NULL,
 `summary` varchar(256) DEFAULT NULL,
 `start_month` tinyint(2) unsigned DEFAULT NULL,
 `start_year` int(11) unsigned DEFAULT NULL,
 `company` varchar(512) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `rti_user_current_positions_user_id` (`user_id`),
 CONSTRAINT `rti_user_current_positions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `user_past_positions` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(10) unsigned NOT NULL,
 `title` varchar(256) DEFAULT NULL,
 `summary` varchar(256) DEFAULT NULL,
 `start_month` tinyint(2) unsigned DEFAULT NULL,
 `start_year` int(11) unsigned DEFAULT NULL,
 `end_month` tinyint(2) unsigned DEFAULT NULL,
 `end_year` int(11) unsigned DEFAULT NULL,
 `company` varchar(512) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `rti_user_past_positions_user_id` (`user_id`),
 CONSTRAINT `rti_user_past_positions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/* ==================================== 5 may 2015 changes made by Ajey Simha ============================================== */

/* ==================================== 8 may 2015 changes made by Ajey Simha ============================================== */
ALTER TABLE  `user_sessions` CHANGE  `username`  `email` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
/* ==================================== 8 may 2015 changes made by Ajey Simha ============================================== */

/* ==================================== 11 may 2015 changes made by Ajey Simha ============================================== */
ALTER TABLE  `articles` CHANGE  `thumbnail_image`  `thumbnail_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE  `banner_image`  `banner_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
/* ==================================== 11 may 2015 changes made by Ajey Simha ============================================== */

/* ==================================== 12 may 2015 changes made by Radhika H A ============================================== */

ALTER TABLE `articles` ADD `author_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1 - admin, 2 - User' AFTER `view_count`;
ALTER TABLE `articles` ADD `author_id` INT NULL AFTER `author_type`;

/* ==================================== 13 may 2015 changes made by Ajey Simha S N ============================================== */
ALTER TABLE  `articles` CHANGE  `thumbnail_image`  `thumbnail_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE  `banner_image`  `banner_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE  `articles` ADD  `thumbnail_big_image` VARCHAR( 256 ) NULL DEFAULT NULL AFTER  `thumbnail_image`;
/* ==================================== 13 may 2015 changes made by Ajey Simha S N ============================================== */

/* ==================================== 15 may 2015 changes made by Radhika H A ============================================== */
ALTER TABLE `articles` ADD `share_count` INT NOT NULL DEFAULT '0' AFTER `view_count`;
ALTER TABLE `articles` ADD `fb_share_count` INT NOT NULL DEFAULT '0' AFTER `share_count`,
ADD `twitter_share_count` INT NOT NULL DEFAULT '0' AFTER `fb_share_count`,
ADD `gplus_share_count` INT NOT NULL DEFAULT '0' AFTER `twitter_share_count`,
ADD `linkedin_share_count` INT NOT NULL DEFAULT '0' AFTER `gplus_share_count`;


/* ==================================== 25 may 2015 changes made by Ajey Simha S N ============================================== */
CREATE TABLE `reset_password_histories` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `email` varchar(256) NOT NULL,
 `encryption_key` varchar(256) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Expired',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/* ==================================== 25 may 2015 changes made by Ajey Simha S N ============================================== */

/* ==================================== 26 may 2015 changes made by Radhika ============================================== */
ALTER TABLE `articles`
ADD `published_at` DATETIME NULL DEFAULT NULL AFTER `deleted_by`,
ADD `published_by` INT NULL DEFAULT NULL AFTER `published_at`;
update `articles` set published_at = updated_at;
/* ==================================== 26 may 2015 changes made by Radhika ============================================== */

/* ==================================== 27 may 2015 changes made by Ajey Simha S N ============================================== */
CREATE TABLE `webpages` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(256) NOT NULL,
 `url` varchar(256) NOT NULL,
 `content` varchar(16384) NOT NULL,
 `created_by` int(11) unsigned NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_by` int(11) unsigned DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 `deleted_by` int(11) unsigned DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->Active 2->Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/* ==================================== 27 may 2015 changes made by Ajey Simha S N ============================================== */


/* ==================================== 02 June 2015 changes made by Radhika ============================================== */
--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `summary` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `perma_link` varchar(2048) NOT NULL,
  `vote_up` int(11) NOT NULL DEFAULT '0',
  `vote_down` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_answers`
--

CREATE TABLE IF NOT EXISTS `forum_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_up` int(11) NOT NULL DEFAULT '0',
  `vote_down` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_answer_voters`
--

CREATE TABLE IF NOT EXISTS `forum_answer_voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `forum_answer_id` int(11) NOT NULL,
  `up_voter_id` int(11) NOT NULL,
  `down_voter_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Active, 2: Inactive, ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_voters`
--

CREATE TABLE IF NOT EXISTS `forum_voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `up_voter_id` int(11) NOT NULL,
  `down_voter_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* ==================================== 02 June 2015 changes made by Radhika ============================================== */

/* ==================================== 05 June 2015 changes made by Radhika ============================================== */
ALTER TABLE `forums` ADD `updated_at` DATETIME NULL DEFAULT NULL AFTER `created_at`,
ADD `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

/* ==================================== 10 June 2015 changes made by Radhika ============================================== */
ALTER TABLE `forum_answers` ADD `answer` MEDIUMTEXT NULL AFTER `user_id`;


/* ==================================== 10 June 2015 changes made by Ajey Simha =========================================== */
ALTER TABLE  `zinnov_rti`.`forums` ADD INDEX  `idx_forums_title` (  `title` );
ALTER TABLE  `zinnov_rti`.`forums` ADD INDEX  `idx_forums_summary` (  `summary` ( 4096 ) );
/* ==================================== 10 June 2015 changes made by Ajey Simha =========================================== */

/* ==================================== 12 June 2015 changes made by Ajey Simha =========================================== */
ALTER TABLE  `forum_answers` ADD  `updated_at` DATETIME NULL DEFAULT NULL AFTER  `created_at`;
/* ==================================== 12 June 2015 changes made by Ajey Simha =========================================== */

ALTER TABLE  `forum_voters` ADD  `updated_at` DATETIME NULL DEFAULT NULL AFTER  `created_at`;
ALTER TABLE  `forum_voters` CHANGE  `up_voter_id`  `up_voter_id` INT( 11 ) NULL DEFAULT NULL ,
CHANGE  `down_voter_id`  `down_voter_id` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE  `forum_answer_voters` ADD  `updated_at` DATETIME NULL DEFAULT NULL AFTER  `created_at`;
ALTER TABLE  `forum_answer_voters` CHANGE  `up_voter_id`  `up_voter_id` INT( 11 ) NULL DEFAULT NULL ,
CHANGE  `down_voter_id`  `down_voter_id` INT( 11 ) NULL DEFAULT NULL;

/* ==================================== 16 June 2015 changes made by Radhika ============================================== */
ALTER TABLE  `forum_categories` CHANGE  `deleted_at`  `deleted_at` DATETIME NULL DEFAULT NULL ;
ALTER TABLE  `forum_categories` CHANGE  `deleted_by`  `deleted_by` INT( 11 ) NULL DEFAULT NULL ;



/*========================================== PHASE - II =================================================================*/



/* ==================================== 16 June 2015 changes made by Radhika ============================================== */
ALTER TABLE `users` CHANGE `linkedin_id` `linkedin_id` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `last_name`;
ALTER TABLE `users` ADD `bio` MEDIUMTEXT NULL DEFAULT NULL AFTER `last_name`, ADD `profile_pic` VARCHAR(512) NULL DEFAULT NULL AFTER `bio`;

CREATE TABLE `email_queues` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `subject` varchar(1024) NOT NULL,
 `body` text NOT NULL,
 `email` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `status` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB;

ALTER TABLE `email_queues` ADD `updated_at` DATETIME NULL AFTER `created_at`;

/* ==================================== 09 July 2015 changes made by Radhika ============================================== */
ALTER TABLE `articles` CHANGE `status` `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT '2->Draft 1->Published';

/* ==================================== 16 July 2015 changes made by Radhika ============================================== */
ALTER TABLE `articles` CHANGE `status` `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT '2->Draft 1->Published, 3->Pending for Approval';
ALTER TABLE `articles` ADD `approved_at` DATETIME NULL DEFAULT NULL AFTER `published_by`, ADD `approved_by` INT NULL DEFAULT NULL AFTER `approved_at`;
ALTER TABLE `articles` ADD `rejected_at` DATETIME NULL DEFAULT NULL AFTER `approved_by`, ADD `rejected_by` INT NULL DEFAULT NULL AFTER `rejected_at`
ALTER TABLE `articles` ADD `reasons_for_rejection` VARCHAR(512) NULL DEFAULT NULL AFTER `rejected_by`;
ALTER TABLE `articles` ADD `submitted_image` VARCHAR(1024) NULL DEFAULT NULL AFTER `featured_image_large`;


/* ===================================== 06 August 2015 ,Changes Made By Amit Sabal ========================================= */


--
-- Table structure for table `organizers`
--

CREATE TABLE IF NOT EXISTS `organizers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive',
  `organizer_id` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE IF NOT EXISTS `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postalcode` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive',
  `eb_venue_id` varchar(128) NOT NULL,
  `eb_organizer_id` varchar(100) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

/* ========================================== 07 August 2015 ,Changes Made By Amit Sabal ==================================== */



-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `privacy` tinyint(1) NOT NULL,
  `shareable` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `eb_organizer_id` varchar(50) NOT NULL,
  `eb_venue_id` varchar(50) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `eb_event_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `profile_image` varchar(256) DEFAULT NULL,
  `type` varchar(256) NOT NULL,
  `role` varchar(128) NOT NULL,
  `company` varchar(128) NOT NULL,
  `position` varchar(128) NOT NULL,
  `homepage` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 2-Inactive,3-Deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* ============================================ 10 August 2015 ,Changes Made By Amit Sabal ========================================= */


-- --------------------------------------------------------

--
-- Table structure for table `events_participants`
--

CREATE TABLE IF NOT EXISTS `events_participants` (
  `id` int(11) NOT NULL,
  `participant_id` varchar(36) DEFAULT NULL,
  `event_id` varchar(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events_tickets`
--

CREATE TABLE IF NOT EXISTS `events_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(36) DEFAULT NULL,
  `ticket_id` varchar(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `donation` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `minimum` int(11) NOT NULL,
  `maximum` int(11) NOT NULL,
  `start_sale` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_sale` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Active, 0-Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `eb_ticket_id` varchar(50) NOT NULL,
  `event_id` int(11) NOT NULL,
  `eb_event_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* ============================================== 11 August 2015 ,Changes Made By Amit Sabal ======================================= */

ALTER TABLE `events` ADD `perma_link` VARCHAR(2048) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Event Perma Link' AFTER `shareable`;

/* ============================================== 12 August 2015 ,Changes Made By Amit Sabal ======================================= */

ALTER TABLE `events` ADD `view_count` INT NOT NULL AFTER `perma_link`;

/* ============================================= 13 August 2015 ,Changes Made By Amit Sabal ======================================= */

ALTER TABLE `events` ADD `thumbnail_image` VARCHAR(256) NOT NULL AFTER `view_count`, ADD `banner_image` VARCHAR(256) NOT NULL AFTER `thumbnail_image`;

/* ================================================================================================================================= */

/* ============================================== 13 August 2015 ,Changes Made By Radhika H A ======================================= */
ALTER TABLE `events_participants` ADD PRIMARY KEY(`id`);
ALTER TABLE `events_participants` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;


/* ============================================= 13 August 2015 ,Changes Made By Rahul Anand ======================================= */

ALTER TABLE `participants` ADD `thumbnail_image` VARCHAR(256) NOT NULL AFTER `status`, ADD `banner_image` VARCHAR(256) NOT NULL AFTER `thumbnail_image`;

/* ============================================= 15 August 2015 ,Changes Made By Radhika H A  ======================================= */
ALTER TABLE  `participants` CHANGE  `role`  `role` VARCHAR( 128 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ;
ALTER TABLE  `participants` CHANGE  `created_by`  `created_by` INT( 11 ) NOT NULL DEFAULT  '1';
ALTER TABLE  `participants` CHANGE  `deleted_at`  `deleted_at` DATETIME NULL ;
ALTER TABLE  `participants` CHANGE  `thumbnail_image`  `thumbnail_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
CHANGE  `banner_image`  `banner_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ;
ALTER TABLE  `events` CHANGE  `shareable`  `shareable` TINYINT( 1 ) NULL ;
ALTER TABLE  `events` CHANGE  `view_count`  `view_count` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `events` CHANGE  `thumbnail_image`  `thumbnail_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
CHANGE  `banner_image`  `banner_image` VARCHAR( 256 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ;
ALTER TABLE  `tickets` ADD PRIMARY KEY (  `id` ) ;
ALTER TABLE  `tickets` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;

/* ============================================= 19 August 2015 ,Changes Made By Amit Sabal  ======================================= */
ALTER TABLE `events` ADD `timezone` VARCHAR(150) NOT NULL AFTER `banner_image`, ADD `locale` VARCHAR(50) NOT NULL AFTER `timezone`;

ALTER TABLE `events` ADD `server_time` DATETIME NOT NULL AFTER `eb_event_id`;

ALTER TABLE `venues` CHANGE `postalcode` `postalcode` VARCHAR(50) NOT NULL;


/* ============================================= 1st September 2015 ,Changes Made By Rahul Anand  ======================================= */
ALTER TABLE `forums` ADD `deleted_by` INT(11) UNSIGNED NOT NULL AFTER `deleted_at`;

ALTER TABLE `forums` ADD `status` TINYINT(1) UNSIGNED NOT NULL AFTER `deleted_by`;

/* ============================================= 3rd September 2015 ,Changes Made By Rahul Anand  ======================================= */
ALTER TABLE `forums` CHANGE `status` `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT '1->published, 2->unpublished, 4-> deleted';

/* ============================================= 4th September 2015 ,Changes Made By Radhika H A  ======================================= */
ALTER TABLE `forums` CHANGE `deleted_by` `deleted_by` INT(11) UNSIGNED NULL DEFAULT NULL;

/* ============================================= 8th September 2015 ,Changes Made By Radhika H A  ======================================= */

ALTER TABLE  `admin_users` CHANGE  `deleted_at`  `deleted_at` DATETIME NULL DEFAULT NULL ;

/* ============================================= 9th September 2015 ,Changes Made By Radhika H A  ======================================= */
UPDATE forums SET STATUS =2

/* ============================================= 9th September 2015 ,Changes Made By Amit Sabal  ======================================= */
ALTER TABLE `users` ADD `login_type` VARCHAR(32) NOT NULL AFTER `status`;

/* ============================================= 21st September 2015 ,Changes Made By Radhika H A  ======================================= */
ALTER TABLE `events` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '0 - Draft, 1 - Published, 2 - completed';