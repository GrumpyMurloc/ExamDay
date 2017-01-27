-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2016 at 09:09 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sysexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `code_examen`
--

CREATE TABLE `code_examen` (
  `code` varchar(32) NOT NULL,
  `Examenid` int(32) NOT NULL,
  `fresh` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `id` int(10) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examen`
--

CREATE TABLE `examen` (
  `id` int(32) NOT NULL,
  `Enseignantid` int(10) NOT NULL,
  `ponderation` float NOT NULL DEFAULT '0',
  `titre` varchar(128) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examen_eleve`
--

CREATE TABLE `examen_eleve` (
  `Examenid` int(10) NOT NULL,
  `Eleveid` int(10) NOT NULL,
  `commentaire` varchar(512) DEFAULT NULL,
  `complet` tinyint(1) NOT NULL DEFAULT '0',
  `corrected` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examen_question`
--

CREATE TABLE `examen_question` (
  `Examenid` int(10) NOT NULL,
  `Questionid` int(10) NOT NULL,
  `poids` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_exam_eleve`
--

CREATE TABLE `exam_question_exam_eleve` (
  `Examen_QuestionExamenid` int(10) NOT NULL,
  `Examen_QuestionQuestionid` int(10) NOT NULL,
  `Examen_EleveExamenid` int(10) NOT NULL,
  `Examen_EleveEleveid` int(10) NOT NULL,
  `note` int(10) DEFAULT NULL,
  `commentaire` varchar(128) DEFAULT NULL,
  `reponse` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(10) NOT NULL,
  `enseignantid` int(10) NOT NULL,
  `enonce` varchar(200) NOT NULL,
  `choix` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `titre` varchar(40) NOT NULL,
  `reponse` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `code_examen`
--
ALTER TABLE `code_examen`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_index` (`username`);

--
-- Indexes for table `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Enseignantid_index` (`Enseignantid`);

--
-- Indexes for table `examen_eleve`
--
ALTER TABLE `examen_eleve`
  ADD PRIMARY KEY (`Examenid`,`Eleveid`);

--
-- Indexes for table `examen_question`
--
ALTER TABLE `examen_question`
  ADD PRIMARY KEY (`Examenid`,`Questionid`);

--
-- Indexes for table `exam_question_exam_eleve`
--
ALTER TABLE `exam_question_exam_eleve`
  ADD PRIMARY KEY (`Examen_QuestionExamenid`,`Examen_QuestionQuestionid`,`Examen_EleveExamenid`,`Examen_EleveEleveid`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_index` (`type`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compte`
--
ALTER TABLE `compte`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
