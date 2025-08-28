-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 26, 2025 at 10:47 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centres`
--

DROP TABLE IF EXISTS `centres`;
CREATE TABLE IF NOT EXISTS `centres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centres`
--

INSERT INTO `centres` (`id`, `nom`, `adresse`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Zenith', 'Casablanca Zenith', 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(2, 'Ain Sebaa', 'Casablanca Ain Sebaa', 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(3, 'Mly Youssef', 'Casablanca Moulay Youssef', 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `fichier_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier_nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_fichier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taille_fichier` bigint DEFAULT NULL,
  `matiere_id` bigint UNSIGNED NOT NULL,
  `niveau_id` bigint UNSIGNED DEFAULT NULL,
  `ordre` int NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cours_matiere_id_foreign` (`matiere_id`),
  KEY `cours_niveau_id_foreign` (`niveau_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id`, `titre`, `description`, `fichier_path`, `fichier_nom`, `type_fichier`, `taille_fichier`, `matiere_id`, `niveau_id`, `ordre`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Espagnol_Cours1', 'Espppppppppppppppppppppppagnol', 'cours/1756204011_badge-0134-2025-08-25.pdf', '1756204011_badge-0134-2025-08-25.pdf', 'pdf', 12926, 1, 1, 0, 1, '2025-08-26 09:26:51', '2025-08-26 09:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jour_feries`
--

DROP TABLE IF EXISTS `jour_feries`;
CREATE TABLE IF NOT EXISTS `jour_feries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('fixe','mobile') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixe',
  `recurrent` tinyint(1) NOT NULL DEFAULT '1',
  `annee` int DEFAULT NULL,
  `couleur` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#dc2626',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jour_feries_nom_date_unique` (`nom`,`date`),
  KEY `jour_feries_date_actif_index` (`date`,`actif`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jour_feries`
--

INSERT INTO `jour_feries` (`id`, `nom`, `date`, `description`, `type`, `recurrent`, `annee`, `couleur`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Jour de l\'An', '2025-01-01', 'Premier jour de l\'année civile', 'fixe', 1, 2025, '#6f460b', 1, '2025-08-24 10:57:48', '2025-08-26 08:43:27'),
(2, 'Fête du Manifeste de l\'Indépendance', '2025-01-11', 'Commémoration du manifeste de l\'indépendance', 'fixe', 1, NULL, '#dc2626', 1, '2025-08-24 10:57:48', '2025-08-26 08:43:31'),
(3, 'Fête du Travail', '2025-05-01', 'Journée internationale des travailleurs', 'fixe', 1, NULL, '#16a34a', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(4, 'Fête du Trône', '2025-07-30', 'Fête nationale du Royaume du Maroc', 'fixe', 1, NULL, '#dc2626', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(5, 'Révolution du Roi et du Peuple', '2025-08-20', 'Commémoration de la révolution', 'fixe', 1, NULL, '#dc2626', 1, '2025-08-24 10:57:48', '2025-08-26 08:47:13'),
(6, 'Fête de la Jeunesse', '2025-08-21', 'Anniversaire du Roi Mohammed VI', 'fixe', 1, NULL, '#ca8a04', 1, '2025-08-24 10:57:48', '2025-08-26 08:47:27'),
(7, 'Marche Verte', '2025-11-06', 'Commémoration de la Marche Verte', 'fixe', 1, NULL, '#16a34a', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(8, 'Fête de l\'Indépendance', '2025-11-18', 'Indépendance du Maroc', 'fixe', 1, NULL, '#dc2626', 1, '2025-08-24 10:57:48', '2025-08-26 08:43:36'),
(9, 'Aïd al-Fitr', '2025-03-31', 'Fête de la rupture du jeûne (fin du Ramadan)', 'mobile', 0, 2025, '#9333ea', 1, '2025-08-24 10:57:48', '2025-08-26 08:43:23'),
(10, 'Aïd al-Adha', '2025-06-07', 'Fête du sacrifice', 'mobile', 0, 2025, '#9333ea', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(11, 'Nouvel An Hégire', '2025-06-27', 'Premier jour de l\'année islamique', 'mobile', 0, 2025, '#9333ea', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(12, 'Mawlid (Naissance du Prophète)', '2025-09-05', 'Anniversaire de la naissance du Prophète Mohammed', 'mobile', 0, 2025, '#9333ea', 1, '2025-08-24 10:57:48', '2025-08-24 10:57:48'),
(14, 'Velit tempor est do', '2026-01-01', 'Nostrum et accusanti', 'fixe', 0, 2026, '#9333ea', 1, '2025-08-25 11:06:34', '2025-08-25 11:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `a_niveaux` tinyint(1) NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `description`, `a_niveaux`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Espagnol', 'Cours de langue espagnole', 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(2, 'Français', 'Cours de langue française', 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(3, 'Anglais', 'Cours de langue anglaise', 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(4, 'Histoire et Littérature', 'Cours d\'histoire et de littérature', 0, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_18_114649_create_parascolaires_table', 2),
(5, '2025_08_21_133242_create_centres_table', 3),
(6, '2025_08_21_133251_create_options_table', 3),
(7, '2025_08_21_133302_create_planifications_table', 3),
(8, '2025_08_24_115019_create_jour_feries_table', 4),
(9, '2025_08_26_100916_create_matieres_table', 5),
(10, '2025_08_26_100925_create_niveaux_table', 5),
(11, '2025_08_26_100932_create_cours_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matiere_id` bigint UNSIGNED NOT NULL,
  `ordre` int NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `niveaux_matiere_id_foreign` (`matiere_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `niveaux`
--

INSERT INTO `niveaux` (`id`, `nom`, `matiere_id`, `ordre`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'A1', 1, 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(2, 'A2', 1, 2, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(3, 'B1', 1, 3, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(4, 'B2', 1, 4, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(5, 'A1', 2, 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(6, 'A2', 2, 2, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(7, 'B1', 2, 3, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(8, 'B2', 2, 4, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(9, 'A1', 3, 1, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(10, 'A2', 3, 2, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(11, 'B1', 3, 3, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40'),
(12, 'B2', 3, 4, 1, '2025-08-26 09:10:40', '2025-08-26 09:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_id` bigint UNSIGNED NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `options_centre_id_foreign` (`centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `nom`, `centre_id`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Selectividad', 1, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(2, 'Selectividad Parallèle', 1, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(3, 'Selectividad', 2, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(4, 'Selectividad Parallèle', 2, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(5, 'Selectividad', 3, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10'),
(6, 'Selectividad Parallèle', 3, 1, '2025-08-21 12:39:10', '2025-08-21 12:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `parascolaires`
--

DROP TABLE IF EXISTS `parascolaires`;
CREATE TABLE IF NOT EXISTS `parascolaires` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_evenement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jour_evenement` date NOT NULL,
  `lieu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parascolaires`
--

INSERT INTO `parascolaires` (`id`, `nom_evenement`, `jour_evenement`, `lieu`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tournoi de Football Inter-Classes', '2025-09-15', 'Terrain de Sport Principal', 'Compétition de football entre toutes les classes de l\'école. Les équipes seront formées par niveau. Finale prévue en fin de journée avec remise des prix.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(2, 'Spectacle de Fin d\'Année', '2025-06-20', 'Auditorium de l\'École', 'Spectacle présenté par les élèves avec danses, chants, théâtre et musique. Participation de tous les niveaux scolaires.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(3, 'Concours de Sciences', '2025-10-10', 'Laboratoire de Sciences', 'Concours de projets scientifiques où les élèves présentent leurs expériences et découvertes. Jury composé de professeurs et d\'experts.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(4, 'Journée Porte Ouverte', '2025-03-25', 'Ensemble de l\'École', 'Présentation de l\'école aux futurs élèves et à leurs parents. Visite des classes, démonstrations d\'activités et rencontres avec les enseignants.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(5, 'Marathon de Lecture', '2025-04-15', 'Bibliothèque', 'Événement de promotion de la lecture où les élèves participent à des activités autour des livres, contes et storytelling.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(6, 'Exposition d\'Art', '2025-05-08', 'Hall Principal', 'Exposition des œuvres créées par les élèves en cours d\'arts plastiques. Vernissage avec présence des familles.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(7, 'Sortie Éducative au Musée', '2025-11-12', 'Musée National', 'Visite éducative au musée national pour découvrir l\'histoire et la culture locale. Transport en bus organisé.', '2025-08-18 10:52:44', '2025-08-18 10:52:44'),
(8, 'Atelier Cuisine Internationale', '2025-12-05', 'Cuisine Pédagogique', 'Découverte de plats traditionnels de différents pays. Les élèves cuisinent et dégustent ensemble.', '2025-08-18 10:52:44', '2025-08-18 11:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `planifications`
--

DROP TABLE IF EXISTS `planifications`;
CREATE TABLE IF NOT EXISTS `planifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `centre_id` bigint UNSIGNED NOT NULL,
  `option_id` bigint UNSIGNED NOT NULL,
  `titre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_fichier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semaine_debut` date NOT NULL,
  `semaine_fin` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planifications_centre_id_foreign` (`centre_id`),
  KEY `planifications_option_id_foreign` (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `planifications`
--

INSERT INTO `planifications` (`id`, `centre_id`, `option_id`, `titre`, `fichier_path`, `type_fichier`, `semaine_debut`, `semaine_fin`, `description`, `actif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Planning_Semaine_1', 'planifications/1755783826_1_1.pdf', 'pdf', '2025-08-25', '2025-08-31', 'Hhhhhhhhhhhhhhhhhhhhhhhhhhh', 1, '2025-08-21 12:43:47', '2025-08-21 12:43:47'),
(4, 3, 5, 'Planning_123', 'planifications/1755786879_3_5.pdf', 'pdf', '2025-08-21', '2025-08-21', NULL, 1, '2025-08-21 13:34:39', '2025-08-21 13:34:39'),
(5, 2, 3, 'Planning Semestre 3', 'planifications/1756115605_2_3.pdf', 'pdf', '2025-09-01', '2025-09-07', 'Hhhhhhhhhhhhhhhhhhhhhhhhh', 1, '2025-08-25 08:53:25', '2025-08-25 08:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5h6Z3EjXVbd6QhuVqv8edj6kBl5ahimJ8AGCt2uc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM205ZHNPTlRGS0VkQmpJaDVXSEtBR09PcnQ2aVhTdFQwWDdGQldkQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9qb3Vycy1mZXJpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1756204296),
('6T4WZd7KXWbOh7Bv3J6LhYV5aDtS5MUuqG1zdhNg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemNaRHp6ZXVGbFRhcVBqNzF4RWRUUHl4emtmb3Vjd2l0Z3VHR29WQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kb2N1bWVudHM/aWQ9NDZhZjJlYTItMDgzOS00ZjYyLWJlNzQtN2Y3ZmZhZTViNjExJnZzY29kZUJyb3dzZXJSZXFJZD0xNzU2MjA0MjIzODQzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTA0OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZG9jdW1lbnRzP2lkPTQ2YWYyZWEyLTA4MzktNGY2Mi1iZTc0LTdmN2ZmYWU1YjYxMSZ2c2NvZGVCcm93c2VyUmVxSWQ9MTc1NjIwNDIyMzg0MyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756204224),
('qK8BfFyeJFY1m3jsvQkwdLXjfyYRHfQuli8ih0Ck', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.103.2 Chrome/138.0.7204.100 Electron/37.2.3 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTdHS201azRYaDV4cHVadnJPWnFxWlQxM3Y3WkhFYkpqZmQxNlU1ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756204225);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hassan', 'hassanboukhal6@gmail.com', NULL, '$2y$12$AJ7Ogt3jLQBltgykP8GNbORHo/k2PNNPBWaHgrnCFMk5nsYcEfVvO', NULL, '2025-08-15 11:06:26', '2025-08-15 11:06:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
