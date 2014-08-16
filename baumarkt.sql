-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Aug 2014 um 03:06
-- Server Version: 5.6.12
-- PHP-Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS baumarkt;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `baumarkt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--
CREATE TABLE IF NOT EXISTS `bestellung` (
  `bestell_nr` int(6) NOT NULL,
  `bestell_date` date NOT NULL,
  `versandkosten` decimal(9,2) DEFAULT NULL,
  `um_steuer` decimal(9,2) DEFAULT NULL,
  `status_auftrag` enum('ja','nein') COLLATE latin1_german1_ci DEFAULT NULL,
  `vers_name` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `vers_strasse` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `vers_postl` char(10) COLLATE latin1_german1_ci DEFAULT NULL,
  `vers_ort` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `staat` char(2) COLLATE latin1_german1_ci DEFAULT NULL,
  `email` char(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `telefon` char(20) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestell_auftrag`
--

CREATE TABLE IF NOT EXISTS `bestell_auftrag` (
  `bestell_nr` int(6) NOT NULL,
  `pos_nr` int(4) NOT NULL,
  `katalog_nr` int(8) NOT NULL,
  `menge` decimal(7,2) NOT NULL,
  `preis` decimal(7,2) NOT NULL,
  PRIMARY KEY (`bestell_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `katalog`
--

CREATE TABLE IF NOT EXISTS `katalog` (
  `katalog_nr` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `fabrikat` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `best_nr` int(9) NOT NULL,
  `preis` decimal(7,2) NOT NULL,
  `pr_beschr` varchar(200) COLLATE latin1_german1_ci NOT NULL,
  `kateins` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `katzwei` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`katalog_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `katalog`
--

INSERT INTO `katalog` (`katalog_nr`, `name`, `fabrikat`, `best_nr`, `preis`, `pr_beschr`, `kateins`, `katzwei`) VALUES
(1, 'Gartenstuhl', 'Kettler', 345556, '209.00', '', 'Garten', 'Gartenmoebel'),
(2, 'Gartentisch', 'MWH', 445897, '499.00', '', 'Garten', 'Gartenmoebel'),
(3, 'Gartenrechen', 'Maurer', 337561, '22.00', '', 'Garten', 'Gartengeraete'),
(4, 'Schaufel', 'Inso', 127834, '15.00', '', 'Garten', 'Gartengeraete'),
(5, 'Duschbecken', 'Kristall', 679124, '478.89', '', 'Sanitaer', 'Badausbau'),
(6, 'Brause', 'Wellness', 765467, '78.99', '', 'Sanitaer', 'Badausbau'),
(7, 'Toilettenschuessel', 'Krana', 235886, '123.00', '', 'Sanitaer', 'Toilettenausbau'),
(8, 'Wasserhahn', 'Miller', 349789, '56.00', '', 'Sanitaer', 'Toilettenausbau');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) COLLATE latin1_german1_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6'),
(2, 'kiri', '1a7c2064e3b6f14270848bdb3f694800'),
(3, 'andi', 'ce0e5bf55e4f71749eade7a8b95c4e46'),
(4, 'klaus', '4f3adcfc45e6c3f21bc6263c32d7cc8b');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
