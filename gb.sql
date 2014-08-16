-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Aug 2014 um 08:37
-- Server Version: 5.6.12
-- PHP-Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `gb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gaestebuch`
--

CREATE TABLE IF NOT EXISTS `gaestebuch` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `datum` int(11) unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `inhalt` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `gaestebuch`
--

INSERT INTO `gaestebuch` (`id`, `datum`, `name`, `email`, `inhalt`) VALUES
(1, 1408176682, 'max mustermann', 'max@provider.com', 'dies war ein wirklich interessanter Kurs bei dem man viel lernen konnte'),
(2, 1408176757, 'martina mustermann', 'martina@provider.com', 'ja war er wirklich, jedoch ist man nun auch froh dass man fertig ist'),
(3, 1408176836, 'max mustermann', 'max@provider.com', 'oh ja dass kannst du laut sagen!!!'),
(4, 1408176965, 'martina mustermann', 'martina@provider.com', 'ja genau, endlich wieder party angesagt an den wochenenden'),
(5, 1408177061, 'hubert kah', 'hubert@provider.com', 'hallo leute, habe zwar den kurs nicht mitgemacht, bin aber was das party machen angeht mit dabei'),
(6, 1408177252, 'max mustermann', 'max@provider.com', 'sorry hubert aber party machen geht nur wenn du fernstudiert hast');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
