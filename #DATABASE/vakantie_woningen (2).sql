-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 05 sep 2024 om 13:14
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vakantie_woningen`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `eigenschappen`
--

CREATE TABLE `eigenschappen` (
  `eigenschapID` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `eigenschappen`
--

INSERT INTO `eigenschappen` (`eigenschapID`, `naam`) VALUES
(2, 'Zwembad op het park '),
(3, 'Winkel op het park '),
(4, 'Entertainment op het park'),
(5, 'Op een privépark ');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `house`
--

CREATE TABLE `house` (
  `houseID` int(11) NOT NULL,
  `omschrijving` longtext NOT NULL,
  `adress` varchar(255) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `provincie` varchar(255) NOT NULL,
  `stad` varchar(255) NOT NULL,
  `prijs` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `verkocht` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `house`
--

INSERT INTO `house` (`houseID`, `omschrijving`, `adress`, `postcode`, `provincie`, `stad`, `prijs`, `userID`, `verkocht`) VALUES
(1, 'Dit charmante huis beschikt over een prachtige tuin, een groene oase van rust en schoonheid. Met een weelderig gazon, kleurrijke bloemen en schaduwrijke bomen biedt de tuin de ideale plek om te ontspannen, te spelen en te genieten van de buitenlucht. Een perfecte omgeving voor tuinliefhebbers en quality time in de natuur.', 'Van hardenbroeklaan 45', '3832CV', 'Utrecht', 'Leusden', 40000000, 36, 1),
(2, 'Modern, luxe en super energiezuinig! Deze prachtige tussenwoning is voorzien van een royale woonkamer, luxe open keuken, nette badkamer, 4 slaapkamers en een keurig onderhouden achtertuin.', 'Frans Halsstraat 19', '4625BR', 'Noord-Brabant', 'Bergen op Zoom', 365000, 36, 0),
(3, 'Uniek, zeer ruim en ideaal voor jou en je hele familie! Deze gigantische tussenwoning beschikt over maar liefst 2 woonkamers, 2 keukens, 2 badkamers en 6 slaapkamers.', 'Oostgat 18', '4341LE', 'Zeeland', 'Arnemuiden', 400, NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `house_eigenschappen`
--

CREATE TABLE `house_eigenschappen` (
  `house_id` int(11) NOT NULL,
  `eigenschap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `house_eigenschappen`
--

INSERT INTO `house_eigenschappen` (`house_id`, `eigenschap_id`) VALUES
(1, 2),
(1, 5),
(2, 3),
(2, 4),
(3, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `house_images`
--

CREATE TABLE `house_images` (
  `houseID` int(11) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `imageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `house_images`
--

INSERT INTO `house_images` (`houseID`, `img_path`, `imageID`) VALUES
(1, '828_2160.jpg', 1),
(1, '824_2160.jpg', 2),
(1, '816_2160.jpg', 3),
(2, 'huis.jpg', 4),
(2, 'm.jpg', 5),
(2, 'slaapkamer.jpg', 6),
(2, 'keuken.jpg', 7),
(1, '805_2160.jpg', 12);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `house_ligging`
--

CREATE TABLE `house_ligging` (
  `house_id` int(11) NOT NULL,
  `ligging_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `house_ligging`
--

INSERT INTO `house_ligging` (`house_id`, `ligging_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ligging`
--

CREATE TABLE `ligging` (
  `liggingID` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ligging`
--

INSERT INTO `ligging` (`liggingID`, `naam`) VALUES
(1, 'Dicht bij een bos'),
(2, 'Dicht bij een stad'),
(4, 'In het heuvelland'),
(6, 'Aan het water'),
(49, 'DIcht bij het strand');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `wachtwoord` varchar(255) DEFAULT NULL,
  `rol` tinyint(1) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`userID`, `email`, `wachtwoord`, `rol`, `username`) VALUES
(35, 'evertvandeventer@hotmail.nl', '$2y$10$r.s4zq17sDG8T7.mJfYnM.6Ncz2KKY2n/oIGBTU3w8i1CNJJQCEXe', 0, 'Evert van Deventer'),
(36, 'harold@hotmail.nl', '$2y$10$7mfqRtqrxlrzT4bwbGIkgO51ydJRaXALcDldTVxMOdyhQybsSxE6.', 1, 'Harold de makelaar'),
(38, 'maekal@hotmail.nl', '$2y$10$tjphrDUFNFh2vw12Kz7wXO1nph5nPPVwGEU09lYqJ8qcTEbxORFG.', 1, 'Makelaar2');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `eigenschappen`
--
ALTER TABLE `eigenschappen`
  ADD PRIMARY KEY (`eigenschapID`);

--
-- Indexen voor tabel `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`houseID`),
  ADD KEY `fk_user` (`userID`);

--
-- Indexen voor tabel `house_eigenschappen`
--
ALTER TABLE `house_eigenschappen`
  ADD PRIMARY KEY (`house_id`,`eigenschap_id`),
  ADD KEY `eigenschap_id` (`eigenschap_id`);

--
-- Indexen voor tabel `house_images`
--
ALTER TABLE `house_images`
  ADD PRIMARY KEY (`imageID`),
  ADD KEY `houseID` (`houseID`);

--
-- Indexen voor tabel `house_ligging`
--
ALTER TABLE `house_ligging`
  ADD PRIMARY KEY (`house_id`,`ligging_id`),
  ADD KEY `ligging_id` (`ligging_id`);

--
-- Indexen voor tabel `ligging`
--
ALTER TABLE `ligging`
  ADD PRIMARY KEY (`liggingID`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `eigenschappen`
--
ALTER TABLE `eigenschappen`
  MODIFY `eigenschapID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `house`
--
ALTER TABLE `house`
  MODIFY `houseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `house_images`
--
ALTER TABLE `house_images`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT voor een tabel `ligging`
--
ALTER TABLE `ligging`
  MODIFY `liggingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Beperkingen voor tabel `house_eigenschappen`
--
ALTER TABLE `house_eigenschappen`
  ADD CONSTRAINT `house_eigenschappen_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `house` (`houseID`),
  ADD CONSTRAINT `house_eigenschappen_ibfk_2` FOREIGN KEY (`eigenschap_id`) REFERENCES `eigenschappen` (`eigenschapID`);

--
-- Beperkingen voor tabel `house_images`
--
ALTER TABLE `house_images`
  ADD CONSTRAINT `house_images_ibfk_1` FOREIGN KEY (`houseID`) REFERENCES `house` (`houseID`);

--
-- Beperkingen voor tabel `house_ligging`
--
ALTER TABLE `house_ligging`
  ADD CONSTRAINT `house_ligging_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `house` (`houseID`),
  ADD CONSTRAINT `house_ligging_ibfk_2` FOREIGN KEY (`ligging_id`) REFERENCES `ligging` (`liggingID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
