-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 14 mai 2025 à 19:52
-- Version du serveur : 8.0.31
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `houscity`
--

-- --------------------------------------------------------

--
-- Structure de la table `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `about`
--

INSERT INTO `about` (`id`, `title`, `content`, `image`) VALUES
(2, 'About Us', '<p style=\"text-align: center;\">About Us</p>\r\n<p>Welcome to [Platform Name], your trusted online marketplace for real estate transactions. Our mission is to simplify the buying, selling, and renting process, making it accessible and efficient for everyone.</p>\r\n<p>&nbsp;Who We Are<br />At [Platform Name], we are a team of passionate real estate professionals and tech enthusiasts dedicated to creating an innovative platform that meets the diverse needs of our users. Our platform is designed to connect buyers, sellers, and renters seamlessly, providing a user-friendly experience for all.</p>\r\n<p>&nbsp;Our Vision<br />We envision a world where finding and listing properties is straightforward and stress-free. Our goal is to empower users with the tools they need to make informed decisions in their real estate journeys.</p>\r\n<p>What We Offer<br />- User-Friendly Interface: Our platform features a clean, intuitive design that allows users to easily navigate and find properties.<br />- Comprehensive Listings: Explore a wide range of properties, from residential homes to commercial spaces, with detailed descriptions, images, and maps.<br />- Advanced Search Tools: Utilize our advanced search filters to quickly find properties that match your specific needs and preferences.<br />- Administrative Support: Our dedicated administration team ensures that all listings are accurate, up-to-date, and monitored for quality.</p>\r\n<p>Commitment to Excellence<br />We are committed to providing exceptional service and support to our users. Our team continuously seeks feedback to enhance the platform and ensure it meets the evolving needs of the real estate market.</p>\r\n<p>Join us at [Platform Name] and experience a new standard in real estate transactions. Whether you&rsquo;re buying, selling, or renting, we are here to help you every step of the way.</p>\r\n<p>&nbsp;</p>', 'WhatsApp Video 2024-12-23 at 00.37.29_96dbbeb1.mp4');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `aid` int NOT NULL AUTO_INCREMENT,
  `auser` varchar(50) NOT NULL,
  `aemail` varchar(50) NOT NULL,
  `apass` varchar(50) NOT NULL,
  `adob` date NOT NULL,
  `aphone` varchar(15) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`aid`, `auser`, `aemail`, `apass`, `adob`, `aphone`) VALUES
(1, 'admin', 'admin@gmail.com', '6812f136d636e737248d365016f8cfd5139e387c', '1994-12-06', '1470002569'),
(4, 'yahya', 'yahyazaizi01@gmail.com', '1938b79762f018cf11cc7d1011b8157840d37e60', '1994-12-06', '1470002569');

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `ctid` int NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) NOT NULL,
  `sid` int NOT NULL,
  PRIMARY KEY (`ctid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `city`
--

INSERT INTO `city` (`ctid`, `cname`, `sid`) VALUES
(6, 'Olisphis', 1),
(7, 'Alegas', 2),
(8, 'Floson', 3),
(9, 'Ulmore', 4),
(10, 'Awrerton', 5),
(11, 'Marrakech', 8);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `cid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(250) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`cid`, `name`, `email`, `phone`, `subject`, `message`) VALUES
(1, 'codeastro', 'asda@asd.com', '8888885454', 'codeastro.com', 'asdasdasd'),
(2, 'codeastro', 'asda@asd.com', '8888885454', 'codeastro.com', 'asdasdasd'),
(3, 'zaizi YAHYA', 'yahyag@gmail.com', '0620973651', 'discussion', 'nice projects');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conversation_hash` varchar(32) NOT NULL,
  `property_id` int NOT NULL,
  `user_id` int NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `property_title` varchar(255) NOT NULL,
  `last_message` datetime DEFAULT CURRENT_TIMESTAMP,
  `unread_count` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `conversation_hash`, `property_id`, `user_id`, `contact_name`, `property_title`, `last_message`, `unread_count`, `created_at`, `updated_at`) VALUES
