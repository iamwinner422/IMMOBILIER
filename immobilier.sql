-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 08 sep. 2020 à 20:08
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `immobilier`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

CREATE TABLE `administration` (
  `num_admin` int(11) NOT NULL,
  `admin_name` varchar(75) NOT NULL,
  `adr_mail` varchar(150) NOT NULL,
  `admin_pass` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`num_admin`, `admin_name`, `adr_mail`, `admin_pass`) VALUES
(2, 'Admin', 'iamwinner422@gmail.com', '@dmin');

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `num_ann` int(11) NOT NULL,
  `titre_ann` varchar(75) NOT NULL,
  `desc_ann` varchar(255) NOT NULL,
  `prix_ann` float NOT NULL,
  `lieu_ann` varchar(155) NOT NULL,
  `date_ann` varchar(10) NOT NULL,
  `num_ville` int(11) NOT NULL,
  `num_user` int(11) NOT NULL,
  `num_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`num_ann`, `titre_ann`, `desc_ann`, `prix_ann`, `lieu_ann`, `date_ann`, `num_ville`, `num_user`, `num_type`) VALUES
(1, 'Maison à louer', 'Maison de 2 étages avec piscine', 500000, 'Novissi', '12/06/2020', 8, 4, 5),
(6, 'Titre de l\'annonce', 'Description de l\'annonce', 10000000, 'Situation du lieu', '09/07/2020', 4, 4, 2),
(7, 'Location de local', 'Local chic de 15 mètres', 50000, '3355 Madison Ave', '27/07/2020', 1, 4, 3),
(8, 'A louer', 'Une chambre/salon à disponilble', 15000, '11 Avenou  D Street', '15/08/2020', 1, 9, 4),
(9, 'Camion de toto', 'Bonne présentation', 10000000, 'Lossosimé', '08/09/2020', 1, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `num_img` int(11) NOT NULL,
  `source` text NOT NULL,
  `num_ann` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`num_img`, `source`, `num_ann`) VALUES
(6, 'uploads/2.PNG', 6),
(7, 'uploads/3.PNG', 6),
(8, 'uploads/5.PNG', 6),
(9, 'uploads/img_20180501_133129862_hdr-1000x750.jpg', 7),
(10, 'uploads/humberto-chavez-FVh_yqLR9eA-unsplash.jpg', 7),
(11, 'uploads/k15-photos-lgyFO6a9JTM-unsplash.jpg', 7),
(12, 'uploads/national-cancer-institute-L8tWZT4CcVQ-unsplash.jpg', 7),
(13, 'uploads/mcs31.png', 7),
(14, 'uploads/img_20180501_133129862_hdr-1000x750.jpg', 8),
(15, 'uploads/36189146_2065983006975093_5255399992876597248_o.jpg', 8),
(16, 'uploads/neon_backlight_inscription_121706_1600x1200.jpg', 8),
(17, 'uploads/Capturel.PNG', 9);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `num_msg` int(11) NOT NULL,
  `nom_evy` varchar(75) NOT NULL,
  `prenoms_evy` varchar(150) NOT NULL,
  `objet` varchar(150) NOT NULL,
  `num_tel_evy` varchar(8) NOT NULL,
  `adr_mail` varchar(150) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`num_msg`, `nom_evy`, `prenoms_evy`, `objet`, `num_tel_evy`, `adr_mail`, `message`) VALUES
(1, 'Wick', 'John', 'Test', '98888889', 'johnwick@contact.com', 'Hi guy! hmm..I\'mJohn...John Wick and i\'m here to congratulate you for yourgood job on my third movie PARABELUM'),
(2, 'Walker', 'Winny', 'Félicitation', '98023036', 'iamwinner422@gmail.com', 'Yo Yo...Salut à  vous ..J\'espère que vous allez bien..Juste pour vous dire  qu\'en une journée j\'ai trouvé un bon appart près de mon bureau à  un prix raisonnable..Merci et Courage à  vous'),
(3, 'Lyon', 'Andre ', 'Plainte', '22222222', 'andrelyon@empire.com', 'Heu..I\'m Andre Lyon ..the first son of Cookie Lyon and Lucios.Bref..'),
(4, 'Renolds', 'Ryan', 'Bof', '99999999', 'ryanrenolds@info.com', 'Yo les gars...DeadPool 3 c\'est pour bientôt alors restez connectés..Chiao!!');

-- --------------------------------------------------------

--
-- Structure de la table `type_immob`
--

CREATE TABLE `type_immob` (
  `num_type` int(11) NOT NULL,
  `libelle_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_immob`
--

INSERT INTO `type_immob` (`num_type`, `libelle_type`) VALUES
(1, 'Maisons'),
(2, 'Terrains'),
(3, 'Boutiques'),
(4, 'Chambres'),
(5, 'Pièces');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `num_user` int(11) NOT NULL,
  `prenoms_user` varchar(100) NOT NULL,
  `nom_user` varchar(75) NOT NULL,
  `num_tel` varchar(8) NOT NULL,
  `adr_mail` varchar(150) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`num_user`, `prenoms_user`, `nom_user`, `num_tel`, `adr_mail`, `password`) VALUES
(2, 'Saddat', 'Igodo', '97432505', 'saddat12@gmail.com', '4872b452e60ec17ffbb2621f56200e46e834473c'),
(3, 'Honore', 'Bilante', '92868204', 'honore@gmail.com', 'b363cb933a24288c7752b03cfdcc780c5200af44'),
(4, 'Matthieu', 'Segbe', '91716303', 'matthieu@gmail.com', '93c350b68b0b2c5a16ade03f5dbdd4044a5c0649'),
(6, 'Efrem', 'Smith', '92350564', 'efremsmith@gmail.com', '4d7ca252be75b53fce4f75871bea793c8f42862a'),
(7, 'Joel', 'AT', '97563660', 'joelat@gmail.com', 'a7c944970c27bf420cfe3afb2b996988c99eca62'),
(8, 'Aleck', 'Bernard', '98023036', 'aleckbernard9@gmail.com', '3a9a0a9c653a34d94c56353e8db5ff5bce31510c'),
(9, 'Iam', 'Winner', '99091409', 'iamwinner422@gmail.com', '3a9a0a9c653a34d94c56353e8db5ff5bce31510c'),
(10, 'Toto', 'toto', '90909090', 'toto@toto.com', '0de3cbd6145651916c4a9986fe6b0bb5fd0b39ee');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `num_ville` int(11) NOT NULL,
  `nom_ville` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`num_ville`, `nom_ville`) VALUES
(1, 'Lomé'),
(3, 'Aného'),
(4, 'Kpalimé'),
(5, 'Kara'),
(8, 'Atakpamé');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`num_admin`);

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`num_ann`),
  ADD KEY `FK_annonces_villes` (`num_ville`),
  ADD KEY `FK_annonces_utilisateurs` (`num_user`),
  ADD KEY `FK_annonces_type_immob` (`num_type`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`num_img`),
  ADD KEY `FK__utilisateurs` (`num_ann`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`num_msg`);

--
-- Index pour la table `type_immob`
--
ALTER TABLE `type_immob`
  ADD PRIMARY KEY (`num_type`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`num_user`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`num_ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administration`
--
ALTER TABLE `administration`
  MODIFY `num_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `num_ann` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `num_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `num_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_immob`
--
ALTER TABLE `type_immob`
  MODIFY `num_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `num_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `num_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
