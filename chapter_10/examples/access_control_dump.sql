-- MySQL dump 10.11
--
-- Host: localhost    Database: access_control
-- ------------------------------------------------------
-- Server version	5.0.37

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
-- Table structure for table `collection`
--

DROP TABLE IF EXISTS `collection`;
CREATE TABLE `collection` (
  `collection_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`collection_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `collection`
--

LOCK TABLES `collection` WRITE;
/*!40000 ALTER TABLE `collection` DISABLE KEYS */;
INSERT INTO `collection` VALUES (1,'Users','General users can view documents'),(2,'Editors','Editors can create and edit documents'),(3,'Administrators','Admins can delete documents');
/*!40000 ALTER TABLE `collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection2permission`
--

DROP TABLE IF EXISTS `collection2permission`;
CREATE TABLE `collection2permission` (
  `collection_id` int(11) NOT NULL default '0',
  `permission_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`collection_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `collection2permission`
--

LOCK TABLES `collection2permission` WRITE;
/*!40000 ALTER TABLE `collection2permission` DISABLE KEYS */;
INSERT INTO `collection2permission` VALUES (1,1),(2,1),(2,2),(2,3),(3,1),(3,2),(3,3),(3,4);
/*!40000 ALTER TABLE `collection2permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,'view','Permission to view a document'),(2,'create','Permission to create a new document'),(3,'edit','Permission to edit a document'),(4,'delete','Permission to delete a document');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `signup`
--

DROP TABLE IF EXISTS `signup`;
CREATE TABLE `signup` (
  `signup_id` int(11) NOT NULL auto_increment,
  `login` varchar(50) collate latin1_general_ci NOT NULL default '',
  `password` varchar(50) collate latin1_general_ci NOT NULL default '',
  `email` varchar(50) collate latin1_general_ci default NULL,
  `firstName` varchar(50) collate latin1_general_ci default NULL,
  `lastName` varchar(50) collate latin1_general_ci default NULL,
  `signature` text collate latin1_general_ci NOT NULL,
  `confirm_code` varchar(40) collate latin1_general_ci NOT NULL default '',
  `created` int(11) NOT NULL default '0',
  PRIMARY KEY  (`signup_id`),
  UNIQUE KEY `confirm_code` (`confirm_code`),
  UNIQUE KEY `user_login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `signup`
--

LOCK TABLES `signup` WRITE;
/*!40000 ALTER TABLE `signup` DISABLE KEYS */;
/*!40000 ALTER TABLE `signup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `login` varchar(50) collate latin1_general_ci NOT NULL default '',
  `password` varchar(50) collate latin1_general_ci NOT NULL default '',
  `email` varchar(50) collate latin1_general_ci default NULL,
  `firstName` varchar(50) collate latin1_general_ci default NULL,
  `lastName` varchar(50) collate latin1_general_ci default NULL,
  `signature` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'jackblack','5f4dcc3b5aa765d61d8327deb882cf99','jack@example.com','Jack','Black','Regards,\r\nJack Black'),(2,'jackwhite','5f4dcc3b5aa765d61d8327deb882cf99','jackw@example.com','Jack','White','Regards,\r\nJack White'),(3,'siteadmin','5f4dcc3b5aa765d61d8327deb882cf99','admin@example.com','Mr','Administrator','Regards,\r\nYour friendly web site Admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user2collection`
--

DROP TABLE IF EXISTS `user2collection`;
CREATE TABLE `user2collection` (
  `user_id` int(11) NOT NULL default '0',
  `collection_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`collection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user2collection`
--

LOCK TABLES `user2collection` WRITE;
/*!40000 ALTER TABLE `user2collection` DISABLE KEYS */;
INSERT INTO `user2collection` VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `user2collection` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
