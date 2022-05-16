-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 16. kvě 2022, 12:55
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `pass`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `db`
--

CREATE TABLE `db` (
  `id` int(11) NOT NULL,
  `domains_id` int(11) DEFAULT NULL,
  `db` varchar(255) NOT NULL,
  `server` varchar(255) NOT NULL,
  `admin_adress` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `db_login`
--

CREATE TABLE `db_login` (
  `id` int(11) NOT NULL,
  `db_id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `login_for` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `db_login_users`
--

CREATE TABLE `db_login_users` (
  `id` int(11) NOT NULL,
  `id_send` int(11) NOT NULL,
  `to_send` varchar(100) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `users_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `domains`
--

CREATE TABLE `domains` (
  `id` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `ftp` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `people_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `log`
--

INSERT INTO `log` (`id`, `text`, `users_id`, `people_id`, `date_create`) VALUES
(30, 'User test@gmail.com activated', 26, NULL, '2022-03-01 04:49:54'),
(31, 'User test@gmail.com deactivated', 26, NULL, '2022-03-01 04:49:56');

-- --------------------------------------------------------

--
-- Struktura tabulky `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pozition` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `people`
--

INSERT INTO `people` (`id`, `name`, `pozition`, `phone`, `email`, `password`, `active`, `date_create`) VALUES
(26, 'Petr Pavlica', '1', '778777888', 'test@gmail.com', '$2y$10$PBuaTjdvNloykBs3zZDpWufJyHQjHm6MqiT.Ydsg3FczlIoS60KB6', 1, '2022-02-11 12:21:56'),
(28, 'test', '1', '778777888', 'testsf@gmail.com', '$2y$10$6wWr2oeFQHjJRRmYyRIQjO4IJ4RgPuOpZ2rxnbS24UyEoKAuN67JO', 1, '2022-02-28 14:01:21'),
(29, 'Petr Pavlica', '1', '778777888', 'petrpavlicaslovacko@gmail.com', '$2y$10$rgmAespKc9DF1k83IZl/b.qKLJfW1CgMRyoAetzrw3R7MwYDxZPlC', 1, '2022-03-01 04:56:10'),
(30, 'Petr Pavlica', '1', '778777888', 'petrpavlicaslovacko@gmail.com', '$2y$10$OlGtbHJ2zaSsvGF0Wismn.X5kA6cJAQDueOeOdHPX8lkyeQqCE.LC', 1, '2022-03-01 04:58:05'),
(31, 'xhoraka@gmail.com', '1', '774967327', 'xhoraka@gmail.com', '$2y$10$uPG/JJp1n0vad9A4iOAPjebznnLePf0v/GhdPgCpLAc6TjCUmFgzO', 1, '2022-05-16 12:15:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `people_db_login`
--

CREATE TABLE `people_db_login` (
  `id` int(11) NOT NULL,
  `db_login_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `del` tinyint(4) NOT NULL DEFAULT 0,
  `date_del` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `people_domains_login`
--

CREATE TABLE `people_domains_login` (
  `id` int(11) NOT NULL,
  `domains_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `del` tinyint(4) NOT NULL DEFAULT 0,
  `date_del` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `people_inf`
--

CREATE TABLE `people_inf` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `psc` varchar(255) NOT NULL,
  `bank_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `people_inf`
--

INSERT INTO `people_inf` (`id`, `people_id`, `city`, `street`, `cp`, `psc`, `bank_number`) VALUES
(11, 28, '', '', '', '', 0),
(12, 30, 'Staré Město (okr. Uherské Hradiště)', 'Amálie Škráškové', '68603', '68603', 123),
(13, 26, '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `sended_email`
--

CREATE TABLE `sended_email` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `what_sended` varchar(100) NOT NULL,
  `pass_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `date_create`) VALUES
(1, 'hash', 'ch240222S', '2022-02-24 00:38:03');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pozition` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(220) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `active` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `pozition`, `phone`, `email`, `password`, `role`, `ip`, `active`, `date_create`) VALUES
(26, 'Petr Pavlica', 1, '778777888', 'test@gmail.com', '$2y$10$PBuaTjdvNloykBs3zZDpWufJyHQjHm6MqiT.Ydsg3FczlIoS60KB6', 0, '', 0, '2022-02-11 11:21:56'),
(28, 'test', 1, '778777888', 'testsf@gmail.com', '$2y$10$6wWr2oeFQHjJRRmYyRIQjO4IJ4RgPuOpZ2rxnbS24UyEoKAuN67JO', 0, '', 0, '2022-02-28 13:01:21'),
(29, 'Petr Pavlica', 1, '778777888', 'petrpavlicaslovacko@gmail.com', '$2y$10$rgmAespKc9DF1k83IZl/b.qKLJfW1CgMRyoAetzrw3R7MwYDxZPlC', 0, '', 0, '2022-03-01 03:56:10'),
(30, 'Petr Pavlica', 1, '778777888', 'petrpavlicaslovacko@gmail.com', '$2y$10$OlGtbHJ2zaSsvGF0Wismn.X5kA6cJAQDueOeOdHPX8lkyeQqCE.LC', 0, '', 0, '2022-03-01 03:58:05'),
(31, 'xhoraka@gmail.com', 1, '774967327', 'xhoraka@gmail.com', '$2y$10$uPG/JJp1n0vad9A4iOAPjebznnLePf0v/GhdPgCpLAc6TjCUmFgzO', 0, '', 0, '2022-05-16 10:15:00');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `db`
--
ALTER TABLE `db`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `db_login`
--
ALTER TABLE `db_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `db_login_users`
--
ALTER TABLE `db_login_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `people_db_login`
--
ALTER TABLE `people_db_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `people_domains_login`
--
ALTER TABLE `people_domains_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `people_inf`
--
ALTER TABLE `people_inf`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `sended_email`
--
ALTER TABLE `sended_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `db`
--
ALTER TABLE `db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `db_login`
--
ALTER TABLE `db_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `db_login_users`
--
ALTER TABLE `db_login_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pro tabulku `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pro tabulku `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pro tabulku `people_db_login`
--
ALTER TABLE `people_db_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `people_domains_login`
--
ALTER TABLE `people_domains_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pro tabulku `people_inf`
--
ALTER TABLE `people_inf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pro tabulku `sended_email`
--
ALTER TABLE `sended_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