(14, '063f4eb85f93683bd0207fd1fcbfe250', 4, 50, 'ahmed', 'Riad Rabat', '2025-04-26 15:59:35', 5, '2025-04-26 15:53:34', '2025-04-26 15:59:35'),
(15, '586a0fea91bbbbbf391de536d8b6f6c8', 6, 50, 'ahmed', 'Appartement Agadir', '2025-04-28 16:06:52', 4, '2025-04-26 15:54:10', '2025-04-28 16:06:52'),
(16, '44d9516848b2ae78c9acc650ecf99b8c', 2, 49, 'qwer', 'riad marrakech', '2025-04-26 16:11:22', 5, '2025-04-26 16:01:48', '2025-04-26 16:11:22'),
(17, 'edf21f8e4367fc32451bb79f875be926', 4, 49, 'qwer', 'Riad Rabat', '2025-04-26 16:11:31', 6, '2025-04-26 16:02:01', '2025-04-26 16:11:31'),
(18, 'ca40c78250d91205d3702d24793b4230', 9, 49, 'qwer', 'Maison Fès', '2025-04-26 16:11:46', 2, '2025-04-26 16:11:46', '2025-04-26 16:11:46'),
(19, '6248ab4f7c0d7a68d2ebd9e864bc2fd0', 5, 50, 'ahmed', 'Maison Oujda', '2025-05-14 12:10:52', 9, '2025-04-28 16:07:06', '2025-05-14 12:10:52');

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `fid` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `fdescription` varchar(300) NOT NULL,
  `status` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `feedback`
--

