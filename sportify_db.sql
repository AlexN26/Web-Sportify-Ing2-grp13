-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 mai 2025 à 14:53
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sportify_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `coachs`
--

DROP TABLE IF EXISTS `coachs`;
CREATE TABLE IF NOT EXISTS `coachs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `domaine_expertise` varchar(100) DEFAULT NULL,
  `diplomes` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `experience` text,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `username` varchar(191) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coachs`
--

INSERT INTO `coachs` (`id`, `nom`, `prenom`, `age`, `domaine_expertise`, `diplomes`, `telephone`, `email`, `experience`, `description`, `photo`, `username`, `password`) VALUES
(1, 'Verwilghen', 'Vincent', 34, 'Triathlon', 'Master STAPS, Diplôme d\'État d\'Entraîneur de Triathlon, Formation Nutrition Sportive', '+33 6 58 42 91 00', 'vincent.triathlon@sportify.fr', 'Ancien athlète semi-pro ayant participé à plus de 20 Ironman à travers le monde. 12 ans d\'expérience en coaching, notamment au sein du pôle espoir de triathlon de Toulouse. A coaché plus de 300 athlètes amateurs et élites.', 'Vincent est un coach méthodique, rigoureux et passionné, avec un œil chirurgical pour la technique de course et un mental de feu. Son objectif : transformer ses athlètes en véritables machines de guerre, capables de mater une ligne d\'arrivée sans cligner des yeux. Il croit fermement que la régularité et l\'adaptation sont les clés de la performance durable. Il est aussi réputé pour ses blagues douteuses sur les barres énergétiques.', 'Images/Vincent_verwilghen.jpg', 'vincent1', 'password123'),
(2, 'Durand', 'Cédric', 36, 'Musculation', 'BPJEPS AF, Certificat haltérophilie', '+33 6 01 23 45 67', 'Ccedric.muscu@sportify.fr', 'Coach depuis 14 ans, ancien compétiteur en force athlétique.', 'Cédric transforme les crevettes en bulldozers. Il croit au pouvoir d’un squat profond et d’un mental en béton. “Tant que tu transpires pas sur la barre, t’as pas fini.”', 'Images/Cedric.jpeg', NULL, ''),
(3, 'Rodriguez', 'Alvaro', 41, 'Fitness', 'BPJEPS AF, Zumba & HIIT Certified', '+33 6 79 88 55 33', 'alvaro.fitness@sportify.fr', '15 ans d’expérience en cours collectifs et transformation physique.', 'Alvaro te fait bouger avec une énergie nucléaire. Il matraque tes abdos en rythme, entre deux pas de salsa cardio.', 'Images/alvaro.jpeg', NULL, ''),
(4, 'Marchand', 'Lucie', 31, 'Biking', 'Coach Spinning Pro, Licence STAPS', '+33 7 12 34 56 78', 'lucie.biking@sportify.fr', 'Ancienne cycliste élite reconvertie en coach indoor.', 'Lucie t’embarque pour une étape du Tour sans quitter la salle. Ses cuisses te jugent si tu descends sous les 200 watts.', 'Images/lucie.jpeg', NULL, ''),
(5, 'Morel', 'Kévin', 35, 'Cardio-Training', 'Coach Sport-Santé, HIIT & Tabata', '+33 6 78 90 12 34', 'kevin.cardio@sportify.fr', '10 ans dans des centres de rééducation et salles de sport.', 'Kévin t’explique le cardio comme une équation mathématique. Il t’aide à mater ton VO2max en douceur... ou pas.', 'Images/kevin.jpeg', NULL, ''),
(6, 'Martin', 'Chloé', 28, 'Cours Collectifs', 'Pilates, TRX, Zumba Certified', '+33 7 98 76 54 32', 'chloe.group@sportify.fr', 'Plus de 1000 cours animés en France et en Belgique.', 'Chloé transforme chaque cours en show. Tu viens pour transpirer, tu repars avec la banane. Elle te fait mater tes complexes à coups de playlists bien salées.', 'Images/chloe.jpeg', NULL, ''),
(7, 'Lopez', 'Jordan', 33, 'Basketball', 'Entraîneur FFBB, BE Basketball', '+33 6 56 43 21 90', 'jordan.basket@sportify.fr', 'Ex-meneur en Pro B, entraîneur des U18 régionaux.', 'Jordan dribble mieux qu’il parle. Il te transforme en machine de contre-attaque et te fait mater les paniers comme des mouches.', 'Images/jordan.jpeg', NULL, ''),
(8, 'Abdelhamid', 'Sofiane', 37, 'Football', 'Licence UEFA B, préparateur physique', '+33 6 12 13 14 15', 'sofiane.foot@sportify.fr', 'Ancien joueur en N3, entraîneur U17 élite à Lyon.', 'Sofiane c’est la tactique avant tout. Il t’aide à mater l’espace, le timing, et les lucarnes opposées.', 'Images/sofyan.jpeg', NULL, ''),
(9, 'Bernard', 'Loïc', 39, 'Rugby', 'Entraîneur FFR Niveau 2, Licence STAPS', '+33 6 78 98 56 90', 'loic.rugby@sportify.fr', '15 ans dans le Top 14 comme préparateur.', 'Loïc te fait mater le terrain avec une discipline militaire et des charges de buffle. À côté, la mêlée c’est une balade.', 'Images/loic.jpeg', NULL, ''),
(10, 'Neyrinck', 'Alexandre', 29, 'Tennis', 'Diplôme d\'État de Tennis, Analyse Vidéo FFT', '+33 7 62 55 13 20', 'alex.tennis@sportify.fr', 'Coach régional FFT, spécialisé dans le service et les coups liftés.', 'Alexandre te fait mater des balles à effet comme des missiles téléguidés. Il voit chaque mouvement au ralenti. Il dit souvent : “Si tu frappes sans penser, tu rates comme un pigeon bourré.”', 'Images/alex_neyrinck.jpg', NULL, ''),
(11, 'Moretti', 'Giulia', 34, 'Natation', 'BEESAN, Maître-nageur', '+33 6 44 33 22 11', 'giulia.natation@sportify.fr', 'Championne junior d’Italie, coach élite depuis 8 ans.', 'Giulia nage plus vite que les ragots. Elle te fait mater la technique à la Michael Phelps et te corrige la moindre ondulation de flemme.', 'Images/giulia.jpeg', NULL, ''),
(12, 'Contentin', 'Brice', 38, 'Plongeon', 'Diplôme FINA, Formation acrobatie aquatique', '+33 6 71 45 89 01', 'brice.plongeon@sportify.fr', 'Plongeur pro reconverti en entraîneur artistique.', 'Brice vole mieux qu’un pigeon voyageur. Il te fait mater la peur du vide et t’apprend à tomber avec classe, grâce, et une rotation arrière bien propre.', 'Images/brice.png', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

DROP TABLE IF EXISTS `disponibilite`;
CREATE TABLE IF NOT EXISTS `disponibilite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coach_id` int NOT NULL,
  `jour` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `coach_id` (`coach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `disponibilite`
--

INSERT INTO `disponibilite` (`id`, `coach_id`, `jour`, `heure_debut`, `heure_fin`, `disponible`) VALUES
(1, 1, 'lundi', '09:00:00', '11:00:00', 1),
(2, 1, 'jeudi', '14:00:00', '16:00:00', 1),
(3, 1, 'samedi', '10:00:00', '12:00:00', 1),
(4, 2, 'mardi', '08:00:00', '12:00:00', 1),
(5, 2, 'jeudi', '08:00:00', '10:00:00', 1),
(6, 2, 'vendredi', '14:00:00', '16:00:00', 1),
(7, 3, 'lundi', '13:00:00', '15:00:00', 1),
(8, 3, 'mercredi', '09:00:00', '11:00:00', 1),
(9, 3, 'vendredi', '17:00:00', '19:00:00', 1),
(10, 4, 'mardi', '10:00:00', '12:00:00', 1),
(11, 4, 'jeudi', '15:00:00', '17:00:00', 1),
(12, 5, 'mercredi', '10:00:00', '12:00:00', 1),
(13, 5, 'vendredi', '14:00:00', '16:00:00', 1),
(14, 5, 'samedi', '08:00:00', '10:00:00', 1),
(15, 6, 'lundi', '18:00:00', '20:00:00', 1),
(16, 6, 'mercredi', '12:00:00', '14:00:00', 1),
(17, 6, 'dimanche', '10:00:00', '12:00:00', 1),
(18, 7, 'mardi', '16:00:00', '18:00:00', 1),
(19, 7, 'vendredi', '10:00:00', '12:00:00', 1),
(20, 8, 'lundi', '08:00:00', '10:00:00', 1),
(21, 8, 'mercredi', '15:00:00', '17:00:00', 1),
(22, 8, 'samedi', '13:00:00', '15:00:00', 1),
(23, 9, 'mardi', '13:00:00', '15:00:00', 1),
(24, 9, 'jeudi', '08:00:00', '10:00:00', 1),
(25, 10, 'mercredi', '17:00:00', '19:00:00', 1),
(26, 10, 'vendredi', '09:00:00', '11:00:00', 1),
(27, 10, 'dimanche', '15:00:00', '17:00:00', 1),
(28, 11, 'mardi', '07:00:00', '09:00:00', 1),
(29, 11, 'jeudi', '10:00:00', '12:00:00', 1),
(30, 11, 'samedi', '16:00:00', '18:00:00', 1),
(31, 12, 'lundi', '11:00:00', '13:00:00', 1),
(32, 12, 'mercredi', '08:00:00', '10:00:00', 1),
(33, 12, 'vendredi', '16:00:00', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_username` varchar(255) NOT NULL,
  `receiver_username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_username` (`sender_username`(250)),
  KEY `receiver_username` (`receiver_username`(250))
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_username`, `receiver_username`, `message`, `timestamp`) VALUES
(1, 'client1', 'vincent', 'lalalalalalal', '2025-05-28 16:59:22'),
(2, 'client1', 'vincent', 'lalalalalalal', '2025-05-28 16:59:29'),
(3, 'client1', 'vincent', 'alex est full bg', '2025-05-28 17:34:31'),
(4, 'client1', 'vincent1', 'bubuvezbvize', '2025-05-28 17:36:18'),
(5, 'client1', 'vincent1', 'alex est full bg', '2025-05-28 17:43:37'),
(6, 'client1', 'vincent1', 'Bonjour', '2025-05-28 21:01:23'),
(7, 'vincent1', 'client1', 'lalalalaal', '2025-05-29 11:56:55'),
(8, 'vincent1', 'client1', 'lalalalala', '2025-05-29 11:59:42'),
(9, 'vincent1', 'client1', 'bonjour', '2025-05-29 12:00:29'),
(10, 'vincent1', 'client1', 'de bruyne le goat', '2025-05-29 12:19:41');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_username` varchar(100) NOT NULL,
  `nom_complet` varchar(100) NOT NULL,
  `adresse1` varchar(255) NOT NULL,
  `adresse2` varchar(255) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(20) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `carte_etudiant` varchar(100) DEFAULT NULL,
  `type_carte` enum('Visa','MasterCard','American Express','PayPal') NOT NULL,
  `numero_carte` varchar(20) NOT NULL,
  `nom_carte` varchar(100) NOT NULL,
  `date_expiration` date NOT NULL,
  `code_securite` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_username` (`client_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_username` varchar(100) NOT NULL,
  `coach_id` int NOT NULL,
  `date_rdv` date NOT NULL,
  `heure_rdv` time NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `digicode` varchar(20) DEFAULT NULL,
  `documents_a_apporter` text,
  `statut` enum('confirmé','annulé') DEFAULT 'confirmé',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `coach_id` (`coach_id`),
  KEY `client_username` (`client_username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `client_username`, `coach_id`, `date_rdv`, `heure_rdv`, `lieu`, `digicode`, `documents_a_apporter`, `statut`, `created_at`) VALUES
(1, 'client1', 1, '2025-05-27', '14:00:00', 'Salle Omnes', NULL, NULL, 'confirmé', '2025-05-27 15:24:03');

-- --------------------------------------------------------

--
-- Structure de la table `responsables_salle`
--

DROP TABLE IF EXISTS `responsables_salle`;
CREATE TABLE IF NOT EXISTS `responsables_salle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `poste` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `responsables_salle`
--

INSERT INTO `responsables_salle` (`id`, `prenom`, `nom`, `telephone`, `email`, `poste`) VALUES
(1, 'Julien', 'Song', '0675034686', 'julien.song@omnes.fr', 'Coach référent'),
(2, 'Camille', 'Martin', '0704231474', 'camille.martin@omnes.fr', 'Responsable matériel');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('client','coach','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `created_at`, `email`) VALUES
(1, 'client1', 'password123', 'client', '2025-05-27 09:07:21', 'client1@sportify.fr'),
(2, 'coach1', 'password123', 'coach', '2025-05-27 09:07:21', 'coach1@sportify.fr'),
(3, 'admin1', 'password123', 'admin', '2025-05-27 09:07:21', 'admin1@sportify.fr'),
(4, 'coach7', 'password123', 'coach', '2025-05-27 12:47:08', 'coach7@sportify.fr'),
(5, 'coach123456', 'password123', 'coach', '2025-05-27 12:48:48', 'coach123456@sportify.fr'),
(6, 'coach2000', 'password123', 'coach', '2025-05-27 12:54:07', 'coach2000@sportify.fr'),
(7, 'vincent1', 'password123', 'coach', '2025-05-28 15:12:28', 'vincent1@sportify.fr'),
(8, 'coach_cedric', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_cedric@sportify.fr'),
(9, 'coach_alvaro', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_alvaro@sportify.fr'),
(10, 'coach_lucie', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_lucie@sportify.fr'),
(11, 'coach_kevin', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_kevin@sportify.fr'),
(12, 'coach_chloe', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_chloe@sportify.fr'),
(13, 'coach_jordan', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_jordan@sportify.fr'),
(14, 'coach_sofiane', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_sofiane@sportify.fr'),
(15, 'coach_loic', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_loic@sportify.fr'),
(16, 'coach_alexandre', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_alexandre@sportify.fr'),
(17, 'coach_giulia', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_giulia@sportify.fr'),
(18, 'coach_brice', 'password123', 'coach', '2025-05-28 15:12:28', 'coach_brice@sportify.fr');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
