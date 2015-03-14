-- MySQL dump 10.13  Distrib 5.5.10, for FreeBSD8.2 (i386)
--
-- Host: localhost    Database: rt
-- ------------------------------------------------------
-- Server version	5.5.10

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

--
-- Table structure for table `element`
--

DROP TABLE IF EXISTS `element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `element` (
  `element_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'text',
  `cols` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `plural` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`element_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` tinyint(3) unsigned NOT NULL,
  `event_date` date NOT NULL,
  `event_note` varchar(100) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_status`
--

DROP TABLE IF EXISTS `event_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_status` (
  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `export_preset`
--

DROP TABLE IF EXISTS `export_preset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `export_preset` (
  `preset_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `ord` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`preset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `form_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `signature` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `valid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`form_id`),
  KEY `valid` (`valid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `form_element`
--

DROP TABLE IF EXISTS `form_element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_element` (
  `fe_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` smallint(5) unsigned NOT NULL,
  `element_id` tinyint(3) unsigned NOT NULL,
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ord` tinyint(4) NOT NULL,
  PRIMARY KEY (`fe_id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `form_response`
--

DROP TABLE IF EXISTS `form_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_response` (
  `response_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(8) unsigned NOT NULL,
  `fe_id` tinyint(3) unsigned NOT NULL,
  `value` text NOT NULL,
  `date_added` date NOT NULL,
  `time_added` time NOT NULL,
  PRIMARY KEY (`response_id`),
  KEY `fe_id` (`fe_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=739 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `preset_element`
--

DROP TABLE IF EXISTS `preset_element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preset_element` (
  `pe_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `preset_id` tinyint(3) unsigned NOT NULL,
  `element_id` tinyint(3) unsigned NOT NULL,
  `ord` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` char(32) NOT NULL,
  `permission_level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `volunteer`
--

DROP TABLE IF EXISTS `volunteer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer` (
  `volunteer_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `preregistered` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `date_added` date NOT NULL,
  `time_added` time NOT NULL,
  PRIMARY KEY (`volunteer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `volunteer_signature`
--

DROP TABLE IF EXISTS `volunteer_signature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_signature` (
  `vs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(9) NOT NULL,
  `signature_date` date NOT NULL,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`vs_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `volunteer_status`
--

DROP TABLE IF EXISTS `volunteer_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_status` (
  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `volunteer_time`
--

DROP TABLE IF EXISTS `volunteer_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_time` (
  `vt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(8) unsigned NOT NULL,
  `service_date` date NOT NULL,
  `duration` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`vt_id`),
  UNIQUE KEY `volunteer_date` (`volunteer_id`,`service_date`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-13 23:28:03
