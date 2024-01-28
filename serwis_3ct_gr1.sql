-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 28, 2024 at 03:28 AM
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serwis_3ct_gr1`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `czynnosci_serwisowe`
--

CREATE TABLE `czynnosci_serwisowe` (
  `id_czynnosci` int(10) UNSIGNED NOT NULL,
  `opis_czynnosci` varchar(200) NOT NULL,
  `cena` decimal(6,2) NOT NULL,
  `id_zgloszenia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `czynnosci_serwisowe`
--

INSERT INTO `czynnosci_serwisowe` (`id_czynnosci`, `opis_czynnosci`, `cena`, `id_zgloszenia`) VALUES
(1, 'Wymiana matrycy monitora', 159.99, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `id_klienta` int(10) UNSIGNED NOT NULL,
  `imie_k` varchar(15) NOT NULL,
  `nazwisko_k` varchar(35) NOT NULL,
  `firma_k` varchar(70) DEFAULT NULL,
  `ulica_k` varchar(30) NOT NULL,
  `nr_domu_k` varchar(5) NOT NULL,
  `nr_lokalu_k` int(10) UNSIGNED DEFAULT NULL,
  `kod_p_k` varchar(6) NOT NULL,
  `miejscowosc_k` varchar(30) NOT NULL,
  `telefon_k` varchar(15) NOT NULL,
  `email_k` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`id_klienta`, `imie_k`, `nazwisko_k`, `firma_k`, `ulica_k`, `nr_domu_k`, `nr_lokalu_k`, `kod_p_k`, `miejscowosc_k`, `telefon_k`, `email_k`) VALUES
