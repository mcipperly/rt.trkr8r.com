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
-- Dumping data for table `export_preset`
--

LOCK TABLES `export_preset` WRITE;
/*!40000 ALTER TABLE `export_preset` DISABLE KEYS */;
INSERT INTO `export_preset` VALUES (1,'Check All',1),(2,'For MailChimp',2);
/*!40000 ALTER TABLE `export_preset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_element`
--

DROP TABLE IF EXISTS `form_element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_element` (
  `element_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'text',
  `cols` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `plural` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ord` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`element_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_element`
--

LOCK TABLES `form_element` WRITE;
/*!40000 ALTER TABLE `form_element` DISABLE KEYS */;
INSERT INTO `form_element` VALUES (1,'firstname','First Name','','text',6,0,1,1),(2,'lastname','Last Name','','text',4,0,1,2),(3,'age','Age','If you are under 18 years of age you must also complete a Parental Permission form','text',2,0,1,3),(4,'company','Affiliation or Company','','text',5,0,0,6),(5,'address1','Address','','text',9,0,1,7),(6,'address2','Apt/Suite/Floor','','text',3,0,0,8),(7,'city','City','','text',7,0,1,9),(8,'state','State','','select',2,0,1,10),(9,'postalcode','ZIP','','text',3,0,1,11),(10,'phone','Phone','','text',3,0,1,5),(11,'email','Email','','text',4,0,1,4),(12,'skills','Home Repair Skills','','text',12,1,0,12),(13,'future_interest','Click here to receive information about future volunteer events','','checkbox',12,0,0,13);
/*!40000 ALTER TABLE `form_element` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_response`
--

DROP TABLE IF EXISTS `form_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_response` (
  `response_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(8) unsigned NOT NULL,
  `element_id` tinyint(3) unsigned NOT NULL,
  `value` text NOT NULL,
  `date_added` date NOT NULL,
  `time_added` time NOT NULL,
  PRIMARY KEY (`response_id`),
  KEY `element_id` (`element_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_response`
--

LOCK TABLES `form_response` WRITE;
/*!40000 ALTER TABLE `form_response` DISABLE KEYS */;
INSERT INTO `form_response` VALUES (104,3,1,'Will','2015-02-21','19:31:14'),(105,3,2,'Hignett','2015-02-21','19:31:14'),(106,3,3,'','2015-02-21','19:31:14'),(107,3,11,'whignett@westminster-church.org','2015-02-21','19:31:14'),(108,3,10,'4128356630','2015-02-21','19:31:14'),(109,3,4,'RTP','2015-02-21','19:31:14'),(110,3,5,'2040 Washington Rd','2015-02-21','19:31:14'),(111,3,6,'','2015-02-21','19:31:14'),(112,3,7,'Pittsburgh','2015-02-21','19:31:14'),(113,3,8,'PA','2015-02-21','19:31:14'),(114,3,9,'15241','2015-02-21','19:31:14'),(115,3,12,'painting','2015-02-21','19:31:14'),(128,5,1,'Matt','2015-02-21','20:02:59'),(129,5,2,'Test','2015-02-21','20:02:59'),(130,5,3,'58','2015-02-21','20:02:59'),(131,5,11,'mc+test@trkr8r.com','2015-02-21','20:02:59'),(132,5,10,'4124124121','2015-02-21','20:02:59'),(133,5,4,'NA','2015-02-21','20:02:59'),(134,5,5,'2206 Milligan','2015-02-21','20:02:59'),(135,5,6,'','2015-02-21','20:02:59'),(136,5,7,'Pittsburgh','2015-02-21','20:02:59'),(137,5,8,'PA','2015-02-21','20:02:59'),(138,5,9,'15218','2015-02-21','20:02:59'),(139,5,12,'cheese; wine; bacon','2015-02-21','20:02:59'),(140,1,11,'mc@tinyatom.net','2015-02-21','20:35:53'),(141,2,11,'chuck@norris.com','2015-02-21','20:36:25'),(142,4,11,'test@email.com','2015-02-21','20:49:36'),(167,8,1,'Not','2015-02-21','22:32:57'),(168,8,2,'Garbage','2015-02-21','22:32:57'),(169,8,3,'48','2015-02-21','22:32:57'),(170,8,11,'notgarbage@what.com','2015-02-21','22:32:57'),(171,8,10,'4124124124','2015-02-21','22:32:57'),(172,8,4,'some','2015-02-21','22:32:57'),(173,8,5,'2206 Milligan Ave','2015-02-21','22:32:57'),(174,8,6,'','2015-02-21','22:32:57'),(175,8,7,'Pittsburgh','2015-02-21','22:32:57'),(176,8,8,'PA','2015-02-21','22:32:57'),(177,8,9,'15222','2015-02-21','22:32:57'),(178,8,12,'guess; what; i\'m; good; at','2015-02-21','22:32:57'),(179,9,1,'Amy','2015-02-21','22:47:01'),(180,9,2,'Lady','2015-02-21','22:47:01'),(181,9,3,'50','2015-02-21','22:47:01'),(182,9,11,'amy@what.com','2015-02-21','22:47:01'),(183,9,10,'4124124124','2015-02-21','22:47:01'),(184,9,4,'NO','2015-02-21','22:47:01'),(185,9,5,'2206 Milligan','2015-02-21','22:47:01'),(186,9,6,'','2015-02-21','22:47:01'),(187,9,7,'Pittsburgh','2015-02-21','22:47:01'),(188,9,8,'PA','2015-02-21','22:47:01'),(189,9,9,'15222','2015-02-21','22:47:01'),(190,9,12,'baking','2015-02-21','22:47:01'),(191,6,1,'Amy','2015-02-22','00:51:44'),(192,6,2,'D','2015-02-22','00:51:44'),(193,6,3,'27','2015-02-22','00:51:44'),(194,6,11,'Amydepalma@gmail.com','2015-02-22','00:51:44'),(195,6,10,'7249531747','2015-02-22','00:51:44'),(196,6,4,'poop','2015-02-22','00:51:44'),(197,6,5,'dsf','2015-02-22','00:51:44'),(198,6,6,'5465','2015-02-22','00:51:44'),(199,6,7,'5465','2015-02-22','00:51:44'),(200,6,8,'PA','2015-02-22','00:51:44'),(201,6,9,'54655','2015-02-22','00:51:44'),(202,6,12,'555','2015-02-22','00:51:44'),(203,7,1,'Test_2','2015-02-22','01:15:41'),(204,7,2,'Man_2','2015-02-22','01:15:41'),(205,7,3,'42','2015-02-22','01:15:41'),(206,7,11,'garbage@what.com','2015-02-22','01:15:41'),(207,7,10,'5135135135','2015-02-22','01:15:41'),(208,7,4,'NOPE','2015-02-22','01:15:41'),(209,7,5,'2206 Milligan Pike','2015-02-22','01:15:41'),(210,7,6,'','2015-02-22','01:15:41'),(211,7,7,'Cincinnati','2015-02-22','01:15:41'),(212,7,8,'OH','2015-02-22','01:15:41'),(213,7,9,'45218','2015-02-22','01:15:41'),(214,7,12,'stuff_b; more_b; things_b','2015-02-22','01:15:41'),(215,10,1,'Test_2','2015-02-22','01:17:23'),(216,10,2,'Man_2','2015-02-22','01:17:23'),(217,10,3,'42','2015-02-22','01:17:23'),(218,10,11,'garbage2@what.com','2015-02-22','01:17:23'),(219,10,10,'5135135135','2015-02-22','01:17:23'),(220,10,4,'NOPE','2015-02-22','01:17:23'),(221,10,5,'2206 Milligan Pike','2015-02-22','01:17:23'),(222,10,6,'','2015-02-22','01:17:23'),(223,10,7,'Cincinnati','2015-02-22','01:17:23'),(224,10,8,'OH','2015-02-22','01:17:23'),(225,10,9,'45218','2015-02-22','01:17:23'),(226,10,12,'stuff_b; more_b; things_b','2015-02-22','01:17:23'),(227,11,1,'Matt','2015-02-22','01:30:26'),(228,11,2,'Cipperly','2015-02-22','01:30:26'),(229,11,3,'28','2015-02-22','01:30:26'),(230,11,11,'mc+two@tinyatom.net','2015-02-22','01:30:26'),(231,11,10,'4122568565','2015-02-22','01:30:26'),(232,11,4,'NO','2015-02-22','01:30:26'),(233,11,5,'2206 Milligan','2015-02-22','01:30:26'),(234,11,6,'','2015-02-22','01:30:26'),(235,11,7,'Pittsburgh','2015-02-22','01:30:26'),(236,11,8,'PA','2015-02-22','01:30:26'),(237,11,9,'15222','2015-02-22','01:30:26'),(238,11,12,'building','2015-02-22','01:30:26'),(239,12,1,'Matt','2015-02-22','01:30:57'),(240,12,2,'Cipperly','2015-02-22','01:30:57'),(241,12,3,'30','2015-02-22','01:30:57'),(242,12,11,'mc+three@tinyatom.net','2015-02-22','01:30:57'),(243,12,10,'4122568565','2015-02-22','01:30:57'),(244,12,4,'NO','2015-02-22','01:30:57'),(245,12,5,'2206 Milligan','2015-02-22','01:30:57'),(246,12,6,'','2015-02-22','01:30:57'),(247,12,7,'Pittsburgh','2015-02-22','01:30:57'),(248,12,8,'PA','2015-02-22','01:30:57'),(249,12,9,'15222','2015-02-22','01:30:57'),(250,12,12,'construction','2015-02-22','01:30:57'),(251,13,1,'bill ','2015-02-22','02:23:05'),(252,13,2,'cheese ','2015-02-22','02:23:05'),(253,13,3,'50','2015-02-22','02:23:05'),(254,13,11,'mc+5@tinyatom.net','2015-02-22','02:23:05'),(255,13,10,'4124320712','2015-02-22','02:23:05'),(256,13,4,'NA','2015-02-22','02:23:05'),(257,13,5,'19 Hot Metal Street','2015-02-22','02:23:05'),(258,13,6,'5th Floor','2015-02-22','02:23:05'),(259,13,7,'Pittsburgh','2015-02-22','02:23:05'),(260,13,8,'PA','2015-02-22','02:23:05'),(261,13,9,'15203','2015-02-22','02:23:05'),(262,13,12,'bacon; eggs','2015-02-22','02:23:05'),(263,14,1,'Matt','2015-02-22','02:24:52'),(264,14,2,'Cipperly','2015-02-22','02:24:52'),(265,14,3,'48','2015-02-22','02:24:52'),(266,14,11,'mc+6@trkr8r.com','2015-02-22','02:24:52'),(267,14,10,'14124320712','2015-02-22','02:24:52'),(268,14,4,'Sr. Systems Administrator','2015-02-22','02:24:52'),(269,14,5,'19 Hot Metal St.','2015-02-22','02:24:52'),(270,14,6,'','2015-02-22','02:24:52'),(271,14,7,'Pittsburgh','2015-02-22','02:24:52'),(272,14,8,'PA','2015-02-22','02:24:52'),(273,14,9,'15203','2015-02-22','02:24:52'),(274,14,12,'bacon; eggs; ham; steak','2015-02-22','02:24:52'),(275,15,1,'Matt','2015-02-22','02:58:34'),(276,15,2,'Cipperly','2015-02-22','02:58:34'),(277,15,3,'28','2015-02-22','02:58:34'),(278,15,11,'mc+8@tinyatom.net','2015-02-22','02:58:34'),(279,15,10,'4124324543','2015-02-22','02:58:34'),(280,15,4,'NA','2015-02-22','02:58:34'),(281,15,5,'19 Hot Metal Street','2015-02-22','02:58:34'),(282,15,6,'5th Floor','2015-02-22','02:58:34'),(283,15,7,'Pittsburgh','2015-02-22','02:58:34'),(284,15,8,'PA','2015-02-22','02:58:34'),(285,15,9,'15203','2015-02-22','02:58:34'),(286,15,12,'cheesemaking','2015-02-22','02:58:34'),(287,16,1,'Lady','2015-02-22','03:46:23'),(288,16,2,'Person','2015-02-22','03:46:23'),(289,16,3,'27','2015-02-22','03:46:23'),(290,16,11,'amy@amymade.net','2015-02-22','03:46:23'),(291,16,10,'7249531747','2015-02-22','03:46:23'),(292,16,4,'','2015-02-22','03:46:23'),(293,16,5,'2206 Milligan Avenue','2015-02-22','03:46:23'),(294,16,6,'','2015-02-22','03:46:23'),(295,16,7,'Pittsburgh','2015-02-22','03:46:23'),(296,16,8,'PA','2015-02-22','03:46:23'),(297,16,9,'15218','2015-02-22','03:46:23'),(298,16,12,'Painting; Scrubbing Things; Cleaning','2015-02-22','03:46:23');
/*!40000 ALTER TABLE `form_response` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preset_element`
--

LOCK TABLES `preset_element` WRITE;
/*!40000 ALTER TABLE `preset_element` DISABLE KEYS */;
/*!40000 ALTER TABLE `preset_element` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'mc@tinyatom.net','cc03e747a6afbbcbf8be7668acfebee5',0,'2015-02-22 00:31:08'),(6,'rob','098f6bcd4621d373cade4e832627b4f6',0,'2015-02-22 04:01:07'),(4,'amy','098f6bcd4621d373cade4e832627b4f6',0,'2015-02-22 01:22:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer`
--

LOCK TABLES `volunteer` WRITE;
/*!40000 ALTER TABLE `volunteer` DISABLE KEYS */;
INSERT INTO `volunteer` VALUES (1,'mc@tinyatom.net',0,2,'2015-02-21','18:10:31'),(2,'chuck@norris.com',0,2,'2015-02-21','18:44:16'),(3,'whignett@westminster-church.org',0,2,'2015-02-21','19:31:14'),(4,'test@email.com',0,2,'2015-02-21','19:32:16'),(5,'mc+test@trkr8r.com',0,2,'2015-02-21','20:02:59'),(6,'Amydepalma@gmail.com',0,3,'2015-02-21','20:50:45'),(7,'garbage@what.com',0,3,'2015-02-21','22:30:35'),(8,'notgarbage@what.com',0,2,'2015-02-21','22:32:57'),(9,'amy@what.com',0,2,'2015-02-21','22:47:01'),(10,'garbage2@what.com',0,3,'2015-02-22','01:17:23'),(11,'mc+two@tinyatom.net',0,2,'2015-02-22','01:30:26'),(12,'mc+three@tinyatom.net',0,2,'2015-02-22','01:30:57'),(13,'mc+5@tinyatom.net',0,1,'2015-02-22','02:23:05'),(14,'mc+6@trkr8r.com',0,1,'2015-02-22','02:24:52'),(15,'mc+8@tinyatom.net',0,3,'2015-02-22','02:58:34'),(16,'amy@amymade.net',0,2,'2015-02-22','03:46:23');
/*!40000 ALTER TABLE `volunteer` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_signature`
--

LOCK TABLES `volunteer_signature` WRITE;
/*!40000 ALTER TABLE `volunteer_signature` DISABLE KEYS */;
INSERT INTO `volunteer_signature` VALUES (1,7,'2015-02-21','Signature-TestMan-20150221.png'),(2,10,'2015-02-22','Signature-Test_2Man_2-20150222.png'),(3,15,'2015-02-22','Signature-MC-20150222.png'),(4,6,'2015-02-22','Signature-AD-20150222.png');
/*!40000 ALTER TABLE `volunteer_signature` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `volunteer_status`
--

LOCK TABLES `volunteer_status` WRITE;
/*!40000 ALTER TABLE `volunteer_status` DISABLE KEYS */;
INSERT INTO `volunteer_status` VALUES (1,'Unregistered'),(2,'Unsigned'),(3,'Signed');
/*!40000 ALTER TABLE `volunteer_status` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_time`
--

LOCK TABLES `volunteer_time` WRITE;
/*!40000 ALTER TABLE `volunteer_time` DISABLE KEYS */;
INSERT INTO `volunteer_time` VALUES (5,10,'2015-02-22',3.00),(6,15,'2015-02-22',4.00),(8,7,'2015-02-21',8.00);
/*!40000 ALTER TABLE `volunteer_time` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-22  5:09:49
