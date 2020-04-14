-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2020 at 07:41 PM
-- Server version: 5.6.46-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sean`
--
DROP DATABASE IF EXISTS `sean`;
CREATE DATABASE IF NOT EXISTS `sean` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sean`;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(100) NOT NULL,
  `album_title` varchar(100) NOT NULL,
  `album_artist` int(100) NOT NULL,
  `release_date` date NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `credits` varchar(10000) NOT NULL,
  `artist_email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(100) NOT NULL,
  `artist_name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `birth_country` varchar(100) NOT NULL,
  `location_city` varchar(100) NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `artist_bio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `purchase_cost` int(50) NOT NULL,
  `stream_cost` int(50) NOT NULL,
  `URL` varchar(100) NOT NULL,
  `album` int(100) NOT NULL,
  `artist` int(100) NOT NULL,
  `artist_email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `streams`
--

CREATE TABLE `streams` (
  `stream_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `song_id` int(255) NOT NULL,
  `purchase_cost` int(255) NOT NULL,
  `number_plays` int(255) NOT NULL,
  `unpaid_plays` int(100) NOT NULL,
  `last_payment_date` date DEFAULT NULL,
  `first_access_time` date NOT NULL,
  `last_access_time` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `credits` int(11) NOT NULL,
  `isPaused` int(11) NOT NULL DEFAULT '0',
  `lastPlayed` int(11) NOT NULL DEFAULT '0',
  `freeCreditBool` int(100) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `album_id_2` (`album_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`stream_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `streams`
--
ALTER TABLE `streams`
  MODIFY `stream_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