(1, 'Jan', 'Kowalski', '', 'Matysowska', '62', 0, '35-122', 'Rzeszów', '674744921', 'jan.kowalski@gmail.com'),
(2, 'Michał', 'Nowak', '', 'Rzeszowska', '17', 0, '39-200', 'Dębica', '531765582', 'michalnowak123@outlook.com'),
(3, 'Michał', 'Kowal', '', 'Matuszczaka', '5', 0, '35-084', 'Rzeszów', '525464812', 'mkowal52@outlook.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konto`
--

CREATE TABLE `konto` (
  `login` varchar(25) NOT NULL,
  `haslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `data_rejestracji` date NOT NULL,
  `status` enum('A','N') NOT NULL DEFAULT 'N',
  `typ_konta` enum('A','K') NOT NULL,
  `id_klienta` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `konto`
--

INSERT INTO `konto` (`login`, `haslo`, `data_rejestracji`, `status`, `typ_konta`, `id_klienta`) VALUES
('abc', '$2y$10$a7/tE9I.PUecSELMdqqNd.Qm1pIj9YKby.HOeNXtYQeW/aL7kPDkG', '2024-01-28', 'A', 'A', NULL),
('mkowal52', '$2y$10$a7/tE9I.PUecSELMdqqNd.Qm1pIj9YKby.HOeNXtYQeW/aL7kPDkG', '2024-01-28', 'A', 'K', 3),
('test', '$2y$10$a7/tE9I.PUecSELMdqqNd.Qm1pIj9YKby.HOeNXtYQeW/aL7kPDkG', '2024-01-28', 'A', 'K', 1),
('test2', '$2y$10$a7/tE9I.PUecSELMdqqNd.Qm1pIj9YKby.HOeNXtYQeW/aL7kPDkG', '2024-01-28', 'A', 'K', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oddzial`
--

CREATE TABLE `oddzial` (
  `id_oddzialu` int(10) UNSIGNED NOT NULL,
  `nazwa_oddzialu` varchar(60) NOT NULL,
  `ulica_o` varchar(30) NOT NULL,
  `nr_domu_o` varchar(5) NOT NULL,
  `nr_lokalu_o` int(10) UNSIGNED DEFAULT NULL,
  `kod_o` varchar(6) NOT NULL,
  `miejscowosc_o` varchar(25) NOT NULL,
  `telefon_o` varchar(15) NOT NULL,
  `email_o` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oddzial`
--

INSERT INTO `oddzial` (`id_oddzialu`, `nazwa_oddzialu`, `ulica_o`, `nr_domu_o`, `nr_lokalu_o`, `kod_o`, `miejscowosc_o`, `telefon_o`, `email_o`) VALUES
(1, 'Centrala w Rzeszowie', 'Podwisłocze', '22', 2, '35-084', 'Rzeszów', '177428282', 'rzeszow@servis.pl'),
(5, 'Oddział w Dębicy', 'Rzeszowska', '15A', 2, '39-100', 'Dębica', '177428281', 'debica@servis.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownik`
--

CREATE TABLE `pracownik` (
  `id_pracownika` int(10) UNSIGNED NOT NULL,
  `imie_p` varchar(15) NOT NULL,
  `nazwisko_p` varchar(35) NOT NULL,
  `telefon_p` varchar(15) NOT NULL,
  `email_p` varchar(60) NOT NULL,
  `id_oddzialu` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pracownik`
--

INSERT INTO `pracownik` (`id_pracownika`, `imie_p`, `nazwisko_p`, `telefon_p`, `email_p`, `id_oddzialu`) VALUES
(1, 'Tomasz', 'Polak', '765612912', 't.polak@servis.pl', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sprzet`
--

CREATE TABLE `sprzet` (
  `id_urzadzenia` int(10) UNSIGNED NOT NULL,
  `nr_seryjny` varchar(60) NOT NULL,
  `producent` varchar(20) NOT NULL,
  `model` varchar(30) NOT NULL,
  `kategoria` enum('RTV','AGD','PC') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sprzet`
--

INSERT INTO `sprzet` (`id_urzadzenia`, `nr_seryjny`, `producent`, `model`, `kategoria`) VALUES
(1, 'HJW24951JASK05A34', 'Samsung', 'LV27HJMSA09CC', 'RTV'),
(2, 'JHFHS747374JKHAS', 'ASUS', 'ZenBook 1240X', 'PC');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status_naprawy`
--

CREATE TABLE `status_naprawy` (
  `id_statusu` int(10) UNSIGNED NOT NULL,
  `data_zmiany` datetime NOT NULL,
  `status` enum('Przyjęto w oddziale','W trakcie naprawy','Gotowy do odbioru') DEFAULT 'Przyjęto w oddziale',
  `id_zgloszenia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status_naprawy`
--

INSERT INTO `status_naprawy` (`id_statusu`, `data_zmiany`, `status`, `id_zgloszenia`) VALUES
(1, '2024-01-23 00:00:00', 'Przyjęto w oddziale', 2),
(2, '2024-01-23 00:00:00', 'W trakcie naprawy', 2),
(3, '2024-01-23 00:00:00', 'Gotowy do odbioru', 2),
(4, '2024-01-23 00:00:00', 'W trakcie naprawy', 2),
(5, '2024-01-23 00:00:00', 'Przyjęto w oddziale', 2),
(6, '2024-01-23 00:00:00', 'W trakcie naprawy', 2),
(7, '2024-01-23 00:00:00', 'Gotowy do odbioru', 2),
(8, '2024-01-23 00:00:00', 'W trakcie naprawy', 2),
(9, '2024-01-23 00:00:00', 'Przyjęto w oddziale', 2),
(10, '2024-01-23 00:00:00', 'W trakcie naprawy', 2),
(11, '2024-01-23 05:21:13', 'W trakcie naprawy', 2),
(12, '2024-01-26 00:35:48', 'Gotowy do odbioru', 2),
(13, '2024-01-26 00:37:27', 'Przyjęto w oddziale', 3),
(14, '2024-01-26 00:58:12', 'Przyjęto w oddziale', 4),
(15, '2024-01-26 00:58:14', 'W trakcie naprawy', 4),
(16, '2024-01-26 00:58:16', 'Przyjęto w oddziale', 4),
(17, '2024-01-26 03:14:44', 'Przyjęto w oddziale', 5),
(18, '2024-01-28 01:53:16', 'Przyjęto w oddziale', 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenie`
--

CREATE TABLE `zgloszenie` (
  `id_zgloszenia` int(10) UNSIGNED NOT NULL,
  `opis_zgloszenia` text NOT NULL,
  `data_zgloszenia` date NOT NULL,
  `data_odbioru` date DEFAULT NULL,
  `id_klienta` int(10) UNSIGNED NOT NULL,
  `id_pracownika` int(10) UNSIGNED NOT NULL,
  `id_urzadzenia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zgloszenie`
--

INSERT INTO `zgloszenie` (`id_zgloszenia`, `opis_zgloszenia`, `data_zgloszenia`, `data_odbioru`, `id_klienta`, `id_pracownika`, `id_urzadzenia`) VALUES
(2, 'Pojawiają się poziome paski na monitorze, problemy z uruchomieniem', '2024-01-23', '2024-01-26', 2, 1, 1),
(3, 'Awaria głośników', '2024-01-26', NULL, 2, 1, 1),
(4, 'Nie uruchamia się', '2024-01-26', NULL, 1, 1, 2),
(5, 'Zalanie klawiatury', '2024-01-26', NULL, 1, 1, 2),
(6, 'Nie działa', '2024-01-28', NULL, 2, 1, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `czynnosci_serwisowe`
--
ALTER TABLE `czynnosci_serwisowe`
  ADD PRIMARY KEY (`id_czynnosci`),
  ADD KEY `czynnosci_serwisowe_id_zgloszenia_fk` (`id_zgloszenia`);

--
-- Indeksy dla tabeli `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id_klienta`),
  ADD KEY `idx1` (`nazwisko_k`),
  ADD KEY `telefon_k` (`telefon_k`) USING BTREE,
  ADD KEY `email_k` (`email_k`) USING BTREE;

--
-- Indeksy dla tabeli `konto`
--
ALTER TABLE `konto`
  ADD PRIMARY KEY (`login`),
  ADD KEY `konto_id_klienta_fk` (`id_klienta`);

--
-- Indeksy dla tabeli `oddzial`
--
ALTER TABLE `oddzial`
  ADD PRIMARY KEY (`id_oddzialu`),
  ADD KEY `telefon_o` (`telefon_o`) USING BTREE,
  ADD KEY `email_o` (`email_o`) USING BTREE;

--
-- Indeksy dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  ADD PRIMARY KEY (`id_pracownika`),
  ADD KEY `pracownik_id_oddzialu_fk` (`id_oddzialu`),
  ADD KEY `idx2` (`nazwisko_p`),
  ADD KEY `email_p` (`email_p`) USING BTREE,
  ADD KEY `telefon_p` (`telefon_p`) USING BTREE;

--
-- Indeksy dla tabeli `sprzet`
--
ALTER TABLE `sprzet`
  ADD PRIMARY KEY (`id_urzadzenia`),
  ADD KEY `idx3` (`nr_seryjny`);

--
-- Indeksy dla tabeli `status_naprawy`
--
ALTER TABLE `status_naprawy`
  ADD PRIMARY KEY (`id_statusu`),
  ADD KEY `status_naprawy_id_zgloszenia_fk` (`id_zgloszenia`);

--
-- Indeksy dla tabeli `zgloszenie`
--
ALTER TABLE `zgloszenie`
  ADD PRIMARY KEY (`id_zgloszenia`),
  ADD KEY `zgloszenie_id_klienta_fk` (`id_klienta`),
  ADD KEY `zgloszenie_id_pracownika_fk` (`id_pracownika`),
  ADD KEY `zgloszenie_id_urzadzenia_fk` (`id_urzadzenia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `czynnosci_serwisowe`
--
ALTER TABLE `czynnosci_serwisowe`
  MODIFY `id_czynnosci` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `id_klienta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oddzial`
--
ALTER TABLE `oddzial`
  MODIFY `id_oddzialu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pracownik`
--
ALTER TABLE `pracownik`
  MODIFY `id_pracownika` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sprzet`
--
ALTER TABLE `sprzet`
  MODIFY `id_urzadzenia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_naprawy`
--
ALTER TABLE `status_naprawy`
  MODIFY `id_statusu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `zgloszenie`
--
ALTER TABLE `zgloszenie`
  MODIFY `id_zgloszenia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `czynnosci_serwisowe`
--
ALTER TABLE `czynnosci_serwisowe`
  ADD CONSTRAINT `czynnosci_serwisowe_id_zgloszenia_fk` FOREIGN KEY (`id_zgloszenia`) REFERENCES `zgloszenie` (`id_zgloszenia`);

--
-- Constraints for table `konto`
--
ALTER TABLE `konto`
  ADD CONSTRAINT `konto_id_klienta_fk` FOREIGN KEY (`id_klienta`) REFERENCES `klient` (`id_klienta`);

--
-- Constraints for table `pracownik`
--
ALTER TABLE `pracownik`
  ADD CONSTRAINT `pracownik_id_oddzialu_fk` FOREIGN KEY (`id_oddzialu`) REFERENCES `oddzial` (`id_oddzialu`);

--
-- Constraints for table `status_naprawy`
--
ALTER TABLE `status_naprawy`
  ADD CONSTRAINT `status_naprawy_id_zgloszenia_fk` FOREIGN KEY (`id_zgloszenia`) REFERENCES `zgloszenie` (`id_zgloszenia`);

--
-- Constraints for table `zgloszenie`
--
ALTER TABLE `zgloszenie`
  ADD CONSTRAINT `zgloszenie_id_klienta_fk` FOREIGN KEY (`id_klienta`) REFERENCES `klient` (`id_klienta`),
  ADD CONSTRAINT `zgloszenie_id_pracownika_fk` FOREIGN KEY (`id_pracownika`) REFERENCES `pracownik` (`id_pracownika`),
  ADD CONSTRAINT `zgloszenie_id_urzadzenia_fk` FOREIGN KEY (`id_urzadzenia`) REFERENCES `sprzet` (`id_urzadzenia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
