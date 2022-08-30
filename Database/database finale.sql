-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.4.24-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour auto_ecole
CREATE DATABASE IF NOT EXISTS `auto_ecole` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `auto_ecole`;

-- Listage de la structure de table auto_ecole. admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_880E0D76BF396750` FOREIGN KEY (`id`) REFERENCES `personne` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.admin : ~0 rows (environ)
INSERT INTO `admin` (`id`, `prenom`, `sex`) VALUES
	(5, 'Admin', 'Homme');

-- Listage de la structure de table auto_ecole. apprenant
CREATE TABLE IF NOT EXISTS `apprenant` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cours_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_C4EB462EBF396750` FOREIGN KEY (`id`) REFERENCES `personne` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.apprenant : ~2 rows (environ)
INSERT INTO `apprenant` (`id`, `prenom`, `sex`, `cours_active`) VALUES
	(1, 'Yohann', 'Homme', 0),
	(2, 'Yohann', 'Homme', 0);

-- Listage de la structure de table auto_ecole. apprenant_auto_ecole
CREATE TABLE IF NOT EXISTS `apprenant_auto_ecole` (
  `apprenant_id` int(11) NOT NULL,
  `auto_ecole_id` int(11) NOT NULL,
  PRIMARY KEY (`apprenant_id`,`auto_ecole_id`),
  KEY `IDX_627770E2C5697D6D` (`apprenant_id`),
  KEY `IDX_627770E2B1C987E1` (`auto_ecole_id`),
  CONSTRAINT `FK_627770E2B1C987E1` FOREIGN KEY (`auto_ecole_id`) REFERENCES `auto_ecole` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_627770E2C5697D6D` FOREIGN KEY (`apprenant_id`) REFERENCES `apprenant` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.apprenant_auto_ecole : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. apprenant_cours
CREATE TABLE IF NOT EXISTS `apprenant_cours` (
  `apprenant_id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  PRIMARY KEY (`apprenant_id`,`cours_id`),
  KEY `IDX_A3F510AC5697D6D` (`apprenant_id`),
  KEY `IDX_A3F510A7ECF78B0` (`cours_id`),
  CONSTRAINT `FK_A3F510A7ECF78B0` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A3F510AC5697D6D` FOREIGN KEY (`apprenant_id`) REFERENCES `apprenant` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.apprenant_cours : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. auto_ecole
CREATE TABLE IF NOT EXISTS `auto_ecole` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` double NOT NULL,
  `horaire_debut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `horaire_fin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_FD0557BF396750` FOREIGN KEY (`id`) REFERENCES `personne` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.auto_ecole : ~2 rows (environ)
INSERT INTO `auto_ecole` (`id`, `image`, `description`, `note`, `horaire_debut`, `horaire_fin`) VALUES
	(3, 'logo ecole.png', 'Auto ecole de Dieu', 7, '08:00', '16:00'),
	(6, 'logo ecole.png', 'A dieu la gloire', 5, '08:00', '16:00');

-- Listage de la structure de table auto_ecole. choisir
CREATE TABLE IF NOT EXISTS `choisir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_inscription` date NOT NULL,
  `satut` tinyint(1) NOT NULL,
  `id_apprenant_id` int(11) DEFAULT NULL,
  `id_ecole_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C25A4AD3E6A8081F` (`id_apprenant_id`),
  KEY `IDX_C25A4AD32734F78B` (`id_ecole_id`),
  CONSTRAINT `FK_C25A4AD32734F78B` FOREIGN KEY (`id_ecole_id`) REFERENCES `auto_ecole` (`id`),
  CONSTRAINT `FK_C25A4AD3E6A8081F` FOREIGN KEY (`id_apprenant_id`) REFERENCES `apprenant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.choisir : ~2 rows (environ)
INSERT INTO `choisir` (`id`, `date_inscription`, `satut`, `id_apprenant_id`, `id_ecole_id`) VALUES
	(9, '2022-08-19', 1, 2, 3),
	(10, '2022-08-19', 1, 1, 3);

-- Listage de la structure de table auto_ecole. cours
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu_cours` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.cours : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table auto_ecole.doctrine_migration_versions : ~8 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20220812122015', '2022-08-12 14:20:28', 615),
	('DoctrineMigrations\\Version20220812163327', '2022-08-12 18:33:35', 89),
	('DoctrineMigrations\\Version20220813041644', '2022-08-13 06:16:49', 192),
	('DoctrineMigrations\\Version20220818205358', '2022-08-18 22:54:11', 128),
	('DoctrineMigrations\\Version20220819133523', '2022-08-19 15:35:31', 70),
	('DoctrineMigrations\\Version20220819181847', '2022-08-19 20:18:51', 88),
	('DoctrineMigrations\\Version20220819182105', '2022-08-19 20:21:10', 79),
	('DoctrineMigrations\\Version20220820193224', '2022-08-30 00:28:56', 154),
	('DoctrineMigrations\\Version20220827023651', '2022-08-27 04:37:03', 57);

-- Listage de la structure de table auto_ecole. document
CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compte_id` int(11) DEFAULT NULL,
  `typedoc_id` int(11) DEFAULT NULL,
  `date_etablissement` date NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  `rappel_id_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A76F2C56620` (`compte_id`),
  KEY `IDX_D8698A76D6223D7` (`typedoc_id`),
  KEY `IDX_D8698A76B4B78D97` (`rappel_id_id`),
  CONSTRAINT `FK_D8698A76B4B78D97` FOREIGN KEY (`rappel_id_id`) REFERENCES `rappel` (`id`),
  CONSTRAINT `FK_D8698A76D6223D7` FOREIGN KEY (`typedoc_id`) REFERENCES `type_document` (`id`),
  CONSTRAINT `FK_D8698A76F2C56620` FOREIGN KEY (`compte_id`) REFERENCES `apprenant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.document : ~9 rows (environ)
INSERT INTO `document` (`id`, `compte_id`, `typedoc_id`, `date_etablissement`, `enable`, `rappel_id_id`) VALUES
	(13, 2, 1, '2020-01-01', 0, NULL),
	(14, 2, 1, '2022-01-01', 0, NULL),
	(15, 2, 1, '2019-01-01', 0, NULL),
	(16, 2, 1, '2021-01-01', 0, 13),
	(17, 2, 2, '2020-01-01', 0, 14),
	(18, 2, 1, '2027-01-01', 0, 15),
	(19, 2, 2, '2025-01-01', 0, 16),
	(20, 2, 2, '2025-01-01', 0, 17),
	(21, 2, 1, '2025-01-01', 0, 18),
	(22, 2, 2, '2022-05-07', 0, 19);

-- Listage de la structure de table auto_ecole. horaire
CREATE TABLE IF NOT EXISTS `horaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jours_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `heure` time NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BBC83DB66180639B` (`jours_id`),
  KEY `IDX_BBC83DB6613FECDF` (`session_id`),
  CONSTRAINT `FK_BBC83DB6613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_BBC83DB66180639B` FOREIGN KEY (`jours_id`) REFERENCES `jour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.horaire : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. jour
CREATE TABLE IF NOT EXISTS `jour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.jour : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `envoyer_par_id` int(11) DEFAULT NULL,
  `recu_par_id` int(11) DEFAULT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `lu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF58D4A84` (`envoyer_par_id`),
  KEY `IDX_B6BD307F59820928` (`recu_par_id`),
  CONSTRAINT `FK_B6BD307F59820928` FOREIGN KEY (`recu_par_id`) REFERENCES `personne` (`id`),
  CONSTRAINT `FK_B6BD307FF58D4A84` FOREIGN KEY (`envoyer_par_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.message : ~53 rows (environ)
INSERT INTO `message` (`id`, `envoyer_par_id`, `recu_par_id`, `contenu`, `date_envoi`, `lu`) VALUES
	(512, 2, 3, 'cc', '2022-08-27 06:00:35', 1),
	(513, 3, 2, 'Bonjour', '2022-08-27 06:01:32', 1),
	(514, 3, 2, 'hey', '2022-08-27 06:06:47', 1),
	(515, 3, 2, 'Recois tu mes messages ?', '2022-08-27 06:07:04', 1),
	(516, 3, 2, 'cc', '2022-08-27 13:36:01', 1),
	(517, 3, 2, 'test', '2022-08-27 14:36:35', 1),
	(518, 2, 3, 'hey', '2022-08-27 14:38:16', 1),
	(519, 3, 2, 'kel bail', '2022-08-27 14:39:17', 1),
	(520, 3, 2, 'Reponse', '2022-08-27 14:55:26', 1),
	(521, 3, 2, 'cc', '2022-08-27 15:08:09', 1),
	(522, 3, 2, 'Sa va?', '2022-08-27 15:08:22', 1),
	(523, 2, 3, 'Jai vu', '2022-08-27 15:11:40', 1),
	(524, 3, 2, 'fofo', '2022-08-27 15:14:26', 1),
	(525, 2, 3, 'hey', '2022-08-27 15:23:20', 1),
	(526, 3, 2, 'kel bail', '2022-08-27 15:23:34', 1),
	(527, 3, 2, 'help me', '2022-08-27 15:28:22', 1),
	(528, 3, 2, 'kooko', '2022-08-27 15:34:51', 1),
	(529, 2, 3, 'cc', '2022-08-27 16:34:40', 1),
	(530, 2, 3, 'On dit koi', '2022-08-27 16:52:59', 1),
	(531, 3, 2, 'Kel bail', '2022-08-27 17:02:20', 1),
	(532, 3, 2, 'hey', '2022-08-27 17:02:45', 1),
	(533, 2, 3, 'cc', '2022-08-27 17:03:12', 1),
	(534, 3, 2, 'hey', '2022-08-27 17:03:24', 1),
	(535, 2, 3, 'hey', '2022-08-27 17:11:34', 1),
	(536, 3, 2, 'hey', '2022-08-27 17:19:04', 1),
	(537, 2, 3, 'cc', '2022-08-27 17:20:36', 1),
	(538, 3, 2, 'cc', '2022-08-27 17:26:42', 1),
	(539, 2, 3, 'Salut', '2022-08-27 17:29:37', 1),
	(540, 2, 3, 'kel bail', '2022-08-27 17:31:59', 1),
	(541, 3, 2, 'cc', '2022-08-27 17:50:50', 1),
	(542, 2, 3, 'Weh', '2022-08-27 17:51:05', 1),
	(543, 2, 3, 'On dit quoi?', '2022-08-27 17:51:28', 1),
	(544, 3, 2, 'cc', '2022-08-27 22:57:31', 1),
	(545, 3, 2, 'cc', '2022-08-27 22:58:03', 1),
	(546, 3, 2, 'cc', '2022-08-29 18:40:08', 1),
	(547, 3, 2, 'sa va?', '2022-08-29 18:40:53', 1),
	(548, 3, 2, 'Bonjour monsieur', '2022-08-29 18:45:38', 1),
	(549, 2, 3, 'Bonjour', '2022-08-29 18:46:02', 1),
	(550, 2, 3, 'cc', '2022-08-29 18:46:24', 1),
	(551, 3, 2, 'cc', '2022-08-30 00:30:42', 1),
	(552, 3, 2, 'hey', '2022-08-30 00:32:58', 1),
	(553, 2, 3, 'cc', '2022-08-30 01:19:51', 1),
	(554, 2, 3, 'hey', '2022-08-30 01:21:13', 1),
	(555, 3, 2, 'Bonsoir', '2022-08-30 01:37:03', 1),
	(556, 2, 3, 'amenou', '2022-08-30 01:48:36', 1),
	(557, 3, 2, 'koko', '2022-08-30 01:51:29', 1),
	(558, 2, 3, 'hey', '2022-08-30 01:54:49', 1),
	(559, 2, 3, 'cc', '2022-08-30 02:00:05', 1),
	(560, 3, 2, 'hey', '2022-08-30 02:16:03', 1),
	(561, 3, 2, 'Boss', '2022-08-30 02:16:23', 1),
	(562, 3, 2, 'Kel bail', '2022-08-30 02:18:33', 1),
	(563, 2, 3, 'jojo', '2022-08-30 02:22:51', 1),
	(564, 2, 3, 'hey', '2022-08-30 02:26:24', 1);

-- Listage de la structure de table auto_ecole. mode_de_paiement
CREATE TABLE IF NOT EXISTS `mode_de_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_paiement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.mode_de_paiement : ~2 rows (environ)
INSERT INTO `mode_de_paiement` (`id`, `nom_paiement`, `enable`) VALUES
	(1, 'Tmoney', 0),
	(2, 'Flooz', 0);

-- Listage de la structure de table auto_ecole. pack
CREATE TABLE IF NOT EXISTS `pack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `nombre_heure` int(11) NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.pack : ~0 rows (environ)
INSERT INTO `pack` (`id`, `nom`, `prix`, `nombre_heure`, `enable`) VALUES
	(1, 'Pack simple', 15000, 15, 0);

-- Listage de la structure de table auto_ecole. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telephone` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  `dtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FCEC9EF450FF010` (`telephone`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.personne : ~5 rows (environ)
INSERT INTO `personne` (`id`, `telephone`, `roles`, `password`, `nom`, `addresse`, `mail`, `statut`, `enable`, `dtype`) VALUES
	(1, '+22890010829', '["ROLE_USER"]', '$2y$13$UAHcmdqpvqS3ioAQSBHcDeGwK9G/0CeKV3EXnOq4SkwEq2vhSwjJO', 'LOKO', 'BADOU', 'loko@gmail.com', 1, 0, 'apprenant'),
	(2, '+22891281270', '["ROLE_USER"]', '$2y$13$iX7UHWsA2.vEISwU53vIleDOBJ5iO0GXGu0s0h6mQ6sGHchBDLGiC', 'AHARH', 'Hedranawoe-Agbalepedo', 'yoharh56@gmail.com', 1, 0, 'apprenant'),
	(3, '+22870154896', '["ROLE_AutoEcole"]', '$2y$13$GJX2LM.kefFN.5sMUh0zbuNl2KyF07fNMnFokRylEgxWaaqIZNJPu', 'LaReference', 'Lossossime', 'lareference@gmail.com', 1, 0, 'autoecole'),
	(5, '+22870458696', '["ROLE_SUPER_ADMIN"]', '$2y$13$cjqDbo/3HhYWvMLuAdoCUuA2ExOeKsuwbK9vwAQwa0QyCvrxVMiPe', 'Admin', 'Hedranawoe', 'admin@admin.com', 1, 0, 'admin'),
	(6, '+22898364572', '["ROLE_AutoEcole"]', '$2y$13$F6w1dLpq.zSLareEnjwPZeKpwiOlcnz7pDOZCtu8F4/1dQsJXAK1W', 'DieuDonné', 'Togoville', 'dieudonne@gmail.com', 1, 0, 'autoecole');

-- Listage de la structure de table auto_ecole. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.post : ~0 rows (environ)
INSERT INTO `post` (`id`, `image`, `titre`, `contenu`, `enable`) VALUES
	(1, 'eau.png', 'Yokoumi', 'AB1\r\nIntersection où le conducteur \r\nest tenu de céder le passage \r\naux véhicules débouchant de la \r\nou des routes situées à sa droite\r\nAB2\r\nIntersection avec une route dont \r\nles usagers doivent céder le \r\npassage dans le cas où un \r\npanneau AB6 ne peut être utilisé\r\nAB3a\r\nCédez le passage à \r\nl\'intersection. Signal de position\r\nAB3b\r\nCédez le passage à \r\nl\'intersection. Signal avancé de \r\nl\'AB3a\r\nAB4\r\nArrêt à l\'intersection dans les \r\nconditions définies à l\'article \r\nR.415-6 du code de la route. \r\nSignal de position\r\nAB5\r\nArrêt à l\'intersection. Signal \r\navancé du AB4\r\nAB6\r\nIndication du caractère \r\nprioritaire d\'une route\r\nAB7\r\nFin du caractère prioritaire \r\nd\'une route\r\nAB25\r\nCarrefour à sens giratoir', 0);

-- Listage de la structure de table auto_ecole. post_apprenant
CREATE TABLE IF NOT EXISTS `post_apprenant` (
  `post_id` int(11) NOT NULL,
  `apprenant_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`apprenant_id`),
  KEY `IDX_658538D94B89032C` (`post_id`),
  KEY `IDX_658538D9C5697D6D` (`apprenant_id`),
  CONSTRAINT `FK_658538D94B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_658538D9C5697D6D` FOREIGN KEY (`apprenant_id`) REFERENCES `apprenant` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.post_apprenant : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. proposition
