
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ese_key`;
CREATE TABLE `ese_key` (
  `esk_id` int(11) NOT NULL AUTO_INCREMENT,
  `esk_make_time` datetime NOT NULL,
  `esk_private_key` varchar(50) NOT NULL,
  `esk_public_key` varchar(50) NOT NULL,
  PRIMARY KEY (`esk_id`),
  UNIQUE KEY `esk_private_key` (`esk_private_key`),
  UNIQUE KEY `esk_public_key` (`esk_public_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ese_word`;
CREATE TABLE `ese_word` (
  `esw_id` int(11) NOT NULL AUTO_INCREMENT,
  `esw_make_time` datetime NOT NULL,
  `esw_key` varchar(50) NOT NULL,
  `esw_public_key` varchar(50) NOT NULL,
  `esw_content` text NOT NULL,
  PRIMARY KEY (`esw_id`),
  KEY `esw_key` (`esw_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `heiso_answer`;
CREATE TABLE `heiso_answer` (
  `han_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `han_make_datetime` datetime NOT NULL COMMENT '作成日時',
  `han_hqu_id` int(11) NOT NULL COMMENT '質問id',
  `han_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名前',
  `han_body` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  PRIMARY KEY (`han_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='回答';


DROP TABLE IF EXISTS `heiso_category`;
CREATE TABLE `heiso_category` (
  `hca_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `hca_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名前',
  PRIMARY KEY (`hca_id`),
  UNIQUE KEY `hca_name` (`hca_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='カテゴリ';


DROP TABLE IF EXISTS `heiso_question`;
CREATE TABLE `heiso_question` (
  `hqu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `hqu_make_datetime` datetime NOT NULL COMMENT '作成日時',
  `hqu_big_hca_id` int(11) NOT NULL COMMENT '大分類id',
  `hqu_mid_hca_id` int(11) NOT NULL COMMENT '中分類id',
  `hqu_low_hca_id` int(11) NOT NULL COMMENT '小分類id',
  `hqu_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名前',
  `hqu_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '質問のキャプション',
  `hqu_body` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  PRIMARY KEY (`hqu_id`),
  UNIQUE KEY `hqu_caption` (`hqu_caption`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='質問';


DROP TABLE IF EXISTS `respeed`;
CREATE TABLE `respeed` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_status` int(11) NOT NULL DEFAULT '1',
  `res_last_updatetime` datetime NOT NULL,
  `res_thread_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `res_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `res_count` int(11) NOT NULL,
  `res_last_number` int(11) NOT NULL,
  `res_sum` int(11) NOT NULL,
  `res_per` int(11) NOT NULL,
  `res_detail` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`res_id`),
  KEY `res_thread_id` (`res_thread_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `rssdata`;
CREATE TABLE `rssdata` (
  `rsd_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsd_datetime` datetime NOT NULL,
  `rsd_rstid` int(11) NOT NULL,
  `rsd_title` varchar(255) NOT NULL,
  `rsd_url` text NOT NULL,
  PRIMARY KEY (`rsd_id`),
  KEY `rsd_rstid` (`rsd_rstid`),
  KEY `rsd_datetime` (`rsd_datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rsserror`;
CREATE TABLE `rsserror` (
  `rse_id` int(11) NOT NULL AUTO_INCREMENT,
  `rse_error` varchar(255) NOT NULL,
  PRIMARY KEY (`rse_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rsstool`;
CREATE TABLE `rsstool` (
  `rst_id` int(11) NOT NULL AUTO_INCREMENT,
  `rst_resistdatetime` datetime NOT NULL,
  `rst_title` varchar(200) NOT NULL,
  `rst_url` varchar(255) NOT NULL,
  `rst_rss` varchar(255) NOT NULL,
  `rst_updatetime` datetime DEFAULT NULL,
  `rst_lastdatetime` datetime NOT NULL,
  `rst_nextdatetime` datetime NOT NULL,
  `rst_lastnum` int(11) NOT NULL,
  `rst_num` int(11) NOT NULL,
  PRIMARY KEY (`rst_id`),
  UNIQUE KEY `rst_title` (`rst_title`),
  UNIQUE KEY `rst_url` (`rst_url`),
  UNIQUE KEY `rst_rss` (`rst_rss`),
  KEY `rst_lastdatetime` (`rst_lastdatetime`),
  KEY `rst_nextdatetime` (`rst_nextdatetime`),
  KEY `rst_num` (`rst_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2020-11-24 06:31:53
