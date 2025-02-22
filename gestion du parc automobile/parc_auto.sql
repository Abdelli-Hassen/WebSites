-- XAMPP-Lite
-- version 8.4.1
-- https://xampplite.sf.net/
--
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 07:19 PM
-- Server version: 11.4.4-MariaDB-log
-- PHP Version: 8.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parc_auto`
--

-- --------------------------------------------------------

--
-- Table structure for table `carburant`
--

CREATE TABLE `carburant` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `date_remplissage` date NOT NULL,
  `litres` decimal(10,2) NOT NULL,
  `prix_par_litre` decimal(10,2) NOT NULL,
  `kilometrage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carburant`
--

INSERT INTO `carburant` (`id`, `id_vehicule`, `date_remplissage`, `litres`, `prix_par_litre`, `kilometrage`) VALUES
(3, 17, '2025-01-08', 4.00, 4.00, 1),
(4, 17, '2025-01-11', 87.00, 87.00, 6),
(5, 17, '2024-12-31', 67.00, 34.00, 4),
(6, 17, '2025-01-30', 9.00, 4.00, 6),
(7, 17, '2025-02-07', 4.00, 3.00, -14),
(8, 17, '2025-01-31', 67.00, 66.00, 45),
(9, 17, '2024-12-31', 4.00, 3.00, 3),
(10, 17, '2025-01-03', 1.00, 2.00, 3),
(11, 17, '2025-01-09', 4.00, 4.00, 4),
(12, 17, '2025-01-10', 2.00, 0.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `conducteurs`
--

CREATE TABLE `conducteurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `numero_licence` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conducteurs`
--

INSERT INTO `conducteurs` (`id`, `nom`, `numero_licence`, `telephone`) VALUES
(1, 'Hassen', '645765', '22422540');

-- --------------------------------------------------------

--
-- Table structure for table `entretiens`
--

CREATE TABLE `entretiens` (
  `id` int(11) NOT NULL,
  `immatriculation` varchar(50) DEFAULT NULL,
  `date_entretien` date DEFAULT NULL,
  `kilometrage` int(11) DEFAULT NULL,
  `type_entretien` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entretiens`
--

INSERT INTO `entretiens` (`id`, `immatriculation`, `date_entretien`, `kilometrage`, `type_entretien`) VALUES
(1, '1234vfsfs', '2025-01-28', 344, 'pneus'),
(2, '1234vfsfs', '2025-01-30', 344, 'révision');

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) DEFAULT NULL,
  `id_conducteur` int(11) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `objectif` text DEFAULT NULL,
  `km_estimes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `id_vehicule`, `id_conducteur`, `destination`, `date_debut`, `date_fin`, `objectif`, `km_estimes`) VALUES
(6, 17, 1, 'tunis', '2024-12-30', '2025-01-08', 'rifjmokdc', 2345678),
(8, 17, 1, 'sousse', '2025-01-01', '2025-01-21', 'meeting', 165),
(9, 17, 1, 'nabel', '2025-01-09', '2025-01-30', 'harissa', 388),
(10, 17, 1, 'seliana', '2025-01-03', '2025-01-30', 'snow', 234),
(11, 17, 1, 'mestir', '2024-12-30', '2025-01-07', 'bhar', 65),
(12, 17, 1, 'sidibouzid', '2024-12-31', '2025-01-04', 'study', 365),
(13, 17, 1, 'jandouba', '2024-12-30', '2025-01-10', 'jw', 245),
(14, 17, 1, 'tunis', '2025-01-01', '2025-02-01', 'merwe7', 365);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom_utilisateur`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'Nour', 'NourHamdy013@gmail.com', 'nounou', 'admin', '2025-01-18 06:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `vehicules`
--

CREATE TABLE `vehicules` (
  `id` int(11) NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  `marque` varchar(100) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `date_derniere_revision` date DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'mission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicules`
--

INSERT INTO `vehicules` (`id`, `immatriculation`, `marque`, `modele`, `kilometrage`, `date_derniere_revision`, `type`) VALUES
(17, '456-DEg', 'toyota', 'golf', 2333, '2025-01-10', 'mission'),
(18, '230tunis2049', 'Supraa', '1997', 30459, '2025-01-10', 'mission');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carburant`
--
ALTER TABLE `carburant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicule` (`id_vehicule`);

--
-- Indexes for table `conducteurs`
--
ALTER TABLE `conducteurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entretiens`
--
ALTER TABLE `entretiens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicule` (`id_vehicule`),
  ADD KEY `id_conducteur` (`id_conducteur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carburant`
--
ALTER TABLE `carburant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `conducteurs`
--
ALTER TABLE `conducteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `entretiens`
--
ALTER TABLE `entretiens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carburant`
--
ALTER TABLE `carburant`
  ADD CONSTRAINT `carburant_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicules` (`id`);

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicules` (`id`),
  ADD CONSTRAINT `missions_ibfk_2` FOREIGN KEY (`id_conducteur`) REFERENCES `conducteurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
