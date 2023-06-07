-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 05 juin 2023 à 14:10
-- Version du serveur : 5.7.11
-- Version de PHP : 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_gestionpretvoisins`
--
DROP DATABASE IF EXISTS db_gestionpretvoisins;
CREATE DATABASE db_gestionpretvoisins;
USE db_gestionpretvoisins;
-- --------------------------------------------------------

--
-- Structure de la table `t_article`
--

CREATE TABLE `t_article` (
  `idArticle` int(11) NOT NULL,
  `artName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `artStatus` decimal(1,0) NOT NULL,
  `artPicture` varchar(255) CHARACTER SET utf8 NOT NULL,
  `artDescription` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fkUserArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_article`
--

INSERT INTO `t_article` (`idArticle`, `artName`, `artStatus`, `artPicture`, `artDescription`, `fkUserArticle`) VALUES
(3, 'longue vue', 0, 'longvue.jpg', 'ça marche ', 2),
(6, 'paire de jumelle', 1, 'jumelle.jpg', 'ce sont des jumelles :D', 1),
(10, 'tondeuse', 0, '17-05-23Tondeuses.jpg', 'c\'est une tondeuse', 1),
(12, 'voiture', 1, '17-05-23voiture.jpg', 'c\'est une voiture', 1),
(16, 'Arrosoire', 1, '24-05-23_10.26.52Arrosoire.jpg', 'c\'est un arrosoire ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_loan`
--

CREATE TABLE `t_loan` (
  `idLoan` int(11) NOT NULL,
  `loaBeginDate` date NOT NULL,
  `loaEndDate` date NOT NULL,
  `fkArticle` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_loan`
--

INSERT INTO `t_loan` (`idLoan`, `loaBeginDate`, `loaEndDate`, `fkArticle`, `fkUser`) VALUES
(18, '2023-06-02', '2023-06-07', 10, 2),
(31, '2023-06-03', '2023-06-09', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `useName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `usePassword` varchar(50) CHARACTER SET utf8 NOT NULL,
  `useLocal` varchar(50) CHARACTER SET utf8 NOT NULL,
  `useNbArticles` decimal(1,0) NOT NULL,
  `useNbLoan` decimal(1,0) NOT NULL,
  `useRegisterDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useName`, `usePassword`, `useLocal`, `useNbArticles`, `useNbLoan`, `useRegisterDate`) VALUES
(1, 'antpfister', 'qwer1234', 'Lausanne', 4, 0, '2023-05-12'),
(2, 'client', 'qwer1234', 'Lutry', 0, 1, '2023-05-15'),
(3, 'client2', 'qwer1234', 'Lausanne', 0, 0, '2023-05-17');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_article`
--
ALTER TABLE `t_article`
  ADD PRIMARY KEY (`idArticle`),
  ADD KEY `idUser` (`fkUserArticle`);

--
-- Index pour la table `t_loan`
--
ALTER TABLE `t_loan`
  ADD PRIMARY KEY (`idLoan`),
  ADD KEY `idArticle` (`fkArticle`),
  ADD KEY `idUser` (`fkUser`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_article`
--
ALTER TABLE `t_article`
  MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `t_loan`
--
ALTER TABLE `t_loan`
  MODIFY `idLoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_article`
--
ALTER TABLE `t_article`
  ADD CONSTRAINT `t_article_ibfk_1` FOREIGN KEY (`fkUserArticle`) REFERENCES `t_user` (`idUser`);

--
-- Contraintes pour la table `t_loan`
--
ALTER TABLE `t_loan`
  ADD CONSTRAINT `t_loan_ibfk_1` FOREIGN KEY (`fkArticle`) REFERENCES `t_article` (`idArticle`),
  ADD CONSTRAINT `t_loan_ibfk_2` FOREIGN KEY (`fkUser`) REFERENCES `t_user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
