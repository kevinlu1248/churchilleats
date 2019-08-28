-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 20, 2019 at 03:52 AM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `myattendance.ca`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` mediumint(9) NOT NULL,
  `fingerprint` tinytext COLLATE latin1_general_ci NOT NULL COMMENT 'Input and output as hex',
  `email` tinytext COLLATE latin1_general_ci NOT NULL,
  `password` tinytext COLLATE latin1_general_ci NOT NULL,
  `firstName` tinytext COLLATE latin1_general_ci NOT NULL,
  `lastName` tinytext COLLATE latin1_general_ci NOT NULL,
  `isTeacher` tinyint(1) DEFAULT '0',
  `studentID` int(11) DEFAULT NULL,
  `rememberMe` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `fingerprint`, `email`, `password`, `firstName`, `lastName`, `isTeacher`, `studentID`, `rememberMe`) VALUES
(1, '244800fa871fa91ccab58c70c08c415e', 'kevinlu12489@gmail.com ', '$2y$10$xD/CeIgixOuLUwP96k9qzOofX2NlqSH/ijfzT9kYkxunRVSq9mrv.', 'Kevin', 'Lu', 1, 836313, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
