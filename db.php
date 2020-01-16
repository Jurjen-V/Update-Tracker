<?php
  echo "koe";
  $dbhost = "rdbms.strato.de";
  $dbname = "DB4001610";
  $user = "U4001610";
  $pass = "XYymJZVP8i!LC52";
    // $dbhost = 'localhost';
    // $dbname = "Project_scherm2";
    // $user = 'root';
    // $pass = ''; 
    
try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
echo "paard";
  $result_projects = $conn->prepare("
    -- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 09 jan 2020 om 09:28
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.8

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update-tracker1`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `software`
--

CREATE TABLE `software` (
  `ID` int(11) NOT NULL,
  `Software` varchar(255) NOT NULL,
  `Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `software`
--

INSERT INTO `software` (`ID`, `Software`, `Version`) VALUES
(1, 'Powerpont', 5856),
(2, 'Word', 112365),
(3, 'Photo shop', 311),
(4, 'Adobe XD', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Admin` int(11) NOT NULL DEFAULT '0',
  `Paying` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`ID`, `Username`, `Email`, `Password`, `Admin`, `Paying`) VALUES
(2, 'Admin', 'Admin@admin.nl', '$2y$10$m.CW6lsLWp3pm93rZARtAuvN0fp3uYyAyysggHPf9GyG4PSuIiiiG', 1, 0),
(5, 'Test', 'Test@test.nl', '$2y$10$DWpNirzjGZTanHjZYBeiEOSSorTMv6VGuQb2XpsSbjvAA9F1QYrIm', 0, 1),
(6, 'Jurjen', 'jurjen.veenstra@hotmail.nl', '$2y$10$tKm0k7h/U7/r.YHGAgkR8uLawORQHkkVrqjB9Az1CHS0lyQzR3Hui', 0, 0),
(7, 'TestAdmin', 'TestAdmin@Admin.nl', '$2y$10$XkJ0BnqchbbzdwlF3E5TB.m/3oFU.caagtBrjQ6uB0jmEh42y9P..', 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `usersoftware`
--

CREATE TABLE `usersoftware` (
  `usersoftwareID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Software_ID` int(11) NOT NULL,
  `Current_Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `usersoftware`
--

INSERT INTO `usersoftware` (`usersoftwareID`, `User_ID`, `Software_ID`, `Current_Version`) VALUES
(9, 2, 1, 5),
(10, 2, 2, 3),
(26, 6, 1, 311),
(27, 6, 3, 311),
(29, 5, 3, 2),
(31, 5, 2, 5856);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `usersoftware`
--
ALTER TABLE `usersoftware`
  ADD PRIMARY KEY (`usersoftwareID`),
  ADD KEY `UserSoftware_fk0` (`User_ID`),
  ADD KEY `UserSoftware_fk1` (`Software_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `software`
--
ALTER TABLE `software`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `usersoftware`
--
ALTER TABLE `usersoftware`
  MODIFY `usersoftwareID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `usersoftware`
--
ALTER TABLE `usersoftware`
  ADD CONSTRAINT `UserSoftware_fk0` FOREIGN KEY (`User_ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `UserSoftware_fk1` FOREIGN KEY (`Software_ID`) REFERENCES `software` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

");
$result_projects->execute();
if($result_projects) // will return true if succefull else it will return false
{
  echo "succes";
}else{
  echo "fout";
}
echo "koe";