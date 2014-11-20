-- MySQL dump 10.13  Distrib 5.1.63, for suse-linux-gnu (x86_64)
--
-- Host: localhost    Database: gb
-- ------------------------------------------------------
-- Server version	5.1.63-log

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
-- Table structure for table `GUESTBOOK`
--

DROP TABLE IF EXISTS `GUESTBOOK`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GUESTBOOK` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATUM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VON` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NACHRICHT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fatzebook`
--

DROP TABLE IF EXISTS `fatzebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fatzebook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ersteller` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `titel` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `beitrag` text COLLATE utf8_unicode_ci NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gaestebuch`
--

DROP TABLE IF EXISTS `gaestebuch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gaestebuch` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `datum` int(11) unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `inhalt` text COLLATE utf8_unicode_ci NOT NULL,
  `aktiv` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_table`
--

DROP TABLE IF EXISTS `test_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_table` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-09 20:05:42
