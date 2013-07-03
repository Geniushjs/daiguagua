-- MySQL dump 10.11
--
-- Host: localhost    Database: daiguagua
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

CREATE DATABASE IF NOT EXISTS daigua;
USE daigua;

--
-- Definition of table `guolanr`.`auth_group`
--

DROP TABLE IF EXISTS `daigua`.`class`;
CREATE TABLE  `daigua`.`class` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sortorder` int(11) NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `daigua`.`soft`;
CREATE TABLE  `daigua`.`soft` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sortorder` int(11) NOT NULL DEFAULT 0,
  `deadlink` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `version` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pageurl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `daigua`.`label`;
CREATE TABLE  `daigua`.`label` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `label_soft_fk` (`sid`),
  KEY `label_class_fk` (`cid`),
  UNIQUE KEY `label_soft_class_pair` (`sid`, `cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `daigua`.`user`;
CREATE TABLE  `daigua`.`user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `valid` int(11) NOT NULL DEFAULT 1,
  `level` int(11) NOT NULL DEFAULT 2,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  UNIQUE KEY `user_name` (`name`),
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `daigua`.`class` VALUES (1, '装机必备', 'default.gif', 100, 1);
INSERT INTO `daigua`.`user` VALUES (1, 1, 1, 'daigua', 'eb0aeb33ee77690dd64f7012bbdd7ecb');

-- Dump completed on 2013-02-02 16:50:53
