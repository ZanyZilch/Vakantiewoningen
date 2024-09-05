-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 27 okt 2023 om 23:58
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

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
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `house`
--

INSERT INTO `house` (`houseID`, `omschrijving`, `adress`, `postcode`, `provincie`, `stad`, `prijs`, `userID`) VALUES
(6, 'Dit is een huis', ' 45', '56565y', 'aalsmeer', 'apenstad', 300000, 28),
(29, 'asdad', 'asdasd', 'asdas', 'asdada', 'asdad', 32443, 2),
(30, 'safdasff', 'asffsaf', 'asfsaf', 'asfasfas', 'afsafsafs', 4234234, 5);

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
(6, 'afbeeldingen/kers', 20),
(29, 'asdasda', 22),
(30, 'asdasdas', 23);

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
(2, 'asdad123@hotmail.com', '$2y$10$uAMvy.ubwsaD/VCiGvSdpe4saY/GC3OZEe3IKIQKNQ7d7a4afk50u', 0, 'asdasd123'),
(5, 'harold@hotmail.nl', '123456', 1, 'Haroldharkema'),
(28, 'harold@hotmail.nl', '123456', 1, '5');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`houseID`),
  ADD KEY `fk_user` (`userID`);

--
-- Indexen voor tabel `house_images`
--
ALTER TABLE `house_images`
  ADD PRIMARY KEY (`imageID`),
  ADD KEY `houseID` (`houseID`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `house`
--
ALTER TABLE `house`
  MODIFY `houseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `house_images`
--
ALTER TABLE `house_images`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Beperkingen voor tabel `house_images`
--
ALTER TABLE `house_images`
  ADD CONSTRAINT `house_images_ibfk_1` FOREIGN KEY (`houseID`) REFERENCES `house` (`houseID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
