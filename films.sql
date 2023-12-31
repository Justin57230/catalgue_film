-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 30 Décembre 2023 à 20:48
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `catalogue_films`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE IF NOT EXISTS `films` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster_url` varchar(255) NOT NULL,
  `season` varchar(10) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=166 ;


-- 
-- Structure de la table `users`
-- 

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);


--
-- Contenu de la table `films`
--

INSERT INTO `films` (`id`, `title`, `poster_url`, `season`, `type`, `link`, `url`) VALUES
(152, 'avatar 2', './affiche/avatar2-imax-poster.jpeg', NULL, 'film', NULL, 'https://uqload.io/embed-zgt26ad3orb4.html'),
(130, 'Donnie Darko2', './affiche/Donnie Darko.jpg', NULL, 'film', NULL, 'https://uqload.io/embed-uxo0zdlsfq8a.html'),
(151, 'avatar 1', './affiche/avatar1.jpg', NULL, 'film', NULL, 'https://uqload.io/embed-0s1ya1267y8i.html'),
(164, 'The Wolf of Wall Street', './affiche/21060483_20131125114549726.jpg-c_310_420_x-f_jpg-q_x-xxyxx.jpg', NULL, 'film', NULL, 'https://uqload.io/embed-o9ow0zhd8krn.html'),
(165, 'game of thrones', './affiche/game_of_thrones.jpg', 'S1', 'serie', NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=166;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
