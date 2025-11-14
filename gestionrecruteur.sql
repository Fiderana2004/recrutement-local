-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 nov. 2025 à 11:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionrecruteur`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidat`
--

CREATE TABLE `candidat` (
  `idcand` int(11) NOT NULL,
  `nomcand` varchar(32) DEFAULT NULL,
  `prncand` varchar(32) DEFAULT NULL,
  `ecand` varchar(100) DEFAULT NULL,
  `numtelcand` varchar(12) DEFAULT NULL,
  `photocand` varchar(255) DEFAULT NULL,
  `idutil` int(3) NOT NULL,
  `sexe` varchar(32) DEFAULT NULL,
  `poste` varchar(32) DEFAULT NULL,
  `adrscand` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidat`
--

INSERT INTO `candidat` (`idcand`, `nomcand`, `prncand`, `ecand`, `numtelcand`, `photocand`, `idutil`, `sexe`, `poste`, `adrscand`) VALUES
(1, 'Rakotonjantovo', 'Bema', 'andrianhasiniainafiderana@gmail.com', '0345678900', '689b3e9340d6a_test.jpg', 1, 'Homme', 'Développeur', 'Ambalapaso'),
(2, 'Natacha', 'Marie', 'rhansdiary@gmail.com', '0342894538', '68877d88c28c6_PROFIL.jpg', 37, 'Femme', 'Comptable', 'Ambatolahikosoa'),
(3, 'Milan', 'Donovan', 'andrinirinakanu@gmail.com', '0345678909', '688f92a9a6bfa_profil4.jpg', 38, 'Homme', 'Comptable', 'Antananarivo'),
(4, 'Randriahasinarivo', 'Arsene', 'rhansdiary@gmail.com', '0340315873', '689070daaf67d_arsene.jpg', 40, 'Homme', 'Developpeur', 'PRE IN 54 Ambatolahikosoa');

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE `candidature` (
  `idcandidature` int(3) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `ltrmotivation` varchar(255) NOT NULL,
  `idof` int(3) NOT NULL,
  `idcand` int(3) NOT NULL,
  `statut` enum('en attente','accepté','refusé') DEFAULT 'en attente',
  `date_candidature` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`idcandidature`, `cv`, `ltrmotivation`, `idof`, `idcand`, `statut`, `date_candidature`) VALUES
(3, 'uploads/cv/1753883897_C_ORD_GRAPH_CPM_2016.pdf', 'uploads/ltr/1753883897_C_ORD_TABLO_15.pdf', 4, 2, 'accepté', '2025-07-31 14:14:19'),
(4, 'uploads/cv/1754237322_RO_FLOT_16.pdf', 'uploads/ltr/1754237322_CHO_DANTZIG_1_15.pdf', 4, 3, 'accepté', '2025-08-03 16:08:43'),
(5, 'uploads/cv/1754300545_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1754300545_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 12, 4, 'refusé', '2025-08-04 09:42:25'),
(7, 'uploads/cv/1754312166_MOTA1.pdf', 'uploads/ltr/1754312166_MCT.pdf', 11, 1, 'accepté', '2025-08-04 12:56:06'),
(9, 'uploads/cv/1754921300_ANDRIAHASINIAINA Fanomezantsoa Fiderana n°075I24.pdf', 'uploads/ltr/1754921300_ANDRIAHASINIAINA Fanomezantsoa Fiderana n°075I24.pdf', 14, 2, 'refusé', '2025-08-11 14:08:20'),
(10, 'uploads/cv/1754921878_ANDRIAHASINIAINA Fanomezantsoa Fiderana n°075I24.pdf', 'uploads/ltr/1754921878_ANDRIAHASINIAINA Fanomezantsoa Fiderana n°075I24.pdf', 14, 3, 'refusé', '2025-08-11 14:17:58'),
(11, 'uploads/cv/1754992848_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1754992848_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 22, 1, 'en attente', '2025-08-12 10:00:49'),
(12, 'uploads/cv/1755003683_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1755003683_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 20, 4, 'accepté', '2025-08-12 13:01:24'),
(13, 'uploads/cv/1755162186_facture_36 (2).pdf', 'uploads/ltr/1755162186_facture_40.pdf', 23, 4, 'en attente', '2025-08-14 09:03:06'),
(14, 'uploads/cv/1755697761_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1755697761_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 25, 2, 'refusé', '2025-08-20 13:49:21'),
(15, 'uploads/cv/1755844215_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1755844215_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 21, 2, 'accepté', '2025-08-22 06:30:15'),
(16, 'uploads/cv/1756307067_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1756307067_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 28, 2, 'en attente', '2025-08-27 15:04:27'),
(17, 'uploads/cv/1756307373_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1756307373_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 29, 2, 'en attente', '2025-08-27 15:09:33'),
(18, 'uploads/cv/1756307889_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 'uploads/ltr/1756307889_CV_Lettre_Arsene_Randriahasinarivo_sans_accents.pdf', 30, 2, 'accepté', '2025-08-27 15:18:09');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `idnotif` int(11) NOT NULL,
  `idcand` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `est_lu` tinyint(1) DEFAULT 0,
  `date_notif` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`idnotif`, `idcand`, `message`, `est_lu`, `date_notif`) VALUES
(16, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 1, '2025-08-03 18:45:01'),
(25, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en EN ATTENTE.', 1, '2025-08-03 19:10:08'),
(26, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en EN ATTENTE.', 1, '2025-08-03 19:11:16'),
(27, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en EN ATTENTE.', 1, '2025-08-03 19:11:22'),
(32, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 1, '2025-08-04 08:16:43'),
(33, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 1, '2025-08-04 08:18:56'),
(34, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 1, '2025-08-04 08:26:50'),
(37, 1, 'Le statut de votre candidature à l\'offre \"Développeur web\" a été changé en ACCEPTé.', 0, '2025-08-07 08:59:09'),
(40, 4, 'Le statut de votre candidature à l\'offre \"Développeur Front-End\" a été changé en ACCEPTé.', 1, '2025-08-09 15:12:57'),
(43, 4, 'Le statut de votre candidature à l\'offre \"Développeur web\" a été changé en ACCEPTé.', 1, '2025-08-09 15:17:45'),
(50, 3, 'Le statut de votre candidature à l\'offre \"Comptable confirmé(e)\" a été changé en REFUSé.', 1, '2025-08-11 16:18:22'),
(51, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en EN ATTENTE.', 1, '2025-08-11 16:38:00'),
(52, 3, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 1, '2025-08-11 16:41:20'),
(53, 1, 'Le statut de votre candidature à l\'offre \"Développeur Full Stack (JavaScript / Node.js / React)\" a été changé en ACCEPTé.', 0, '2025-08-12 12:02:22'),
(54, 1, 'Le statut de votre candidature à l\'offre \"Développeur Full Stack (JavaScript / Node.js / React)\" a été changé en REFUSé.', 0, '2025-08-12 12:04:14'),
(55, 4, 'Le statut de votre candidature à l\'offre \"Développeur Full Stack (JavaScript / Node.js / React)\" a été changé en ACCEPTé.', 0, '2025-08-12 15:03:00'),
(56, 1, 'Le statut de votre candidature à l\'offre \"Développeur web\" a été changé en EN ATTENTE.', 0, '2025-08-12 15:10:27'),
(57, 1, 'Le statut de votre candidature à l\'offre \"Développeur web\" a été changé en ACCEPTé.', 0, '2025-08-19 18:38:44'),
(58, 1, 'Le statut de votre candidature à l\'offre \"Développeur Full Stack (JavaScript / Node.js / React)\" a été changé en EN ATTENTE.', 0, '2025-08-20 12:49:24'),
(59, 2, 'Le statut de votre candidature à l\'offre \"Comptable confirmé(e)\" a été changé en REFUSé.', 1, '2025-08-20 15:49:54'),
(60, 2, 'Le statut de votre candidature à l\'offre \"Comptable confirmé(e)\" a été changé en ACCEPTé.', 1, '2025-08-22 08:30:38'),
(61, 2, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 0, '2025-08-27 17:19:02'),
(62, 2, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en REFUSé.', 0, '2025-08-27 17:23:36'),
(63, 2, 'Le statut de votre candidature à l\'offre \"Comptable\" a été changé en ACCEPTé.', 0, '2025-08-27 17:23:40');

-- --------------------------------------------------------

--
-- Structure de la table `notification_recruteur`
--

CREATE TABLE `notification_recruteur` (
  `id` int(11) NOT NULL,
  `idrecru` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_notif` datetime DEFAULT current_timestamp(),
  `lu` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification_recruteur`
--

INSERT INTO `notification_recruteur` (`id`, `idrecru`, `message`, `date_notif`, `lu`) VALUES
(1, 5, 'Un candidat  a postulé à votre offre \"Développeur web\".', '2025-08-04 14:56:06', 1),
(2, 1, 'Un candidat  a postulé à votre offre \"Développeur Full Stack JavaScript (React / Node.js)\".', '2025-08-11 14:46:35', 1),
(3, 1, 'Un candidat  a postulé à votre offre \"Comptable confirmé(e)\".', '2025-08-11 16:08:20', 1),
(4, 1, 'Un candidat  a postulé à votre offre \"Comptable confirmé(e)\".', '2025-08-11 16:17:58', 1),
(5, 5, 'Un candidat  a postulé à votre offre \"Développeur Full Stack (JavaScript / Node.js / React)\".', '2025-08-12 12:00:49', 1),
(6, 2, 'Un candidat  a postulé à votre offre \"Développeur Full Stack (JavaScript / Node.js / React)\".', '2025-08-12 15:01:24', 1),
(7, 5, 'Un candidat  a postulé à votre offre \"Développeur Front-End\".', '2025-08-14 11:03:06', 1),
(8, 5, 'Un candidat  a postulé à votre offre \"Comptable confirmé(e)\".', '2025-08-20 15:49:21', 1),
(9, 2, 'Un candidat  a postulé à votre offre \"Comptable confirmé(e)\".', '2025-08-22 08:30:15', 1),
(12, 5, 'Un candidat  a postulé à votre offre \"Comptable\".', '2025-08-27 17:18:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

CREATE TABLE `offre` (
  `idof` int(11) NOT NULL,
  `titre` varchar(132) NOT NULL,
  `description` varchar(132) NOT NULL,
  `lieu` varchar(48) NOT NULL,
  `type` varchar(32) NOT NULL,
  `contrat` varchar(32) NOT NULL,
  `idrecru` int(3) NOT NULL,
  `date_pub` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`idof`, `titre`, `description`, `lieu`, `type`, `contrat`, `idrecru`, `date_pub`) VALUES
(1, 'Recrutement ', 'Izahay dia mitady Developpeur web', 'Ambatolahikosoa', 'offre ', '5mois', 1, '2025-07-31 14:09:25'),
(2, 'Empoi', 'Asa trano', 'Antaradolo', 'stage', '2mois', 0, '2025-07-31 14:09:25'),
(4, 'Comptable', 'mitady comptable izahay ato @ orinasa', 'Imandry', 'Stage', '5ans', 1, '2025-07-31 14:09:25'),
(7, 'Mpiasa', 'Mitady olona hiasa antrano', 'Andafy', 'SSD', '4ans', 1, '2025-07-31 14:09:25'),
(8, 'hotel', 'Mitady mpiasa hiasa aminy hotel lehibe iray', 'Nosy b', 'SSD', '2mois', 1, '2025-07-31 14:09:25'),
(10, 'jhuuzy', 'fjhkhf', 'jfhkjhg', 'joe gbèeè', 'kgj tu vy y', 1, '2025-07-31 16:35:24'),
(11, 'Développeur web', 'Nous recherchons un(e) Développeur Web Full Stack passionné(e) pour rejoindre notre équipe dynamique. Vous participerez au développe', 'Antananarivo', 'Stage', 'travail indépendant', 5, '2025-08-04 09:19:23'),
(13, 'Développeur Full Stack JavaScript (React / Node.js)', 'Nous recherchons un développeur Full Stack passionné et expérimenté pour rejoindre notre équipe dynamique. Vous serez responsable de', 'Antananarivo, Madagascar (possibilité de télétra', 'CDI', 'CDI (Contrat à Durée Indéterminé', 1, '2025-08-11 12:45:28'),
(14, 'Comptable confirmé(e)', 'Nous recherchons un(e) comptable rigoureux(se) et organisé(e) pour gérer la comptabilité générale de notre entreprise. Vous serez en', 'Antananarivo, Madagascar', 'CDD', 'CDD de 12 mois avec possibilité ', 1, '2025-08-11 14:07:25'),
(15, 'Mpanadio trano sy mpanasa lamba', 'Tokantrano iray ao Antananarivo no mitady olona azo itokisana, madio sy mazoto, hanao asa an-trano isan’andro. Ny andraikitra dia ah', 'Antananarivo', 'CDI', '1 taona ', 3, '2025-08-12 08:53:09'),
(16, 'Mpanampy an-trano', 'Fianakaviana iray ao Antsirabe no mitady mpanampy an-trano maharitra. Ny andraikitra dia ny fanadiovana trano, fanasana vilia, fanam', 'Antsirabe', 'CDD', 'Asa feno ora (Lundi–Samedi)', 3, '2025-08-12 08:55:35'),
(17, 'Mpanampy amin’ny lakozia (Cuisinière an-trano)', 'Tokantrano iray ao Mahajanga no mitady vehivavy mahay mahandro sakafo isan-karazany (malagasy sy vahiny) ary mahay mikarakara lataba', 'Mahajanga', 'CDD', 'Karama isam-bolana, hifanarahana', 3, '2025-08-12 08:57:27'),
(18, 'Mpanadio trano sy mpanasa lamba', 'Tokantrano iray no mitady olona azo itokisana hanao fanadiovana trano, fanasana lamba, fanamboarana fandriana ary fanampiana ao an-d', 'Antananarivo', 'CDI', 'Asa feno ora (Lundi–Samedi)', 2, '2025-08-12 09:05:44'),
(19, ' Mpitaiza sy mpikarakara zaza', ' Fianakaviana mitady olona tia ankizy, mahay mikarakara sakafo sy manampy amin’ny fanabeazana fototra, sady mahay manao fanadiovana ', 'Antsirabe', 'Freelance', ' Asa feno ora', 2, '2025-08-12 09:06:38'),
(20, 'Développeur Full Stack (JavaScript / Node.js / React)', 'Orinasa teknolojia mitady mpamorona rindranasa web manana traikefa amin’ny Front-end sy Back-end. Asa ahitana ny famolavolana, ny fa', 'Antananarivo (misy télétravail)', 'CDI', 'Asa feno ora', 2, '2025-08-12 09:07:35'),
(21, 'Comptable confirmé(e)', ' Orinasa mitady mpiasa hitarika sy hitantana ny fitantanam-bola, hanomana tatitra ara-bola sy ny fandoavana hetra.', 'Antananarivo', 'CDD', 'Asa feno ora', 2, '2025-08-12 09:08:25'),
(30, 'Comptable', 'Nous recherchons un(e) Comptable motivé(e) et rigoureux(se) pour assurer la gestion financière et comptable de notre organisation. V', 'Toamasina', 'CDI', '5mois', 5, '2025-08-27 15:17:14');

-- --------------------------------------------------------

--
-- Structure de la table `recruteur`
--

CREATE TABLE `recruteur` (
  `idrecru` int(3) NOT NULL,
  `photorecru` varchar(255) DEFAULT NULL,
  `nomrecru` varchar(255) DEFAULT NULL,
  `email` varchar(36) DEFAULT NULL,
  `numtelrecru` varchar(255) DEFAULT NULL,
  `idutil` int(3) NOT NULL,
  `secteur` varchar(100) DEFAULT NULL,
  `adrsrecru` varchar(32) DEFAULT NULL,
  `siteweb` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `recruteur`
--

INSERT INTO `recruteur` (`idrecru`, `photorecru`, `nomrecru`, `email`, `numtelrecru`, `idutil`, `secteur`, `adrsrecru`, `siteweb`) VALUES
(1, '688b82bd3f93a_entreprise.jpg', 'Job for all', 'andriahasiniainafiderana@gmail.com', '0342265798', 6, 'Developeur web', 'Antanimena', 'job.com'),
(2, '689b032a1ceb9_recru.jpg', 'Recruiter', 'soa@gmail.com', '038555555', 11, 'Manao tolotrasa rehetra', 'Imandry Fianarantsoa', 'http/ljobo'),
(3, '688651ca72343_entreprise6.jpg', 'Entreprise du futur', 'bozy@gmail.com', '0332563658', 12, 'Asa trano rehetra', 'Fianarantsoa', 'http://good.com'),
(5, '6890c103b01fb_entreprise dev.jpg', 'Code Crafters', 'Crafters*@gmail.com', '0347768822', 43, 'Informatique et développement web', 'Fianarantsoa', 'Codecrafters.mg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idutil` int(3) NOT NULL,
  `mdputil` varchar(32) NOT NULL,
  `Emailutil` varchar(100) NOT NULL,
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idutil`, `mdputil`, `Emailutil`, `role`) VALUES
(1, '12345678', 'test@gmail.com', 'candidat'),
(4, 'heihz', 'andriahasiniaina@gmail.com', 'candidat'),
(6, 'Fiderana04', 'andriahasiniainafiderana@gmail.com', 'recruteur'),
(7, 'fiderana', 'fiderana@gmail.com', 'recruteur'),
(9, 'mirindra', 'mirindra@gmail.com', 'recruteur'),
(10, 'herve', 'herve@gmail.com', 'recruteur'),
(11, 'soa', 'soa@gmail.com', 'recruteur'),
(12, 'bozy', 'bozy@gmail.com', 'recruteur'),
(13, 'bozy', 'bozy@gmail.com', 'recruteur'),
(14, 'bozy', 'bozy@gmail.com', 'recruteur'),
(15, 'dera', 'dera@gmail.com', 'recruteur'),
(16, 'Diary', 'Raoelison@gmail.com', 'recruteur'),
(17, 'Diary', 'Raoelison@gmail.com', 'recruteur'),
(19, 'Diary', 'Diary@gmail.com', 'recruteur'),
(25, 'kjklj', 'fiderana@gmail.com', 'recruteur'),
(37, 'Natacha', 'Natacha@gmail.com', 'candidat'),
(38, 'Mimi', 'Mimi@gmeil.com', 'candidat'),
(40, 'Arsene', 'Arsene@gmail.com', 'candidat'),
(43, 'Noely', 'Noely@gmail.com', 'recruteur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `candidat`
--
ALTER TABLE `candidat`
  ADD PRIMARY KEY (`idcand`);

--
-- Index pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`idcandidature`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`idnotif`),
  ADD KEY `idcand` (`idcand`);

--
-- Index pour la table `notification_recruteur`
--
ALTER TABLE `notification_recruteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idrecru` (`idrecru`);

--
-- Index pour la table `offre`
--
ALTER TABLE `offre`
  ADD PRIMARY KEY (`idof`);

--
-- Index pour la table `recruteur`
--
ALTER TABLE `recruteur`
  ADD PRIMARY KEY (`idrecru`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idutil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidat`
--
ALTER TABLE `candidat`
  MODIFY `idcand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `candidature`
--
ALTER TABLE `candidature`
  MODIFY `idcandidature` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `idnotif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `notification_recruteur`
--
ALTER TABLE `notification_recruteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `offre`
--
ALTER TABLE `offre`
  MODIFY `idof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `recruteur`
--
ALTER TABLE `recruteur`
  MODIFY `idrecru` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idutil` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`idcand`) REFERENCES `candidat` (`idcand`);

--
-- Contraintes pour la table `notification_recruteur`
--
ALTER TABLE `notification_recruteur`
  ADD CONSTRAINT `notification_recruteur_ibfk_1` FOREIGN KEY (`idrecru`) REFERENCES `recruteur` (`idrecru`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
