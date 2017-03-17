-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 17 Mars 2017 à 20:00
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `facture`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `NUMCLIENT` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `PRENOM` varchar(255) NOT NULL,
  `CP` varchar(255) NOT NULL,
  `ADRESSECLIENT` varchar(255) NOT NULL,
  `VILLE` varchar(255) NOT NULL,
  `PAYS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`NUMCLIENT`, `NOM`, `PRENOM`, `CP`, `ADRESSECLIENT`, `VILLE`, `PAYS`) VALUES
(1, 'Lehmann', 'Nicolas', '67000', '12 rue des vosges', 'Strasbourg', 'France'),
(2, 'Kleinclaus', 'Florent', '67100', '1, rue de la Chapelle', 'Strasbourg', 'France'),
(3, 'Caillaud', 'Jean-Baptiste', '67000', '5, rue des champs', 'Strasbourg', 'France'),
(4, 'Muré', 'Lucas', '67000', '5, rue de Gauche', 'Strasbourg', 'France'),
(7, 'Hatton', 'Jérome', '6700', '2, rue de la fôret noire', 'Strasbourg', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `dfacture`
--

CREATE TABLE `dfacture` (
  `QUANTITE` int(11) NOT NULL,
  `NUMFACTURE` int(11) NOT NULL,
  `NUMPRODUIT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dfacture`
--

INSERT INTO `dfacture` (`QUANTITE`, `NUMFACTURE`, `NUMPRODUIT`) VALUES
(5, 2, 2),
(1, 3, 3),
(30, 4, 2),
(1, 4, 3),
(5, 5, 1),
(2, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `NUMFACTURE` int(11) NOT NULL,
  `DATEFACT` date NOT NULL,
  `NUMCLIENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`NUMFACTURE`, `DATEFACT`, `NUMCLIENT`) VALUES
(2, '2016-11-24', 2),
(3, '2016-12-01', 3),
(4, '2016-11-24', 4),
(5, '2017-03-09', 1),
(6, '2017-03-16', 7);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `NUMPRODUIT` int(11) NOT NULL,
  `LIBELLE` varchar(255) NOT NULL,
  `PRIXUNITAIRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`NUMPRODUIT`, `LIBELLE`, `PRIXUNITAIRE`) VALUES
(1, 'PC Lenovo', 699),
(2, 'PC HP', 499),
(3, 'PC GIGABYTE', 1499),
(4, 'PC ASUS', 1299),
(5, 'PC Dell', 2000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID_UTIL` int(11) NOT NULL,
  `NOM_UTIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_UTIL`, `NOM_UTIL`, `PASSWORD`) VALUES
(1, 'test', '$2y$10$8zBtjHNPd7NZL2rp9FGWOeZyEYyfR2LI6r9P4clO3NlHkfufOIrdG'),
(2, 'test2', '$2y$10$rs2zSdHQtxSV1AH2G8yt6umyzY4pGaBV3G0LUGji20mTfyEfAZLdq');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NUMCLIENT`);

--
-- Index pour la table `dfacture`
--
ALTER TABLE `dfacture`
  ADD PRIMARY KEY (`NUMFACTURE`,`NUMPRODUIT`),
  ADD KEY `NUMFACTURE` (`NUMFACTURE`),
  ADD KEY `NUMPRODUIT` (`NUMPRODUIT`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`NUMFACTURE`),
  ADD KEY `NUMCLIENT` (`NUMCLIENT`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`NUMPRODUIT`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID_UTIL`),
  ADD UNIQUE KEY `NOM_UTIL` (`NOM_UTIL`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `NUMCLIENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `NUMFACTURE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `NUMPRODUIT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_UTIL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `dfacture`
--
ALTER TABLE `dfacture`
  ADD CONSTRAINT `dfacture_ibfk_1` FOREIGN KEY (`NUMPRODUIT`) REFERENCES `produit` (`NUMPRODUIT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dfacture_ibfk_2` FOREIGN KEY (`NUMFACTURE`) REFERENCES `facture` (`NUMFACTURE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`NUMCLIENT`) REFERENCES `client` (`NUMCLIENT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
