-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 mars 2026 à 13:05
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_liens`
--

-- --------------------------------------------------------

--
-- Structure de la table `liens`
--

DROP TABLE IF EXISTS `liens`;
CREATE TABLE IF NOT EXISTS `liens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `categorie` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Général',
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `liens`
--

INSERT INTO `liens` (`id`, `id_utilisateur`, `titre`, `url`, `categorie`) VALUES
(8, 1, 'YouTube', 'https://www.youtube.com/', 'Réseaux Sociaux'),
(11, 1, 'Hoobastank', 'https://youtu.be/fV4DiAyExN0?list=RDMMfV4DiAyExN0', 'Vidéos'),
(4, 2, 'claude', 'https://claude.ai/new', 'Général'),
(10, 3, 'FaceBook', 'https://www.facebook.com/', 'Loisirs'),
(6, 2, 'ChatGPT', 'https://chatgpt.com/', 'Général'),
(9, 1, 'Gemini', 'https://gemini.google.com/app', 'Travail'),
(13, 1, 'Radiohead ~ Creep', 'https://youtu.be/XFkzRNyygfk?list=RDMMfV4DiAyExN0', 'Vidéos'),
(14, 2, 'Cigarettes After Sex ~ Cry', 'https://youtu.be/hUElm7qvzeM?t=5', 'Vidéos');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`) VALUES
(1, 'Toky ', '$2y$10$oVE56.78/27K7Sc3QApEg.RBEW97ti01/EoFXJvvVwEeIs8f39U9i'),
(2, 'Thierry', '$2y$10$kgwsvMq.xlnGpHIYgWnN/eTSfchg9dgfIZ/9Ve5.Usmsa3omoq9/u'),
(3, 'miranto', '$2y$10$BmI6mWtxs/5Juubwo8xHf.JgGAyTUcKKcWVWQ9ulv82PMTmZ.IKMy'),
(4, 'Tojo', '$2y$10$Sg4AKsX/H3TsryaRVwfx.epkNphjvtP18gh.hVFbbJ3xUAjBr8UvW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