INSERT INTO `feedback` (`fid`, `uid`, `fdescription`, `status`, `date`) VALUES
(3, 43, 'ok', 1, '2024-10-16 22:48:45'),
(4, 41, 'nice', 1, '2024-12-23 00:21:37'),
(5, 41, 'hi', 0, '2025-04-08 16:51:27'),
(6, 41, 'nice', 0, '2025-04-09 10:07:31');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `reply_to` int DEFAULT '0',
  `property_id` int NOT NULL,
  `conversation_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `sender_id`, `receiver_id`, `reply_to`, `property_id`, `conversation_id`, `created_at`, `is_read`) VALUES
(10, 'ahmed', 'ahmed@gmail.com', 'cghjk', 50, 41, 0, 4, 14, '2025-04-26 15:53:34', 0),
(11, 'ahmed', 'ahmed@gmail.com', 'cghjk', 50, 41, 0, 6, 15, '2025-04-26 15:54:10', 0),
(19, 'yahyag', 'yahyag@gmail.com', 'nmn,m', 41, 50, 0, 4, 14, '2025-04-26 15:57:36', 0),
(23, 'ahmed', 'ahmed@gmail.com', 'hhh', 50, 41, 0, 6, 15, '2025-04-26 15:59:42', 0),
(24, 'qwer', 'qwer@gmail.com', 'jhk', 49, 41, 0, 2, 16, '2025-04-26 16:01:48', 0),
(25, 'qwer', 'qwer@gmail.com', 'nbm,', 49, 41, 0, 4, 17, '2025-04-26 16:02:01', 0),
(26, 'qwer', 'qwer@gmail.com', 'jh', 49, 41, 0, 2, 16, '2025-04-26 16:02:16', 0),
(27, 'qwer', 'qwer@gmail.com', 'nm', 49, 41, 0, 4, 17, '2025-04-26 16:02:25', 0),
(30, 'yahyag', 'yahyag@gmail.com', 'bnm', 41, 49, 0, 4, 17, '2025-04-26 16:03:22', 0),
(31, 'yahyag', 'yahyag@gmail.com', 'bnm', 41, 49, 0, 2, 16, '2025-04-26 16:03:32', 0),
(37, 'yahyag', 'yahyag@gmail.com', 'hjk', 41, 49, 0, 4, 17, '2025-04-26 16:09:56', 0),
(39, 'qwer', 'qwer@gmail.com', 'ghj', 49, 41, 0, 2, 16, '2025-04-26 16:11:22', 0),
(40, 'qwer', 'qwer@gmail.com', 'hgj', 49, 41, 0, 4, 17, '2025-04-26 16:11:31', 0),
(41, 'qwer', 'qwer@gmail.com', 'ghhvj', 49, 41, 0, 9, 18, '2025-04-26 16:11:46', 0),
(42, 'ahmed', 'ahmed@gmail.com', 'gg', 50, 41, 0, 6, 15, '2025-04-28 16:06:52', 0),
(43, 'ahmed', 'ahmed@gmail.com', 'ghj', 50, 41, 0, 5, 19, '2025-04-28 16:07:06', 0),
(44, 'yahyag', 'yahyag@gmail.com', 'asa', 41, 50, 0, 5, 19, '2025-04-28 16:07:43', 0),
(45, 'yahyag', 'yahyag@gmail.com', 'asas', 41, 50, 0, 5, 19, '2025-04-28 16:07:48', 0),
(46, 'ahmed', 'ahmed@gmail.com', 'ghh', 50, 41, 0, 5, 19, '2025-04-30 12:58:25', 0),
(48, 'ahmed', 'ahmed@gmail.com', 'le prix svp', 50, 41, 0, 5, 19, '2025-05-02 15:02:47', 0),
(49, 'yahyag', 'yahyag@gmail.com', 'sire te9ewed', 41, 50, 0, 5, 19, '2025-05-02 15:03:11', 0),
(50, 'ahmed', 'ahmed@gmail.com', 'hjk', 50, 41, 0, 5, 19, '2025-05-14 12:10:40', 0),
(51, 'ahmed', 'ahmed@gmail.com', 'le prix svp', 50, 41, 0, 5, 19, '2025-05-14 12:10:52', 0);

-- --------------------------------------------------------

--
-- Structure de la table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `pcontent` longtext NOT NULL,
  `type` varchar(100) NOT NULL,
  `bhk` varchar(50) NOT NULL,
  `stype` varchar(100) NOT NULL,
  `bedroom` int NOT NULL,
  `bathroom` int NOT NULL,
  `balcony` int NOT NULL,
  `kitchen` int NOT NULL,
  `hall` int NOT NULL,
  `floor` varchar(50) NOT NULL,
  `size` int NOT NULL,
  `price` int NOT NULL,
  `location` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `feature` longtext NOT NULL,
  `pimage` varchar(300) NOT NULL,
  `pimage1` varchar(300) NOT NULL,
  `pimage2` varchar(300) NOT NULL,
  `pimage3` varchar(300) NOT NULL,
  `pimage4` varchar(300) NOT NULL,
  `uid` int NOT NULL,
  `status` varchar(50) NOT NULL,
  `mapimage` varchar(300) NOT NULL,
  `topmapimage` varchar(300) NOT NULL,
  `groundmapimage` varchar(300) NOT NULL,
  `totalfloor` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isFeatured` int DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `property`
--