CREATE TABLE IF NOT EXISTS `proposition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suggestion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.proposition : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. question
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cours_dedie_id` int(11) DEFAULT NULL,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494EBD26FFD4` (`cours_dedie_id`),
  CONSTRAINT `FK_B6F7494EBD26FFD4` FOREIGN KEY (`cours_dedie_id`) REFERENCES `cours` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.question : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. question_proposition
CREATE TABLE IF NOT EXISTS `question_proposition` (
  `question_id` int(11) NOT NULL,
  `proposition_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`proposition_id`),
  KEY `IDX_24C91CDE1E27F6BF` (`question_id`),
  KEY `IDX_24C91CDEDB96F9E` (`proposition_id`),
  CONSTRAINT `FK_24C91CDE1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_24C91CDEDB96F9E` FOREIGN KEY (`proposition_id`) REFERENCES `proposition` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.question_proposition : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. rappel
CREATE TABLE IF NOT EXISTS `rappel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_doc_id` int(11) DEFAULT NULL,
  `date_expiration` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_303A29C9AF61FD51` (`id_doc_id`),
  CONSTRAINT `FK_303A29C9AF61FD51` FOREIGN KEY (`id_doc_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.rappel : ~9 rows (environ)
INSERT INTO `rappel` (`id`, `id_doc_id`, `date_expiration`) VALUES
	(10, NULL, '2021-01-01'),
	(11, NULL, '2023-01-01'),
	(12, NULL, '2020-01-01'),
	(13, NULL, '2022-01-01'),
	(14, NULL, '2022-01-01'),
	(15, NULL, '2028-01-01'),
	(16, NULL, '2030-01-01'),
	(17, NULL, '2030-01-01'),
	(18, NULL, '2026-01-01'),
	(19, NULL, '2027-05-07');

