-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 15 Mai 2023 à 14:24
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_gestionpretvoisins`
--

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
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_article`
--

INSERT INTO `t_article` (`idArticle`, `artName`, `artStatus`, `artPicture`, `artDescription`, `idUser`) VALUES
(3, 'long vue', '1', 'longvue.jpg', 'c\'est une long vue', 2),
(5, 'Tondeuse', '0', 'Tondeuses.jpg', 'c\'est une tondeuse :D', 1),
(6, 'jumelle', '0', 'jumelle.jpg', 'ce sont des jumelles vraiment très sympa.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_loan`
--

CREATE TABLE `t_loan` (
  `idLoan` int(11) NOT NULL,
  `loaBeginDate` date NOT NULL,
  `loaEndDate` date NOT NULL,
  `idArticle` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useName`, `usePassword`, `useLocal`, `useNbArticles`, `useNbLoan`, `useRegisterDate`) VALUES
(1, 'antpfister', 'qwer1234', 'Lausanne', '0', '0', '2023-05-12'),
(2, 'client', 'qwer1234', 'Lutry', '0', '0', '2023-05-15');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_article`
--
ALTER TABLE `t_article`
  ADD PRIMARY KEY (`idArticle`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `t_loan`
--
ALTER TABLE `t_loan`
  ADD PRIMARY KEY (`idLoan`),
  ADD KEY `idArticle` (`idArticle`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_article`
--
ALTER TABLE `t_article`
  MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `t_loan`
--
ALTER TABLE `t_loan`
  MODIFY `idLoan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_article`
--
ALTER TABLE `t_article`
  ADD CONSTRAINT `t_article_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

--
-- Contraintes pour la table `t_loan`
--
ALTER TABLE `t_loan`
  ADD CONSTRAINT `t_loan_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `t_article` (`idArticle`),
  ADD CONSTRAINT `t_loan_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