INSERT INTO `property` (`pid`, `title`, `pcontent`, `type`, `bhk`, `stype`, `bedroom`, `bathroom`, `balcony`, `kitchen`, `hall`, `floor`, `size`, `price`, `location`, `city`, `state`, `feature`, `pimage`, `pimage1`, `pimage2`, `pimage3`, `pimage4`, `uid`, `status`, `mapimage`, `topmapimage`, `groundmapimage`, `totalfloor`, `date`, `isFeatured`) VALUES
(2, 'riad marrakech', '<ul>\r\n<li>Riad Marrakech</li>\r\n<li>S&eacute;jour authentique Marrakech</li>\r\n<li>Meilleurs riads &agrave; Marrakech</li>\r\n<li>H&eacute;bergement traditionnel Marrakech</li>\r\n</ul>', 'house', '2 BHK', 'sale', 5, 8, 0, 3, 1, '2nd Floor', 200, 200000, ' MARRAKECH', 'Marrakech', 'Marrakech-Safi ', '<p>&nbsp;</p>\r\n<!---feature area start--->\r\n<div class=\"col-md-4\">\r\n<ul>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Property Age : </span>10 Years</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Swiming Pool : </span>Yes</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Parking : </span>Yes</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">GYM : </span>Yes</li>\r\n</ul>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<ul>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Type : </span>Apartment</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Security : </span>Yes</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Dining Capacity : </span>10 People</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Church/Temple : </span>No</li>\r\n</ul>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<ul>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">3rd Party : </span>No</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Elevator : </span>Yes</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">CCTV : </span>Yes</li>\r\n<li class=\"mb-3\"><span class=\"text-secondary font-weight-bold\">Water Supply : </span>Ground Water / Tank</li>\r\n</ul>\r\n</div>\r\n<!---feature area end---->\r\n<p>&nbsp;</p>', 'images (2).jpg', 'téléchargement.jpg', 'images (1).jpg', 'images (1).jpg', 'images.jpg', 41, 'available', 'images (2).jpg', 'téléchargement (1).jpg', 'téléchargement (1).jpg', '4 Floor', '2024-10-13 13:33:43', 1),
(3, 'Appartement Gueliz', '', 'apartment', '1 BHK', 'sale', 2, 1, 1, 1, 1, '1st Floor', 90, 120000, 'Avenue Mohammed V', 'Marrakech', 'Marrakech-Safi', '<p>Modern apartment in the heart of Gueliz, close to all amenities.</p>', 'images (5).jpg', 'images (4).jpg', 'images (4).jpg', 'téléchargement (5).jpg', 'téléchargement (6).jpg', 2, 'sold out', 'téléchargement (6).jpg', 'téléchargement (4).jpg', 'téléchargement (3).jpg', '1 Floor', '2023-05-22 12:00:00', 1),
(4, 'Riad Rabat', '', 'house', '5 BHK', 'sale', 4, 3, 2, 1, 1, '1st Floor', 2800, 500000, 'Old Medina', 'Rabat', 'Rabat-Salé-Kénitra', '<p>Elegant riad with traditional Moroccan d&eacute;cor and ample amenities.</p>', 'téléchargement (6).jpg', 'téléchargement (1).jpg', 'téléchargement (4).jpg', 'images (5).jpg', 'images (3).jpg', 41, 'available', 'images (5).jpg', 'téléchargement (7).jpg', 'images (3).jpg', '6 Floor', '2023-06-01 15:45:00', 1),
(5, 'Maison Oujda', '', 'house', '3 BHK', 'sale', 3, 2, 1, 1, 1, '3rd Floor', 140, 200000, 'Quartier Al Qods', 'Oujda', 'Oriental', '<p>Modern house with garden space and updated amenities.</p>', 'téléchargement (6).jpg', 'téléchargement (3).jpg', 'images (5).jpg', 'téléchargement (6).jpg', 'téléchargement (4).jpg', 41, 'available', 'images (5).jpg', 'téléchargement (8).jpg', 'images (3).jpg', '1 Floor', '2023-07-10 09:15:00', 1),
(6, 'Appartement Agadir', '', 'apartment', '2 BHK', 'rent', 3, 2, 1, 1, 1, '1st Floor', 100, 1000, 'Boulevard Hassan II', 'Agadir', 'Souss-Massa', '<p>Spacious apartment near the beach with a view of the ocean.</p>', 'téléchargement (2).jpg', 'images (3).jpg', 'téléchargement (3).jpg', 'téléchargement (6).jpg', 'images (3).jpg', 41, 'available', 'téléchargement (4).jpg', 'téléchargement (6).jpg', 'images (4).jpg', '3 Floor', '2023-08-05 16:00:00', 1),
(7, 'Villa Tanger', 'Beautiful villa with panoramic views of the mountains and city.', 'villa', '3 BHK', 'sale', 4, 3, 1, 1, 1, '2nd Floor', 2300, 450000, 'Mountain View', 'Tanger', 'Tanger-Tétouan-Al Hoceïma', '', 'images (1).jpg', 'images (3).jpg', 'téléchargement (8).jpg', 'images (1).jpg', 'images (3).jpg', 2, 'available', 'images (3).jpg', 'images.jpg', 'téléchargement (3).jpg', '3 Floor', '2023-09-15 18:00:00', 1),
(8, 'Dar Zitoune', '', 'house', '1 BHK', 'rent', 4, 3, 1, 1, 1, '1st Floor', 150, 1800, 'Quartier Zitoune', 'Meknès', 'Fès-Meknès', '<p>Traditional Moroccan house with a central courtyard.</p>', 'téléchargement (8).jpg', 'téléchargement (2).jpg', 'images (3).jpg', 'téléchargement (5).jpg', 'téléchargement (5).jpg', 41, 'available', 'images (7).jpg', 'téléchargement (4).jpg', 'téléchargement (5).jpg', '2 Floor', '2023-09-30 13:10:00', 0),
(9, 'Maison Fès', '', 'house', '2 BHK', 'sale', 3, 2, 1, 1, 1, '1st Floor', 120, 210000, 'Quartier Médina', 'Fès', 'Fès-Meknès', '<p>Beautiful traditional Moroccan house with spacious rooms.</p>', 'téléchargement (8).jpg', 'téléchargement (4).jpg', 'images (6).jpg', 'téléchargement (4).jpg', 'téléchargement (6).jpg', 41, 'available', 'téléchargement (6).jpg', 'images.jpg', 'images (6).jpg', '3 Floor', '2023-03-12 10:00:00', 1),
(10, 'Villa Casablanca', '', 'apartment', '2 BHK', 'sale', 5, 4, 2, 1, 1, '2nd Floor', 2500, 3500, 'Quartier Anfa', 'Casablanca', 'Casablanca-Settat', '', '2.jpg', 'images (1).jpg', 'images (7).jpg', 'images (6).jpg', 'images (5).jpg', 41, 'available', 'téléchargement (1).jpg', 'images.jpg', 'zillhms7.jpg', '2 Floor', '2023-04-15 11:30:00', 1),
(25, 'Obcaecati natus pari', 'Consequatur Veniam', 'villa', '2,3,4 BHK', 'rent', 1, 5, 5, 6, 5, '5th Floor', 45678, 504, 'Hic qui illo illum ', 'Et expedita error et', 'tyu', '', 'images (6).jpg', 'main-bg.jpg', 'images (1).jpg', 'images.jpg', '4.jpg', 41, 'available', 'images (2).jpg', 'téléchargement (7).jpg', 'téléchargement (1).jpg', '14 Floor', '2025-05-14 18:48:56', 1);

