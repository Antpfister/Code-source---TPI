-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 26 mai 2023 à 10:04
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
(6, 'paire de jumelle', 0, 'jumelle.jpg', 'ce sont des jumelles :D', 1),
(10, 'tondeuse', 1, '17-05-23Tondeuses.jpg', 'c\'est une tondeuse', 1),
(12, 'voiture', 1, '17-05-23voiture.jpg', 'c\'est une voiture', 1),
(16, 'Arrosoire', 0, '24-05-23_10.26.52Arrosoire.jpg', 'c\'est un arrosoire ', 1),
(17, 'Moto rouge', 1, '26-05-23_11.10.02moto.jpg', 'C\'est une moto', 1);

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
(13, '2023-05-26', '2023-06-01', 16, 1),
(15, '2023-05-26', '2023-05-27', 6, 1),
(16, '2023-05-26', '2023-05-27', 3, 1);

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
(1, 'antpfister', 'qwer1234', 'Lausanne', 5, 3, '2023-05-12'),
(2, 'client', 'qwer1234', 'Lutry', 0, 0, '2023-05-15'),
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
  MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `t_loan`
--
ALTER TABLE `t_loan`
  MODIFY `idLoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