-- Listage de la structure de table auto_ecole. rapport
CREATE TABLE IF NOT EXISTS `rapport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createur_id` int(11) DEFAULT NULL,
  `date_crea` date NOT NULL,
  `time_crea` time NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BE34A09C73A201E5` (`createur_id`),
  CONSTRAINT `FK_BE34A09C73A201E5` FOREIGN KEY (`createur_id`) REFERENCES `auto_ecole` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.rapport : ~2 rows (environ)
INSERT INTO `rapport` (`id`, `createur_id`, `date_crea`, `time_crea`, `contenu`) VALUES
	(1, 3, '2022-08-17', '13:48:49', ''),
	(2, 3, '2022-08-17', '13:49:05', ''),
	(3, 3, '2022-08-18', '19:16:20', ''),
	(4, 3, '2022-08-27', '22:55:43', '');

-- Listage de la structure de table auto_ecole. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auto_ecole_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4B1C987E1` (`auto_ecole_id`),
  CONSTRAINT `FK_D044D5D4B1C987E1` FOREIGN KEY (`auto_ecole_id`) REFERENCES `auto_ecole` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.session : ~1 rows (environ)
INSERT INTO `session` (`id`, `auto_ecole_id`, `nom`, `date_debut`, `date_fin`, `enable`) VALUES
	(1, 3, 'Lundi', '2022-08-01', '2022-12-01', 1);