-- --------------------------------------------------------

--
-- Structure de la table `replies`
--

DROP TABLE IF EXISTS `replies`;
CREATE TABLE IF NOT EXISTS `replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `reply_message` text NOT NULL,
  `reply_to` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `sid` int NOT NULL AUTO_INCREMENT,
  `sname` varchar(100) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `state`
--

INSERT INTO `state` (`sid`, `sname`) VALUES
(1, 'Colotana'),
(2, 'Floaii'),
(3, 'Virconsin'),
(4, 'West Misstana'),
(5, 'New Pennrk'),
(6, 'Louiswa'),
(7, 'Wisginia'),
(8, 'MARAKECH'),
(9, 'colotana'),
(10, 'Floaii'),
(11, 'MARAKECH');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL,
  `uemail` varchar(100) NOT NULL,
  `uphone` varchar(20) NOT NULL,
  `upass` varchar(50) NOT NULL,
  `utype` varchar(50) NOT NULL,
  `uimage` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`uid`, `uname`, `uemail`, `uphone`, `upass`, `utype`, `uimage`) VALUES
(1, 'John Doe', 'john@example.com', '1234567890', 'securepassword', 'admin', 'user_image.jpg'),
(2, 'bro', 'bro@example.com', '123456789', '123456789', 'user', 'user_image.jpg'),
(3, 'yahya', 'yahya@gmail.com', '123456789', 'securepassword', 'admin', 'admin_image.jpg'),
(28, 'Christine', 'christine@mail.com', '7777444455', '6812f136d636e737248d365016f8cfd5139e387c', 'user', 'gr7.png'),
(29, 'Alice Howard', 'howarda@mail.com', '7775552214', '6812f136d636e737248d365016f8cfd5139e387c', 'agent', 'avatarm2-min.jpg'),
(30, 'Thomas Olson', 'thomas@mail.com', '7896665555', '6812f136d636e737248d365016f8cfd5139e387c', 'user', 'avatarm7-min.jpg'),
(31, 'Cynthia N. Moore', 'moore@mail.com', '7896547855', '6812f136d636e737248d365016f8cfd5139e387c', 'agent', 'user-default-3-min.png'),
(32, 'Carl Jones', 'carl@mail.com', '1458887969', '6812f136d636e737248d365016f8cfd5139e387c', 'agent', 'user-profile-min.png'),
(33, 'Noah Stones', 'noah@mail.com', '7965555544', '6812f136d636e737248d365016f8cfd5139e387c', 'user', 'usersys-min.png'),
(34, 'Fred Godines', 'fred@mail.com', '7850002587', '6812f136d636e737248d365016f8cfd5139e387c', 'builder', 'user-a-min.png'),
(35, 'Michael', 'michael@mail.com', '8542221140', '6812f136d636e737248d365016f8cfd5139e387c', 'user', 'usric.png'),
(36, 'name', 'name@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', ''),
(37, 'zaizi', 'yahya3@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', ''),
(38, 'rel', 'yahya6@gmail.com', '0620973651', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', ''),
(39, 'yahya', 'yahya1@gmail.com', '0620973651', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', ''),
(41, 'yahyag', 'yahyag@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'agent', ''),
(42, 'user', 'user@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', 'images\\admin\\useruser-a-min.png'),
(43, 'user', 'user1@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', 'admin/user/user-a-min.png'),
(44, 'user', 'user3@gmail.com', '0624832740', '1938b79762f018cf11cc7d1011b8157840d37e60', 'user', 'Image4.png'),
(45, 'builder', 'builder@gmail.com', '0620973651', '1938b79762f018cf11cc7d1011b8157840d37e60', 'builder', 'admin/user/user-profile-min.png'),
(46, 'yahya2', 'yahya2@gmail.com', '0620', 'eb3572b3bfd6671bda433d833269915de607d86f', 'user', 'admin/user/user-profile-min.png'),
(47, 'imrane', 'imrane@gmail.com', '0620973651', 'cd026c231b9efef517688e8afbb155405a5210f9', 'user', 'imga.jpeg'),
(48, 'Winifred Medina', 'xipyzili@mailinator.com', '+1 (273) 244-4613', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'user', 'admin/user/user-profile-min.png'),
(49, 'qwer', 'qwer@gmail.com', '0624832740', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'user', 'admin/user/user-profile-min.png'),
(50, 'ahmed', 'ahmed@gmail.com', '0620973651', 'f6dba485a813489308105f4f240e42114125a71e', 'user', 'admin/user/user-profile-min.png');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `state` (`sid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `property` (`pid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_4` FOREIGN KEY (`property_id`) REFERENCES `property` (`pid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
