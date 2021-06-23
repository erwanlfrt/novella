-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 17 juin 2021 à 09:00
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `novella`
--

-- --------------------------------------------------------

--
-- Structure de la table `competition`
--

DROP TABLE IF EXISTS `competition`;
CREATE TABLE IF NOT EXISTS `competition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme` varchar(100) NOT NULL,
  `incipit` varchar(200) DEFAULT NULL,
  `creationDate` date NOT NULL,
  `prejuryDate` date NOT NULL,
  `juryDate` date NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `competition`
--

INSERT INTO `competition` (`id`, `theme`, `incipit`, `creationDate`, `prejuryDate`, `juryDate`,`deadline`) VALUES
(1, 'Concours pour candidat', 'incipit1', '2020-01-01', '2021-08-30','2020-09-30', '2021-07-01');

INSERT INTO `competition` (`id`, `theme`, `incipit`, `creationDate`, `prejuryDate`, `juryDate`,`deadline`) VALUES
(2, 'Concours pour prejury', 'Il était une fois', '2020-01-01', '2021-08-30','2020-06-15', '2021-06-01');

INSERT INTO `competition` (`id`, `theme`, `incipit`, `creationDate`, `prejuryDate`, `juryDate`,`deadline`) VALUES
(3, 'Concours pour jury', 'Il était une fois', '2020-01-01', '2021-08-30','2020-06-02', '2021-06-01');

-- --------------------------------------------------------

--
-- Structure de la table `jury`
--

DROP TABLE IF EXISTS `jury`;
CREATE TABLE IF NOT EXISTS `jury` (
  `competition` int(11) NOT NULL,
  `mailUser` varchar(50) NOT NULL,
  `points` int(11) DEFAULT '1000',
  PRIMARY KEY (`competition`,`mailUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jury`
--

INSERT INTO `jury` (`competition`, `mailUser`, `points`) VALUES
(0, 'test2@gmail.com', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `novella`
--

DROP TABLE IF EXISTS `novella`;
CREATE TABLE IF NOT EXISTS `novella` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `text` text,
  `verified` tinyint(1) DEFAULT NULL,
  `competition` int(11) NOT NULL,
  `mailUser` varchar(50) NOT NULL,
  `anonymousID` varchar(50) NOT NULL,
  `score` int(11) DEFAULT '0'NOT NULL,
  `scorePrejury` int(11) DEFAULT '0'NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_novella_user` (`mailUser`),
  KEY `fk_novella_competition` (`competition`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `novella`
--

INSERT INTO `novella` (`id`, `title`, `text`, `verified`, `competition`, `mailUser`, `anonymousID`) VALUES
(1, 'Titre', 'blabla', NULL, 0, 'test@gmail.com', 'aeiouy34654z6efzef');

-- --------------------------------------------------------

--
-- Structure de la table `prejury`
--

DROP TABLE IF EXISTS `prejury`;
CREATE TABLE IF NOT EXISTS `prejury` (
  `competition` int(11) NOT NULL,
  `mailUser` varchar(50) NOT NULL,
  `points` int(11) DEFAULT '1000',
  PRIMARY KEY (`competition`,`mailUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prejury`
--

INSERT INTO `prejury` (`competition`, `mailUser`, `points`) VALUES
(0, 'test2@gmail.com', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `requiredword`
--

DROP TABLE IF EXISTS `requiredword`;
CREATE TABLE IF NOT EXISTS `requiredword` (
  `competition` int(11) NOT NULL,
  `word` varchar(45) NOT NULL,
  PRIMARY KEY (`competition`,`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `requiredword`
--

INSERT INTO `requiredword` (`competition`, `word`) VALUES
(0, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  PRIMARY KEY (`mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`mail`, `password`, `name`, `firstname`) VALUES
('test@gmail.com', 'f71dbe52628a3f83a77ab494817525c6', 'Nom', 'Prenom'),
('test2@gmail.com', 'f71dbe52628a3f83a77ab494817525c6', 'Nom', 'Prenom');
COMMIT;

-- Add column admin
ALTER TABLE `users` ADD `admin` BOOLEAN NOT NULL AFTER `firstname`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


DROP TABLE IF EXISTS `Vote`;
CREATE TABLE IF NOT EXISTS `Vote` (
  `competition` INT(11) NOT NULL,
  `userMail` VARCHAR(50) NOT NULL,
  `idNovella` bigint(20) UNSIGNED NOT NULL,
  `points` INT(11) NOT NULL,
  `prejury` BOOLEAN NOT NULL,
  PRIMARY KEY (`competition`,`userMail`,`idNovella`, `prejury`),
  KEY `fk_vote_jury` (`competition`,`userMail`),
  KEY `fk_vote_novella` (`idNovella`)
);