-- Listage de la structure de table auto_ecole. transaction
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pack_id` int(11) DEFAULT NULL,
  `id_mode_payement_id` int(11) DEFAULT NULL,
  `id_apprenant_id` int(11) DEFAULT NULL,
  `type_de_payement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cours` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_723705D1C7841B67` (`id_pack_id`),
  KEY `IDX_723705D1CC54CC3` (`id_mode_payement_id`),
  KEY `IDX_723705D1E6A8081F` (`id_apprenant_id`),
  CONSTRAINT `FK_723705D1C7841B67` FOREIGN KEY (`id_pack_id`) REFERENCES `pack` (`id`),
  CONSTRAINT `FK_723705D1CC54CC3` FOREIGN KEY (`id_mode_payement_id`) REFERENCES `mode_de_paiement` (`id`),
  CONSTRAINT `FK_723705D1E6A8081F` FOREIGN KEY (`id_apprenant_id`) REFERENCES `apprenant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.transaction : ~0 rows (environ)

-- Listage de la structure de table auto_ecole. type_document
CREATE TABLE IF NOT EXISTS `type_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` int(11) NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.type_document : ~2 rows (environ)
INSERT INTO `type_document` (`id`, `libelle`, `duree`, `enable`) VALUES
	(1, 'Visite technique', 1, 0),
	(2, 'Permis de conduire', 5, 0);

-- Listage de la structure de table auto_ecole. voir
CREATE TABLE IF NOT EXISTS `voir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `apprenant_id` int(11) NOT NULL,
  `datevisualisation` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table auto_ecole.voir : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
