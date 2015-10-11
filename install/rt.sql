-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2015 at 04:14 PM
-- Server version: 5.5.10
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rt`
--
CREATE DATABASE IF NOT EXISTS `rt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rt`;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(70) NOT NULL,
  `contact_details` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `date_added` date NOT NULL,
  PRIMARY KEY (`company_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `element_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'text',
  `cols` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `plural` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`element_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `element`
--

INSERT INTO `element` (`element_id`, `name`, `label`, `description`, `type`, `cols`, `plural`) VALUES
(1, 'firstname', 'First Name', '', 'text', 6, 0),
(2, 'lastname', 'Last Name', '', 'text', 4, 0),
(3, 'age', 'Age', 'If you are under 18 years of age, please click <a href="./under-18.php">here</a>.', 'text', 2, 0),
(4, 'company', 'Affiliation or Company', '', 'company', 5, 0),
(5, 'address1', 'Address', '', 'text', 9, 0),
(6, 'address2', 'Apt/Suite/Floor', '', 'text', 3, 0),
(7, 'city', 'City', '', 'text', 7, 0),
(8, 'state', 'State', '', 'select', 2, 0),
(9, 'postalcode', 'ZIP', '', 'text', 3, 0),
(10, 'phone', 'Phone', '', 'text', 5, 0),
(11, 'email', 'Email', '', 'text', 7, 0),
(12, 'skills', 'Home Repair Skills', '', 'select', 12, 1),
(13, 'future_interest', 'Click here to receive information about future volunteer opportunities', '', 'checkbox', 12, 0),
(14, 'newsletter', 'Click here to receive a newsletter & special mailings from RT Pittsburgh', '', 'checkbox', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `note` text NOT NULL,
  `location` varchar(150) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_status`
--

DROP TABLE IF EXISTS `event_status`;
CREATE TABLE IF NOT EXISTS `event_status` (
  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_status`
--

INSERT INTO `event_status` (`status_id`, `name`) VALUES
(1, 'Open'),
(2, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `export_preset`
--

DROP TABLE IF EXISTS `export_preset`;
CREATE TABLE IF NOT EXISTS `export_preset` (
  `preset_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `ord` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`preset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `export_preset`
--

INSERT INTO `export_preset` (`preset_id`, `name`, `ord`) VALUES
(1, 'All Fields', 1),
(2, 'For Email', 2),
(3, 'For Physical Mail', 3);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE IF NOT EXISTS `form` (
  `form_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `signature` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`form_id`),
  KEY `valid` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `name`, `title`, `signature`, `active`) VALUES
(1, 'Volunteer Registration', 'Registration', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_element`
--

DROP TABLE IF EXISTS `form_element`;
CREATE TABLE IF NOT EXISTS `form_element` (
  `fe_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` smallint(5) unsigned NOT NULL,
  `element_id` tinyint(3) unsigned NOT NULL,
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ord` tinyint(4) NOT NULL,
  PRIMARY KEY (`fe_id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `form_element`
--

INSERT INTO `form_element` (`fe_id`, `form_id`, `element_id`, `required`, `ord`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 2),
(3, 1, 3, 1, 3),
(5, 1, 5, 1, 7),
(6, 1, 6, 0, 8),
(7, 1, 7, 1, 9),
(8, 1, 8, 1, 10),
(9, 1, 9, 1, 11),
(10, 1, 10, 1, 5),
(11, 1, 11, 1, 4),
(12, 1, 12, 0, 12),
(13, 1, 13, 0, 14),
(14, 1, 14, 0, 13);

-- --------------------------------------------------------

--
-- Table structure for table `form_response`
--

DROP TABLE IF EXISTS `form_response`;
CREATE TABLE IF NOT EXISTS `form_response` (
  `response_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(8) unsigned NOT NULL,
  `fe_id` tinyint(3) unsigned NOT NULL,
  `value` text NOT NULL,
  `date_added` date NOT NULL,
  `time_added` time NOT NULL,
  PRIMARY KEY (`response_id`),
  KEY `fe_id` (`fe_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `preset_element`
--

DROP TABLE IF EXISTS `preset_element`;
CREATE TABLE IF NOT EXISTS `preset_element` (
  `pe_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `preset_id` tinyint(3) unsigned NOT NULL,
  `element_id` tinyint(3) unsigned NOT NULL,
  `ord` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pe_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `preset_element`
--

INSERT INTO `preset_element` (`pe_id`, `preset_id`, `element_id`, `ord`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 3),
(4, 1, 11, 4),
(5, 1, 10, 5),
(6, 1, 4, 6),
(7, 1, 5, 7),
(8, 1, 6, 8),
(9, 1, 7, 9),
(10, 1, 8, 10),
(11, 1, 9, 11),
(12, 1, 12, 12),
(13, 1, 13, 13),
(14, 2, 1, 1),
(15, 2, 2, 2),
(16, 2, 11, 3),
(17, 2, 13, 4),
(25, 3, 6, 4),
(24, 3, 5, 3),
(23, 3, 2, 2),
(22, 3, 1, 1),
(26, 3, 7, 5),
(27, 3, 8, 6),
(28, 3, 9, 7);

-- --------------------------------------------------------

--
-- Table structure for table `select_element`
--

DROP TABLE IF EXISTS `select_element`;
CREATE TABLE IF NOT EXISTS `select_element` (
  `se_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `element_id` tinyint(3) unsigned NOT NULL,
  `text` varchar(100) NOT NULL,
  PRIMARY KEY (`se_id`),
  KEY `element_id` (`element_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `select_element`
--

INSERT INTO `select_element` (`se_id`, `active`, `element_id`, `text`) VALUES
(1, 1, 8, 'AL'),
(2, 1, 8, 'AK'),
(3, 1, 8, 'AZ'),
(4, 1, 8, 'AR'),
(5, 1, 8, 'CA'),
(6, 1, 8, 'CO'),
(7, 1, 8, 'CT'),
(8, 1, 8, 'DE'),
(9, 1, 8, 'DC'),
(10, 1, 8, 'FL'),
(11, 1, 8, 'GA'),
(12, 1, 8, 'HI'),
(13, 1, 8, 'ID'),
(14, 1, 8, 'IL'),
(15, 1, 8, 'IN'),
(16, 1, 8, 'IA'),
(17, 1, 8, 'KS'),
(18, 1, 8, 'KY'),
(19, 1, 8, 'LA'),
(20, 1, 8, 'ME'),
(21, 1, 8, 'MD'),
(22, 1, 8, 'MA'),
(23, 1, 8, 'MI'),
(24, 1, 8, 'MN'),
(25, 1, 8, 'MS'),
(26, 1, 8, 'MO'),
(27, 1, 8, 'MT'),
(28, 1, 8, 'NE'),
(29, 1, 8, 'NV'),
(30, 1, 8, 'NH'),
(31, 1, 8, 'NJ'),
(32, 1, 8, 'NM'),
(33, 1, 8, 'NY'),
(34, 1, 8, 'NC'),
(35, 1, 8, 'ND'),
(36, 1, 8, 'OH'),
(37, 1, 8, 'OK'),
(38, 1, 8, 'OR'),
(39, 1, 8, 'PA'),
(40, 1, 8, 'PR'),
(41, 1, 8, 'RI'),
(42, 1, 8, 'SC'),
(43, 1, 8, 'SD'),
(44, 1, 8, 'TN'),
(45, 1, 8, 'TX'),
(46, 1, 8, 'UT'),
(47, 1, 8, 'VT'),
(48, 1, 8, 'VA'),
(49, 1, 8, 'WA'),
(50, 1, 8, 'WV'),
(51, 1, 8, 'WI'),
(52, 1, 8, 'WY'),
(53, 1, 12, 'Carpentry'),
(54, 1, 12, 'Masonry'),
(55, 1, 12, 'Electrical'),
(56, 1, 12, 'Plumbing'),
(57, 1, 12, 'Drywall'),
(58, 1, 12, 'Flooring'),
(59, 1, 12, 'Cleaning'),
(60, 1, 12, 'Landscaping'),
(61, 1, 12, 'Painting');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` char(32) NOT NULL,
  `permission_level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `permission_level`, `last_updated`) VALUES
(1, 'mc@tinyatom.net', 'cc03e747a6afbbcbf8be7668acfebee5', 0, '2015-02-22 00:31:08'),
(4, 'amy', '098f6bcd4621d373cade4e832627b4f6', 0, '2015-02-22 01:22:07'),
(7, 'matt', '098f6bcd4621d373cade4e832627b4f6', 0, '2015-02-22 10:22:39'),
(9, 'rob', '098f6bcd4621d373cade4e832627b4f6', 0, '2015-07-27 20:24:41'),
(11, 'new_user', '22af645d1859cb5ca6da0c484f1f37ea', 0, '2015-07-27 20:26:48'),
(12, 'Rtp', '098f6bcd4621d373cade4e832627b4f6', 0, '2015-07-28 12:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

DROP TABLE IF EXISTS `volunteer`;
CREATE TABLE IF NOT EXISTS `volunteer` (
  `volunteer_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `company_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `preregistered` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `date_added` date NOT NULL,
  `time_added` time NOT NULL,
  PRIMARY KEY (`volunteer_id`),
  UNIQUE KEY `email` (`email`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_event`
--

DROP TABLE IF EXISTS `volunteer_event`;
CREATE TABLE IF NOT EXISTS `volunteer_event` (
  `ve_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` mediumint(8) unsigned NOT NULL,
  `event_id` mediumint(8) unsigned NOT NULL,
  `signature_file_name` varchar(255) DEFAULT NULL,
  `duration` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ve_id`),
  UNIQUE KEY `volunteer_event` (`volunteer_id`,`event_id`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_status`
--

DROP TABLE IF EXISTS `volunteer_status`;
CREATE TABLE IF NOT EXISTS `volunteer_status` (
  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `volunteer_status`
--

INSERT INTO `volunteer_status` (`status_id`, `name`) VALUES
(1, 'Unregistered'),
(2, 'Unsigned'),
(3, 'Signed');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
