-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Aug 2014 um 06:37
-- Server Version: 5.6.12
-- PHP-Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `test_db`
--
CREATE DATABASE IF NOT EXISTS `test_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `test_db`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `test_table`
--

DROP TABLE IF EXISTS `test_table`;
CREATE TABLE IF NOT EXISTS `test_table` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
