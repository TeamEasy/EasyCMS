/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : easycms

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2014-03-04 17:17:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for easy_access
-- ----------------------------
DROP TABLE IF EXISTS `easy_access`;
CREATE TABLE `easy_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) default NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_access
-- ----------------------------

-- ----------------------------
-- Table structure for easy_article
-- ----------------------------
DROP TABLE IF EXISTS `easy_article`;
CREATE TABLE `easy_article` (
  `article_id` int(10) unsigned NOT NULL auto_increment,
  `tid` int(10) unsigned NOT NULL,
  `title` varchar(40) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `pubtime` int(10) unsigned NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `approval` int(10) unsigned NOT NULL,
  `opposition` int(10) unsigned NOT NULL,
  `iscommend` tinyint(1) unsigned NOT NULL,
  `ispush` tinyint(1) unsigned NOT NULL,
  `isslides` tinyint(1) unsigned NOT NULL,
  `islock` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_article
-- ----------------------------

-- ----------------------------
-- Table structure for easy_category
-- ----------------------------
DROP TABLE IF EXISTS `easy_category`;
CREATE TABLE `easy_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(15) NOT NULL default '',
  `pid` int(10) unsigned NOT NULL default '0',
  `sort` int(6) NOT NULL default '100',
  `modelid` tinyint(1) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '1',
  `isverify` tinyint(1) NOT NULL default '1',
  `ispush` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_category
-- ----------------------------

-- ----------------------------
-- Table structure for easy_comment
-- ----------------------------
DROP TABLE IF EXISTS `easy_comment`;
CREATE TABLE `easy_comment` (
  `commend_id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL,
  `aid` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `islock` tinyint(1) unsigned NOT NULL,
  `pubtime` int(11) NOT NULL,
  PRIMARY KEY  (`commend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_comment
-- ----------------------------

-- ----------------------------
-- Table structure for easy_fields
-- ----------------------------
DROP TABLE IF EXISTS `easy_fields`;
CREATE TABLE `easy_fields` (
  `fields_id` int(10) unsigned NOT NULL auto_increment,
  `field` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `issystem` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fields_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_fields
-- ----------------------------
INSERT INTO `easy_fields` VALUES ('1', 'title', '这是一个默认网站标题', '1');
INSERT INTO `easy_fields` VALUES ('2', 'description', '这是一个默认网站描述', '1');
INSERT INTO `easy_fields` VALUES ('3', 'copyright', '这是一个默认网站版权', '1');
INSERT INTO `easy_fields` VALUES ('4', 'announcement', '这是站点公告哦', 1);
INSERT INTO `easy_fields` VALUES ('5', 'ad', '这是一个首页广告', 1);

-- ----------------------------
-- Table structure for easy_link
-- ----------------------------
DROP TABLE IF EXISTS `easy_link`;
CREATE TABLE `easy_link` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `isverify` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_link
-- ----------------------------

-- ----------------------------
-- Table structure for easy_member_user
-- ----------------------------
DROP TABLE IF EXISTS `easy_member_user`;
CREATE TABLE `easy_member_user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(15) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL,
  `photo` char(100) NOT NULL,
  `regtime` int(10) unsigned NOT NULL default '0',
  `regip` char(15) NOT NULL,
  `islock` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_member_user
-- ----------------------------

-- ----------------------------
-- Table structure for easy_node
-- ----------------------------
DROP TABLE IF EXISTS `easy_node`;
CREATE TABLE `easy_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) default NULL,
  `status` tinyint(1) default '0',
  `remark` varchar(255) default NULL,
  `sort` smallint(6) unsigned default NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_node
-- ----------------------------

-- 
-- 表的结构 `easy_plugin`
-- 

DROP TABLE IF EXISTS `easy_plugin`;
CREATE TABLE IF NOT EXISTS `easy_plugin` (
  `plugin_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `desc` varchar(255) NOT NULL default '无',
  `method` varchar(255) NOT NULL,
  `isinstalled` tinyint(1) unsigned NOT NULL default '0',
  `position` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`plugin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `easy_plugin`
-- 


-- ----------------------------
-- Table structure for easy_role
-- ----------------------------
DROP TABLE IF EXISTS `easy_role`;
CREATE TABLE `easy_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) default NULL,
  `status` tinyint(1) unsigned default NULL,
  `remark` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_role
-- ----------------------------

-- ----------------------------
-- Table structure for easy_role_user
-- ----------------------------
DROP TABLE IF EXISTS `easy_role_user`;
CREATE TABLE `easy_role_user` (
  `role_id` mediumint(9) unsigned default NULL,
  `user_id` char(32) default NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_role_user
-- ----------------------------

-- ----------------------------
-- Table structure for easy_user
-- ----------------------------
DROP TABLE IF EXISTS `easy_user`;
CREATE TABLE `easy_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` char(20) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `logintime` int(10) unsigned NOT NULL,
  `loginip` varchar(30) NOT NULL,
  `lock` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of easy_user
-- ----------------------------


