-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2022 at 06:55 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(2) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNo` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Password`, `Name`, `Email`, `PhoneNo`) VALUES
(1, 'admin', '$2y$10$7eVnY8Vwyxoa3jkCuDvQzOednLSqvwe1KzJ0nWvFWWeepcLfI5GRi', 'Kelly', 'asaskomputer@gmail.com', '0123456714'),
(112, 'admin2145', '$2y$10$7eVnY8Vwyxoa3jkCuDvQzOednLSqvwe1KzJ0nWvFWWeepcLfI5GRi', 'Kevin', 'kevin20@gmail.com', '0114523698'),
(113, 'testing123', '$2y$10$hmC8CNrSn3k/.ahC1GAEPePQQpEpbfN811EDFlkngYJxdKfhdU.K6', 'testing123', '123@gmail.com', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `AnnouncementID` int(11) NOT NULL,
  `Announcement` text NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`AnnouncementID`, `Announcement`, `DateTime`, `Admin`) VALUES
(1, 'Hi. All teachers and students, please be informed that\r\nthe regular maintenance is executed on every Friday\r\nand Sunday from 7:30 pm ~ 8am (next day).\r\nKindly avoid to access this portal during weekly\r\nmaintenance period as it may cause the operation\r\nunder heavy traffic circumstance. \r\nThanks for your attention! ', '2021-09-07 15:37:53', 2),
(2, 'Hi. All teachers and students, please be informed that the regular maintenance is executed on every Friday and Sunday from 7:30 pm ~ 8am (next day). Kindly avoid to access this portal during weekly maintenance period as it may cause the operation under heavy traffic circumstance. Thanks for your attention! ', '2021-12-06 15:32:16', 1),
(3, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. Thanks for your attention! ', '2021-12-09 09:53:56', 1),
(4, 'Hi. All teachers and students, please be informed that the regular maintenance is executed on every Friday and Sunday from 7:30 pm ~ 8am (next day). Kindly avoid to access this portal during weekly maintenance period as it may cause the operation under heavy traffic circumstance. Thanks for your attention! ', '2021-12-09 09:54:00', 1),
(5, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. Thanks for your attention! ', '2021-12-09 09:54:02', 1),
(6, 'Hi. All teachers and students, please be informed that the regular maintenance is executed on every Friday and Sunday from 7:30 pm ~ 8am (next day). Kindly avoid to access this portal during weekly maintenance period as it may cause the operation under heavy traffic circumstance. Thanks for your attention! ', '2021-12-09 09:54:03', 1),
(7, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. Thanks for your attention! ', '2021-12-09 09:54:05', 1),
(8, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. Thanks for your attention! ', '2021-12-09 09:57:13', 1),
(9, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. ', '2021-12-09 09:57:21', 1),
(10, 'Hi. All teachers and students, please be informed that the regular maintenance is executed every Friday and Sunday from 7:30 pm ~ 8 am (next day). Kindly avoid accessing this portal during the weekly maintenance period as it may cause the operation under heavy traffic circumstances. Thanks for your attention!', '2021-12-09 09:57:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `ChapterID` int(11) NOT NULL,
  `Chapter` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Tingkatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`ChapterID`, `Chapter`, `Name`, `Tingkatan`) VALUES
(1, 0, 'Textbook Tingkatan 1', 1),
(2, 0, 'Textbook Tingkatan 2', 2),
(3, 0, 'Textbook Tingkatan 3', 3),
(4, 0, 'Textbook Tingkatan 4', 4),
(5, 0, 'Textbook Tingkatan 5', 5),
(6, 1, 'Konsep Asas Pemikiran Komputasional', 1),
(7, 2, 'Perwakilan Data', 1),
(8, 3, 'Algoritma', 1),
(9, 4, 'Kod Arahan', 1),
(10, 1, 'Perwakilan Data', 2),
(11, 2, 'Algoritma', 2),
(12, 3, 'Kod Arahan', 2),
(13, 1, 'Konsep Asas Pemikiran Komputasional', 3),
(14, 2, 'Perwakilan Data', 3),
(15, 3, 'Algoritma', 3),
(16, 4, 'Kod Arahan', 3),
(17, 1, 'Pengaturcaraan', 4),
(18, 2, 'Pangkalan Data', 4),
(19, 3, 'Interaksi Manusia Dengan Komputer', 4),
(20, 1, 'Pengkomputeran', 5),
(21, 2, 'Pangkalan Data Lanjutan', 5),
(22, 3, 'Pengaturcaraan Berasaskan Web', 5);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(20) NOT NULL,
  `TeacherID` int(11) DEFAULT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Tingkatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ClassID`, `ClassName`, `TeacherID`, `DateTime`, `Tingkatan`) VALUES
(1, 'KS1', 152, '2021-01-01 00:00:00', 1),
(2, 'KS2', 153, '2021-01-01 00:00:00', 1),
(3, 'KS1', 154, '2021-01-01 00:00:00', 2),
(4, 'KS2', 152, '2021-01-01 00:00:00', 2),
(5, 'KS1', 153, '2021-01-01 00:00:00', 3),
(6, 'KS2', 154, '2021-01-01 00:00:00', 3),
(7, 'KS1', 152, '2021-01-01 00:00:00', 4),
(8, 'KS2', 153, '2021-01-01 00:00:00', 4),
(9, 'KS1', 154, '2021-01-01 00:00:00', 5),
(10, 'KS2', 152, '2021-01-01 00:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `PostID` int(11) NOT NULL,
  `Uploader` int(11) NOT NULL,
  `DateTime` datetime DEFAULT current_timestamp(),
  `Showed` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `Comment`, `PostID`, `Uploader`, `DateTime`, `Showed`) VALUES
(1, 'Well, same as me. I also need this method. But I\'m too shy to ask. If I fail again, my teacher will kill me.', 10, 10260, '2021-08-08 17:49:02', 1),
(2, 'You know what? I\'m still failed either I study or not. Haha', 10, 10261, '2021-08-08 19:02:14', 1),
(3, 'Chandler, can you just don\'t bother us. You don\'t know my teacher is fierce.', 10, 10260, '2021-08-08 21:58:37', 1),
(4, 'Same as me, dude.', 10, 10260, '2021-08-10 14:55:10', 0),
(5, 'Same as me, dude.', 10, 10260, '2021-09-07 14:29:19', 0),
(6, 'Same as me, dude.', 10, 10260, '2021-09-07 14:47:19', 0),
(7, 'Same as me, dude. ', 10, 152, '2021-09-07 15:08:31', 0),
(8, 'Well, same as me. I also need this method. But I\'m too shy to ask. If I fail again, my teacher will kill me.', 10, 10260, '2021-08-08 17:49:02', 1),
(9, 'You know what? I\'m still failed either I study or not. Haha', 10, 10261, '2021-08-08 19:02:14', 1),
(10, 'Chandler, can you just don\'t bother us. You don\'t know my teacher is fierce.', 10, 10260, '2021-08-08 21:58:37', 1),
(11, 'Same as me, dude.', 10, 10260, '2021-08-10 14:55:10', 0),
(12, 'Same as me, dude.', 10, 10260, '2021-09-07 14:29:19', 0),
(13, 'Same as me, dude.', 10, 10260, '2021-09-07 14:47:19', 1),
(14, 'Same as me, dude. ', 10, 152, '2021-09-07 15:08:31', 1),
(15, '123', 10, 10260, '2021-11-29 19:39:08', 1),
(21, '456', 14, 152, '2021-11-29 19:50:29', 1),
(22, '123', 11, 152, '2021-11-29 19:51:03', 1),
(23, 'qwefjghl', 11, 10276, '2022-01-04 15:30:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `HomeworkID` int(11) NOT NULL,
  `HomeworkName` varchar(100) NOT NULL,
  `Instruction` text NOT NULL,
  `Attachment` text NOT NULL,
  `Class` int(11) NOT NULL,
  `DateTimes` datetime NOT NULL DEFAULT current_timestamp(),
  `DueDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`HomeworkID`, `HomeworkName`, `Instruction`, `Attachment`, `Class`, `DateTimes`, `DueDate`) VALUES
(1, 'Exercise 2.1', '1. Follow the formula in the slide during class.\r\n2. Late submission will result in mark deduction.\r\n3. Name the submission file with your student ID.\r\n4. Save in pdf format.', '../assets/homeworks/submission/HomeworkLink1.pdf', 1, '2021-07-26 15:13:48', '2021-07-28 16:00:00'),
(2, 'Exercise 2.2', '1. Follow the formula in the slide during class.\r\n2. Late submission will result in mark deduction.\r\n3. Name the submission file with your student ID.\r\n4. Save in pdf format.', 'HomeworkLink2', 1, '2021-07-29 15:23:48', '2021-08-01 23:00:00'),
(3, 'Exercise 2.3', '1. Follow the formula in the slide during class.\r\n2. Late submission will result in mark deduction.\r\n3. Name the submission file with your student ID.\r\n4. Save in pdf format.', 'HomeworkLink3', 1, '2021-08-08 15:23:48', '2021-08-10 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `homeworkdone`
--

CREATE TABLE `homeworkdone` (
  `HomeworkDoneID` int(11) NOT NULL,
  `Homework` int(11) NOT NULL,
  `Answer` text NOT NULL,
  `StudentID` int(11) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homeworkdone`
--

INSERT INTO `homeworkdone` (`HomeworkDoneID`, `Homework`, `Answer`, `StudentID`, `DateTime`) VALUES
(1, 1, 'AnswerLink1', 10260, '2021-08-10 14:55:10'),
(5, 1, 'AnswerLink', 10261, '2021-08-10 14:55:10'),
(6, 2, 'AnswerLink', 10260, '0000-00-00 00:00:00'),
(11, 3, '../assets/homeworks/1/upload202111281638087496/1.jpeg', 10260, '2021-11-28 16:18:16'),
(12, 1, '../assets/homeworks/1/upload202111281638088981/3.jpeg', 10276, '2021-11-28 16:43:01'),
(13, 2, '../assets/homeworks/1/upload202111281638089910/5.jpeg', 10276, '2021-11-28 16:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `homeworkreturn`
--

CREATE TABLE `homeworkreturn` (
  `HomeworkReturnID` int(11) NOT NULL,
  `HomeworkDoneID` int(11) NOT NULL,
  `HomeworkReturn` text NOT NULL,
  `Remark` text NOT NULL,
  `DateTime2` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homeworkreturn`
--

INSERT INTO `homeworkreturn` (`HomeworkReturnID`, `HomeworkDoneID`, `HomeworkReturn`, `Remark`, `DateTime2`) VALUES
(2, 12, 'testlink', 'good job', '2022-01-05 16:22:30'),
(9, 1, '', '', '2022-01-05 19:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `NoteID` int(11) NOT NULL,
  `Topic` varchar(100) NOT NULL,
  `Link` varchar(100) NOT NULL,
  `ChapterID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`NoteID`, `Topic`, `Link`, `ChapterID`, `TeacherID`, `DateTime`) VALUES
(1, '', 'Textbook 1 Link', 1, 1, '2021-01-01 00:00:00'),
(2, '', 'Textbook 2 Link', 2, 1, '2021-01-01 00:00:00'),
(3, '', 'Textbook 3 Link', 3, 1, '2021-01-01 00:00:00'),
(4, '', 'Textbook 4 Link', 4, 1, '2021-01-01 00:00:00'),
(5, '', 'Textbook 5 Link', 5, 1, '2021-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(11) NOT NULL,
  `Post` text NOT NULL,
  `Content` text NOT NULL,
  `Student` int(11) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Showed` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `Post`, `Content`, `Student`, `DateTime`, `Showed`) VALUES
(1, 'Help! TM network speed suddenly slows down, how can I complain?', 'As the topic, anyone knows about ...', 10269, '2021-07-15 10:59:15', 1),
(2, 'The difference between IPV4 and IPV6.', 'As the topic, anyone knows about ...', 10268, '2021-07-18 11:02:28', 1),
(3, 'Is it the same as putting the mobile phone sim card in a modem bought outside?', 'As the topic, anyone knows about ...', 10267, '2021-07-20 21:42:09', 1),
(4, 'Help~ How to change the password for UNIFI?', 'As the topic, anyone knows about ...', 10266, '2021-07-22 16:10:18', 1),
(5, 'Questions about connecting to the network.', 'As the topic, anyone knows about ...', 10265, '2021-07-25 22:21:46', 1),
(6, 'Does the internet slow down every time it rains?', 'As the topic, anyone knows about ...', 10264, '2021-07-28 11:02:07', 1),
(7, 'Which is better, Unifi or Maxis?', 'As the topic, anyone knows about ...', 10260, '2021-07-31 10:14:35', 1),
(8, 'Seek cloud service', 'As the topic, anyone knows about ...', 10263, '2021-08-01 16:55:38', 1),
(9, 'Malaysia\'s 5G technology?', 'As the topic, anyone knows about ...', 10262, '2021-08-04 10:29:43', 1),
(10, 'What the different between if and while?', 'As the topic, anyone got the easiest way to differentiate these two? My test is coming soon, I \r\nreally need this. Thank you so much for your help.', 10259, '2021-08-08 14:32:15', 1),
(11, ' Malaysia develops its own 5G system?', 'As the topic, anyone thinks it is possible? I don’t think so.', 10260, '2021-08-11 14:32:15', 1),
(12, ' Malaysia develops its own 5G system?', 'As the topic, anyone thinks it is possible? I don’t think so.', 10260, '2021-09-07 14:30:35', 0),
(13, ' Malaysia develops its own 5G system?', 'As the topic, anyone thinks it is possible? I don’t think so.', 10260, '2021-09-07 14:47:51', 0),
(14, '123', '123', 10260, '2021-11-29 15:41:16', 0),
(29, 'veronica', 'i love you', 10276, '2022-01-04 15:31:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL,
  `user` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`, `user`) VALUES
(10, 'byronwong1008@gmail.com', '18d008195e27083b', '$2y$10$0rHtdjLO1iyzksRRoBupVeNrA2E4TyduHHVjnR0gB0GkeqdavncoS', '1800', 1),
(16, 'hellkaiser1009@gmail.com', 'e382ee43f286c4a2', '$2y$10$Ck8BsdfR.X2bs1EnzifJ6O5oqr9EfNWXrKElQ6nsOcG0TeXXfLMiC', '1800', 1),
(19, 'qwertyuiop@gmail.com', 'cf67c5b654154215', '$2y$10$2zHicuw0tRgstdkoPuHiAugR6ax3zMVDlQxwjCrX5AeQj1jmZWz/m', '1800', 1),
(20, 'hellkaiser1008@gmail.com', '28b989d9e428ab9d', '$2y$10$7y9BAZ87VNA/9LStFYEVAuPOrzKiz2Q42QiawkZn66xGltg5DNdwq', '1800', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNo` varchar(12) NOT NULL,
  `ID_Card` varchar(100) NOT NULL,
  `Class` varchar(12) DEFAULT NULL,
  `Activated` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `Username`, `Password`, `Name`, `Email`, `PhoneNo`, `ID_Card`, `Class`, `Activated`) VALUES
(10259, 'S10259', 'password1', 'Janice', 'Janice@gmail.com', '0158654935', '', '', 1),
(10260, 'S10260', '$2y$10$7eVnY8Vwyxoa3jkCuDvQzOednLSqvwe1KzJ0nWvFWWeepcLfI5GRi', 'Rachel', 'rachel12@gmail.com', '0198453210', '', '1', 1),
(10261, 'S10261', 'password3', 'Chandler', 'chandler58@gmail.com', '0135489627', '', '', 1),
(10262, 'S10262', 'password4', 'Monica', 'monica@gmail.com', '0149563665', '', '2', 1),
(10263, 'S10263', 'password5', 'Bruce', 'bruce27@gmail.com', '01152687469', '', '3', 1),
(10264, 'S10264', 'password6', 'Mohd Ali', 'ali.9542@gmail.com', '0174251569', '', '3', 1),
(10265, 'S10265', 'password7', 'Joey', 'joey576@gmail.com', '01133566956', '', '4', 1),
(10266, 'S10266', 'password8', 'Joyce', 'joyce576@gmail.com', '0148532100', '', '4', 1),
(10267, 'S10267', 'password9', 'Pavitra', 'pavitra15@gmail.com', '0141255210', '', '5', 1),
(10268, 'S10628', 'password10', 'Hans', 'hans16@gmail.com', '0194112578', '', '5', 1),
(10269, 'S10629', 'password11', 'Vivien', 'vivien76@gmail.com', '01141000256', '', '6', 1),
(10276, 'S10280', '$2y$10$7eVnY8Vwyxoa3jkCuDvQzOednLSqvwe1KzJ0nWvFWWeepcLfI5GRi', 'Elsa Buffay', 'elsa.154@gmail.com', '0145213965', '', '1', 1),
(10293, 'S1100001', '$2y$10$w7sF1gIHVprYVwS08wyCJuTG/0OewE.RdRceDWY187KhW.R08G7XG', 'testing123', 'hellkaiser1008@gmail.com', '+60111060678', 'id_card/upload202112061638778190.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcomment`
--

CREATE TABLE `tcomment` (
  `TCommentID` int(11) NOT NULL,
  `TComment` text NOT NULL,
  `TPostID` int(11) NOT NULL,
  `Teacher` int(11) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Showed` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcomment`
--

INSERT INTO `tcomment` (`TCommentID`, `TComment`, `TPostID`, `Teacher`, `DateTime`, `Showed`) VALUES
(2, 'You know what? I\'m still failed either I study or not. Haha', 1, 153, '2021-08-08 19:02:14', 1),
(4, 'Same as me, dude.', 1, 152, '2021-09-07 14:52:35', 1),
(5, 'Same as me, dude. ', 10, 152, '2021-09-07 15:01:07', 0),
(6, '123', 1, 152, '2021-12-01 09:43:09', 0),
(7, '123', 3, 152, '2021-12-01 09:45:53', 1),
(8, 'testiing', 1, 152, '2021-12-02 10:22:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherID` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNo` varchar(12) NOT NULL,
  `ID_Card` varchar(100) NOT NULL,
  `Activated` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherID`, `Username`, `Password`, `Name`, `Email`, `PhoneNo`, `ID_Card`, `Activated`) VALUES
(1, '', '', 'Admin', '', '', '', 1),
(152, 'T152', '$2y$10$7eVnY8Vwyxoa3jkCuDvQzOednLSqvwe1KzJ0nWvFWWeepcLfI5GRi', 'Amma', 'hellkaiser1009@gmail.com', '0162300541', '', 1),
(153, 'T153', 'password2', 'Ben', 'ben122@gmail.com', '0184561002', '', 1),
(154, 'T154', 'password3', 'Ross', 'ross19@gmail.com', '0142001322', '', 1),
(155, 'T160', 'password', 'Tifanny', 'tifanny.175@gmail.com', '0114286250', '', 1),
(163, 'T181', '$2y$10$i6h1NDYELvxU/ysu2qPHrOMgV8yjhmzKYwHG5pdfGVbiyKAPWndv.', 'testing1234567890', '123456789@gmail.com', '0123456789', 'id_card/upload202112061638779839.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tingkatan`
--

CREATE TABLE `tingkatan` (
  `TingkatanID` int(11) NOT NULL,
  `Tingkatan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tingkatan`
--

INSERT INTO `tingkatan` (`TingkatanID`, `Tingkatan`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tpost`
--

CREATE TABLE `tpost` (
  `TPostID` int(11) NOT NULL,
  `TPost` text NOT NULL,
  `Content` text NOT NULL,
  `Teacher` int(11) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Showed` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tpost`
--

INSERT INTO `tpost` (`TPostID`, `TPost`, `Content`, `Teacher`, `DateTime`, `Showed`) VALUES
(1, 'Malaysia\'s 5G technology?', 'As the topic, anyone got the easiest way to differ...', 152, '2021-09-07 14:55:43', 1),
(2, 'Malaysia\'s 5G technology?', 'As the topic, anyone got the easiest way to differ...', 152, '2021-09-07 14:56:02', 0),
(3, '123', '123', 152, '2021-12-01 09:45:42', 0),
(4, 'qwertyuiop', '123456789', 152, '2021-12-01 09:46:10', 1),
(5, 'New topic', 'testing', 153, '2021-12-02 10:23:02', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`AnnouncementID`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`ChapterID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ClassID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`HomeworkID`);

--
-- Indexes for table `homeworkdone`
--
ALTER TABLE `homeworkdone`
  ADD PRIMARY KEY (`HomeworkDoneID`);

--
-- Indexes for table `homeworkreturn`
--
ALTER TABLE `homeworkreturn`
  ADD PRIMARY KEY (`HomeworkReturnID`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`NoteID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`);

--
-- Indexes for table `tcomment`
--
ALTER TABLE `tcomment`
  ADD PRIMARY KEY (`TCommentID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherID`);

--
-- Indexes for table `tingkatan`
--
ALTER TABLE `tingkatan`
  ADD PRIMARY KEY (`TingkatanID`);

--
-- Indexes for table `tpost`
--
ALTER TABLE `tpost`
  ADD PRIMARY KEY (`TPostID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `ChapterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2202;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `HomeworkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `homeworkdone`
--
ALTER TABLE `homeworkdone`
  MODIFY `HomeworkDoneID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `homeworkreturn`
--
ALTER TABLE `homeworkreturn`
  MODIFY `HomeworkReturnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10294;

--
-- AUTO_INCREMENT for table `tcomment`
--
ALTER TABLE `tcomment`
  MODIFY `TCommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `tingkatan`
--
ALTER TABLE `tingkatan`
  MODIFY `TingkatanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tpost`
--
ALTER TABLE `tpost`
  MODIFY `TPostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
