-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 mai 2025 à 13:20
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coachs`
--

INSERT INTO `coachs` (`id`, `nom`, `prenom`, `age`, `domaine_expertise`, `diplomes`, `telephone`, `email`, `experience`, `description`) VALUES
(1, 'Verwilghen', 'Vincent', 34, 'Triathlon', 'Master STAPS, Diplôme d\'État d\'Entraîneur de Triathlon, Formation Nutrition Sportive', '+33 6 58 42 91 00', 'vincent.triathlon@sportify.fr', 'Ancien athlète semi-pro ayant participé à plus de 20 Ironman à travers le monde. 12 ans d\'expérience en coaching, notamment au sein du pôle espoir de triathlon de Toulouse. A coaché plus de 300 athlètes amateurs et élites.', 'Vincent est un coach méthodique, rigoureux et passionné, avec un œil chirurgical pour la technique de course et un mental de feu. Son objectif : transformer ses athlètes en véritables machines de guerre, capables de mater une ligne d\'arrivée sans cligner des yeux. Il croit fermement que la régularité et l\'adaptation sont les clés de la performance durable. Il est aussi réputé pour ses blagues douteuses sur les barres énergétiques.'),
(2, 'Durand', 'Cédric', 36, 'Musculation', 'BPJEPS AF, Certificat haltérophilie', '+33 6 01 23 45 67', 'cedric.muscu@sportify.fr', 'Coach depuis 14 ans, ancien compétiteur en force athlétique.', 'Cédric transforme les crevettes en bulldozers. Il croit au pouvoir d’un squat profond et d’un mental en béton. “Tant que tu transpires pas sur la barre, t’as pas fini.”'),
(3, 'Rodriguez', 'Alvaro', 41, 'Fitness', 'BPJEPS AF, Zumba & HIIT Certified', '+33 6 79 88 55 33', 'alvaro.fitness@sportify.fr', '15 ans d’expérience en cours collectifs et transformation physique.', 'Alvaro te fait bouger avec une énergie nucléaire. Il matraque tes abdos en rythme, entre deux pas de salsa cardio.'),
(4, 'Marchand', 'Lucie', 31, 'Biking', 'Coach Spinning Pro, Licence STAPS', '+33 7 12 34 56 78', 'lucie.biking@sportify.fr', 'Ancienne cycliste élite reconvertie en coach indoor.', 'Lucie t’embarque pour une étape du Tour sans quitter la salle. Ses cuisses te jugent si tu descends sous les 200 watts.'),
(5, 'Morel', 'Kévin', 35, 'Cardio-Training', 'Coach Sport-Santé, HIIT & Tabata', '+33 6 78 90 12 34', 'kevin.cardio@sportify.fr', '10 ans dans des centres de rééducation et salles de sport.', 'Kévin t’explique le cardio comme une équation mathématique. Il t’aide à mater ton VO2max en douceur... ou pas.'),
(6, 'Martin', 'Chloé', 28, 'Cours Collectifs', 'Pilates, TRX, Zumba Certified', '+33 7 98 76 54 32', 'chloe.group@sportify.fr', 'Plus de 1000 cours animés en France et en Belgique.', 'Chloé transforme chaque cours en show. Tu viens pour transpirer, tu repars avec la banane. Elle te fait mater tes complexes à coups de playlists bien salées.'),
(7, 'Lopez', 'Jordan', 33, 'Basketball', 'Entraîneur FFBB, BE Basketball', '+33 6 56 43 21 90', 'jordan.basket@sportify.fr', 'Ex-meneur en Pro B, entraîneur des U18 régionaux.', 'Jordan dribble mieux qu’il parle. Il te transforme en machine de contre-attaque et te fait mater les paniers comme des mouches.'),
(8, 'Abdelhamid', 'Sofiane', 37, 'Football', 'Licence UEFA B, préparateur physique', '+33 6 12 13 14 15', 'sofiane.foot@sportify.fr', 'Ancien joueur en N3, entraîneur U17 élite à Lyon.', 'Sofiane c’est la tactique avant tout. Il t’aide à mater l’espace, le timing, et les lucarnes opposées.'),
(9, 'Bernard', 'Loïc', 39, 'Rugby', 'Entraîneur FFR Niveau 2, Licence STAPS', '+33 6 78 98 56 90', 'loic.rugby@sportify.fr', '15 ans dans le Top 14 comme préparateur.', 'Loïc te fait mater le terrain avec une discipline militaire et des charges de buffle. À côté, la mêlée c’est une balade.'),
(10, 'Neyrinck', 'Alexandre', 29, 'Tennis', 'Diplôme d\'État de Tennis, Analyse Vidéo FFT', '+33 7 62 55 13 20', 'alex.tennis@sportify.fr', 'Coach régional FFT, spécialisé dans le service et les coups liftés.', 'Alexandre te fait mater des balles à effet comme des missiles téléguidés. Il voit chaque mouvement au ralenti. Il dit souvent : “Si tu frappes sans penser, tu rates comme un pigeon bourré.”'),
(11, 'Moretti', 'Giulia', 34, 'Natation', 'BEESAN, Maître-nageur', '+33 6 44 33 22 11', 'giulia.natation@sportify.fr', 'Championne junior d’Italie, coach élite depuis 8 ans.', 'Giulia nage plus vite que les ragots. Elle te fait mater la technique à la Michael Phelps et te corrige la moindre ondulation de flemme.'),
(12, 'Contentin', 'Brice', 38, 'Plongeon', 'Diplôme FINA, Formation acrobatie aquatique', '+33 6 71 45 89 01', 'brice.plongeon@sportify.fr', 'Plongeur pro reconverti en entraîneur artistique.', 'Brice vole mieux qu’un pigeon voyageur. Il te fait mater la peur du vide et t’apprend à tomber avec classe, grâce, et une rotation arrière bien propre.');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `created_at`) VALUES
(1, 'client1', 'password123', 'client', '2025-05-27 09:07:21'),
(2, 'coach1', 'password123', 'coach', '2025-05-27 09:07:21'),
(3, 'admin1', 'password123', 'admin', '2025-05-27 09:07:21'),
(4, 'coach7', 'password123', 'coach', '2025-05-27 12:47:08'),
(5, 'coach123456', 'password123', 'coach', '2025-05-27 12:48:48'),
(6, 'coach2000', 'password123', 'coach', '2025-05-27 12:54:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
