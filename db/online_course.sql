-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 01:04 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_course`
--

-- --------------------------------------------------------

--
-- Table structure for table `learning_courses`
--

CREATE TABLE `learning_courses` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `course_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_courses`
--

INSERT INTO `learning_courses` (`ID`, `course_title`, `cdate`, `udate`) VALUES
(5, 'Dutch Listing Exercise', '2020-04-20 15:17:27', '2020-04-20 15:17:27'),
(4, '250 Dutch Proverbs', '2020-04-20 15:15:33', '2020-04-20 15:15:33'),
(3, '100 Most Common Words in Dutch', '2020-04-20 15:15:33', '2020-04-20 15:15:33'),
(6, 'Dutch Pronunciation', '2020-04-20 15:17:27', '2020-04-20 15:17:27'),
(7, 'Dutch Verb Conjugation Trainer', '2020-04-20 15:17:27', '2020-04-20 15:17:27'),
(8, 'False Friends', '2020-04-20 15:17:27', '2020-04-20 15:17:27'),
(9, 'Heb je zin?', '2020-04-20 15:17:27', '2020-04-20 15:17:27'),
(10, 'Heb je zin? - 2', '2020-04-20 15:17:27', '2020-04-20 15:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `learning_lessons`
--

CREATE TABLE `learning_lessons` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `course_ID` bigint(20) UNSIGNED NOT NULL,
  `lesson_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lesson_desc` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_lessons`
--

INSERT INTO `learning_lessons` (`ID`, `course_ID`, `lesson_title`, `video_url`, `lesson_desc`, `cdate`, `udate`) VALUES
(1, 3, 'Lesson - 1 Introduce Yourself', 'https://www.youtube.com/embed/ZCA2DyqYvF0', 'in lesson 1 you learn: How to introduce yourself in dutch', '2020-04-20 17:22:22', '2020-04-20 17:22:22'),
(2, 3, 'Lesson - 1 Personal Pronouns + to Thank', 'https://www.youtube.com/embed/6zxk5xeeVY0', 'in lesson 2 you learn: pronouns + to thank', '2020-04-20 17:22:22', '2020-04-20 17:22:22'),
(3, 3, 'Lesson - 1 to be (zijn) + professions', NULL, 'in lesson 3 you learn: pronouns + to thank + to be (zijn) + professions ', '2020-04-20 17:22:22', '2020-04-20 17:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `learning_questions`
--

CREATE TABLE `learning_questions` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `quiz_ID` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt1` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt3` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt4` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ans` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_quiz`
--

CREATE TABLE `learning_quiz` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `lesson_ID` bigint(20) UNSIGNED NOT NULL,
  `quiz_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_quiz`
--

INSERT INTO `learning_quiz` (`ID`, `lesson_ID`, `quiz_title`) VALUES
(1, 1, 'Vocabulary Exercise -1A - Visual'),
(2, 1, 'Vocabulary Exercise -1B - CONTEXT'),
(3, 1, 'Dutch Vocabulary Test 01 - Introducing Yourself');

-- --------------------------------------------------------

--
-- Table structure for table `learning_vocab`
--

CREATE TABLE `learning_vocab` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `lesson_ID` bigint(20) UNSIGNED NOT NULL,
  `eng_word` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ned_word` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_vocab`
--

INSERT INTO `learning_vocab` (`ID`, `lesson_ID`, `eng_word`, `ned_word`) VALUES
(1, 1, 'I', 'ik'),
(2, 1, 'My name is', 'ik heet'),
(3, 1, 'I am', 'ik ben'),
(4, 1, 'a', 'een'),
(5, 1, 'the', 'de'),
(6, 1, 'the man', 'de man');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learning_courses`
--
ALTER TABLE `learning_courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `learning_lessons`
--
ALTER TABLE `learning_lessons`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `course_ID` (`course_ID`);

--
-- Indexes for table `learning_questions`
--
ALTER TABLE `learning_questions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `quiz_ID` (`quiz_ID`);

--
-- Indexes for table `learning_quiz`
--
ALTER TABLE `learning_quiz`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `lesson_ID` (`lesson_ID`);

--
-- Indexes for table `learning_vocab`
--
ALTER TABLE `learning_vocab`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `lesson_ID` (`lesson_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learning_courses`
--
ALTER TABLE `learning_courses`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `learning_lessons`
--
ALTER TABLE `learning_lessons`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `learning_questions`
--
ALTER TABLE `learning_questions`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_quiz`
--
ALTER TABLE `learning_quiz`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `learning_vocab`
--
ALTER TABLE `learning_vocab`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
