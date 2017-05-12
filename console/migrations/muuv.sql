-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2017 at 10:12 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `muuv`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `title`, `desc`, `event_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 'hello sadfd', 'there ?', 11, 5, 0, 1486052810, 1486052810);

-- --------------------------------------------------------

--
-- Table structure for table `event_likes`
--

CREATE TABLE `event_likes` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_likes`
--

INSERT INTO `event_likes` (`id`, `event_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 0, 1486012824, 1486355850);

-- --------------------------------------------------------

--
-- Table structure for table `event_post`
--

CREATE TABLE `event_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `host_name` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `flyer_image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `like_count` int(11) DEFAULT '0',
  `remuuv_count` int(11) DEFAULT '0',
  `share_count` int(11) DEFAULT '0',
  `comments_count` int(11) DEFAULT '0',
  `capacity` int(11) DEFAULT '0',
  `privacy_status` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_post`
--

INSERT INTO `event_post` (`id`, `title`, `host_name`, `latitude`, `longitude`, `flyer_image`, `start_date`, `end_date`, `start_time`, `end_time`, `like_count`, `remuuv_count`, `share_count`, `comments_count`, `capacity`, `privacy_status`, `type`, `user_id`, `parent_id`, `created_at`, `updated_at`) VALUES
(2, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '_LouQQ5mXt4-v_3l5YlftsXZhGe4Ihes.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', -1, 0, 0, 0, 45, 1, 1, 5, 0, 1484284202, 1486355850),
(3, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'kxPjxOgSMOWkUPydCLM4poHEdgKVHucE.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 2, 7, 2, 1484284892, 1484284892),
(4, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'DrGDKe865c9V_O6sHm5kBDkNP7A_9vt9.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 2, 7, 2, 1484284926, 1484284926),
(5, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '1K6r-qIq01UP6c4KTnUrgag3MKHkRcOC.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 2, 7, 2, 1484284977, 1484284977),
(6, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'bGKPMqOMcBPVN6d8e7LRr0yeHqnDmgNx.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 2, 1484284985, 1484284985),
(7, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'vmO_JAJ-IXf_KlTujspjYukk5jermrqZ.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484287283, 1484287283),
(8, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'FN2eDVjpXqYnwFouDBgfqiBGqoAnvuLG.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484287373, 1484287373),
(10, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'Kb8q8aCSZ1fbmI0WB6PGg2LDIUfeyrGV.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484287426, 1484287426),
(15, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '1LVV_ZW8BWSgMjDLAhjZoUbkAGZTTi8O.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484287626, 1484287626),
(16, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'ZNfaXh46jU5kF91YbPAc64yh-73g1IdM.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 2, 0, 0, 45, 1, 3, 7, 1, 1484288005, 1484288005),
(17, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'Q0OAtzOmnhvHtpCdemf_IgeAofBKfEH5.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 4, 0, 0, 45, 1, 3, 7, 1, 1484288027, 1484288027),
(18, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'N29KZki6vas0Fxt0a7ZU3N-_XbBUz5VG.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 6, 0, 0, 45, 1, 3, 7, 1, 1484288091, 1484288091),
(19, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'OvovrBRukJSL1fSW7zHBmjYlzijWHp1Z.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 8, 0, 0, 45, 1, 3, 7, 1, 1484288115, 1484288115),
(20, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 10, 0, 0, 45, 1, 3, 7, 1, 1484288354, 1484288354),
(21, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 11, 0, 0, 45, 1, 3, 7, 1, 1484288411, 1484288411),
(22, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 11, 0, 0, 45, 1, 3, 7, 1, 1484288418, 1484288418),
(26, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 12, 1, 0, 45, 1, 2, 7, 1, 1484288689, 1484288689),
(27, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 12, 2, 0, 45, 1, 2, 7, 1, 1484288766, 1484288766),
(34, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 12, 3, 0, 45, 1, 3, 7, 1, 1484289302, 1484289302),
(37, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 13, 4, 0, 45, 1, 2, 7, 1, 1484289468, 1484289468),
(38, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 13, 5, 0, 45, 1, 2, 7, 1, 1484289806, 1484289806),
(39, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 13, 6, 0, 45, 1, 2, 7, 1, 1484290256, 1484290256),
(40, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 13, 7, 0, 45, 1, 2, 7, 1, 1484290257, 1484290257),
(41, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 13, 8, 0, 45, 1, 3, 7, 1, 1484372354, 1484372354),
(42, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484373390, 1484373390),
(43, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484376741, 1484376741),
(44, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484377062, 1484377062),
(45, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'wI710PgbgqzmYG-aMB0-VCD7mvuNKw3-.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 1, 1484377391, 1484377391),
(46, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '6wjup1GkyE_iuTDYdtwV6ioSyKpqgh7Q.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486186719, 1486186719),
(47, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'Xa62kI_X_i4vE5JQXJbKyM_HX3kyPiO-.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187486, 1486187486),
(48, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'FAsDnbhPK28C7DTTN1ZsEfSt_Oh6BrcE.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187498, 1486187498),
(49, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'rESjTVKsPEartds6s9t2v3JaHp4AH5sB.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187514, 1486187514),
(50, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'shjHDXhJDeI7t5xHNF2cqeIn4-ot2n4e.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187604, 1486187604),
(51, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '86F7WSYs2nIZUgXc0dcxfVWlp9CPIwcS.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187629, 1486187629),
(52, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'KmQ9sJEsD4Mo2UwPM8eelduZUE9xcy5o.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187639, 1486187639),
(53, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'VMn4nbgrh5AKVIr_QllbjlmrP2E1M_QK.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187646, 1486187646),
(54, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'ByLXngR-2i8UFgFHlgWutEMr1jRbs1gp.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 1, 5, 0, 1486187707, 1486187707),
(55, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'j8ju-fvwxRqCw2_Ed-YcD26_AOA4H0Xt.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 1, 0, 0, 45, 1, 1, 5, 0, 1486187761, 1486188997),
(56, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'OCUzr7pwFx2T-fL7C5py4PGsX0eofJim.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 4, 0, 0, 45, 1, 1, 5, 0, 1486187791, 1486188977),
(57, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'PnAuwXEtU-4K7pZz0928P6FM3sxv9EgP.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 56, 1486188699, 1486188699),
(58, 'Hello', 'Ludhiana And', 12.4232, 32.1244, '_ENGvOs4BGge3Mds1sJ48ILzQOJschgE.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 56, 1486188784, 1486188784),
(59, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'FjDu3b3awXnqZGFg7jiD34aCoE5haiPl.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 56, 1486188857, 1486188857),
(60, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'GhsBbq-mIndIMAxPWbnxKBvdipuwUPb2.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 56, 1486188977, 1486188977),
(61, 'Hello', 'Ludhiana And', 12.4232, 32.1244, 'EfKRJZnTUma0X7wfuB4wTDrWwma_r1LZ.jpg', '2017-02-02', '2017-02-10', '10:45:00', '11:00:00', 0, 0, 0, 0, 45, 1, 3, 7, 55, 1486188997, 1486188998);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `follow_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `follow_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 1484579722, 1484580738);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1483679209),
('m130524_201442_init', 1483679212),
('m170106_102504_event_post_table', 1484283413),
('m170107_044708_create_table_event_like', 1484283414),
('m170107_073218_create_table_user_follower', 1484283414),
('m170107_142510_create_table_comments', 1484283414),
('m170111_055437_alter_user_tbale', 1484283416),
('m170111_065357_create_table_notifications', 1486355846),
('m170116_143446_alter_table_user_1', 1484578053),
('m170202_061035_create_table_tickets', 1484578053);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `notify_user_id` int(11) DEFAULT NULL,
  `notification_created_id` int(11) DEFAULT NULL,
  `content` text,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `name` text,
  `description` text,
  `price` float DEFAULT '0',
  `qty` int(11) DEFAULT '0',
  `event_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `description`, `price`, `qty`, `event_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'hello 1', 'desc here 1', 0, 0, 2, 1, 1486019284, 1486019401),
(2, 'hello', 'desc here', 6, 3, 54, NULL, 1486187707, 1486187707),
(3, 'hello', 'desc here', 6, 3, 55, NULL, 1486187761, 1486187761),
(4, 'tickets 2', 'tickets desc 2', 2, 2, 55, NULL, 1486187761, 1486187761),
(5, 'hello', 'desc here', 6, 3, 56, 1, 1486187792, 1486187792),
(6, 'tickets 2', 'tickets desc 2', 2, 2, 56, 1, 1486187792, 1486187792),
(7, 'hello', 'desc here', 6, 3, 56, 1, 1486188783, 1486188783),
(8, 'tickets 2', 'tickets desc 2', 2, 2, 56, 1, 1486188783, 1486188783),
(9, 'hello', 'desc here', 6, 3, NULL, 1, 1486188856, 1486188856),
(10, 'tickets 2', 'tickets desc 2', 2, 2, NULL, 1, 1486188856, 1486188856),
(11, 'hello', 'desc here', 6, 3, NULL, 1, 1486188856, 1486188856),
(12, 'tickets 2', 'tickets desc 2', 2, 2, NULL, 1, 1486188857, 1486188857),
(13, 'hello', 'desc here', 6, 3, 60, 1, 1486188977, 1486188977),
(14, 'tickets 2', 'tickets desc 2', 2, 2, 60, 1, 1486188977, 1486188977),
(15, 'hello', 'desc here', 6, 3, 60, 1, 1486188977, 1486188977),
(16, 'tickets 2', 'tickets desc 2', 2, 2, 60, 1, 1486188977, 1486188977),
(17, 'hello', 'desc here', 6, 3, 61, NULL, 1486188998, 1486188998),
(18, 'tickets 2', 'tickets desc 2', 2, 2, 61, NULL, 1486188998, 1486188998);

-- --------------------------------------------------------

--
-- Table structure for table `tickets_purchase`
--

CREATE TABLE `tickets_purchase` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_qty` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  `transaction_id` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets_purchase`
--

INSERT INTO `tickets_purchase` (`id`, `ticket_id`, `event_id`, `ticket_qty`, `customer_id`, `status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 5, 3, 512, 5, 1, NULL, 1486271076, 1486271076),
(2, 5, 1, 512, 5, 1, NULL, 1486271085, 1486271085),
(3, 6, 1, 5, 5, 1, NULL, 1486271085, 1486271085),
(4, 5, 1, 512, 5, 1, NULL, 1486271130, 1486271130),
(5, 6, 1, 5, 5, 1, NULL, 1486271130, 1486271130),
(6, 5, 1, 512, 5, 1, NULL, 1486271680, 1486271680),
(7, 6, 1, 5, 5, 1, NULL, 1486271680, 1486271680),
(8, 5, 1, 512, 5, 1, NULL, 1486271759, 1486271759),
(9, 6, 1, 5, 5, 1, NULL, 1486271759, 1486271759),
(10, 5, 1, 512, 5, 1, NULL, 1486271974, 1486271974),
(11, 6, 1, 5, 5, 1, NULL, 1486271974, 1486271974),
(12, 5, 1, 512, 5, 1, NULL, 1486273257, 1486273257),
(13, 6, 1, 5, 5, 1, NULL, 1486273257, 1486273257);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` text COLLATE utf8_unicode_ci NOT NULL,
  `last_name` text COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role_id` int(11) NOT NULL DEFAULT '2',
  `followers_count` int(11) NOT NULL DEFAULT '0',
  `follow_count` int(11) NOT NULL DEFAULT '0',
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('m','f') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `first_name`, `last_name`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile`, `dob`, `status`, `role_id`, `followers_count`, `follow_count`, `profile_pic`, `created_at`, `updated_at`, `url`, `desc`, `gender`) VALUES
(5, 'boparai1', 'Bhavandeep', 'Singh Update', 'FsPs_ke3ksa2NNtAHugoxc968syW6C9U', '$2y$13$qvkG1SrfnSM1XBts/a0.Z.Sb1IDTh3Oa8uMyDanU1rdxRh015sBQu', NULL, 'ghudani11@gmail.com', '8146358363', '1987-11-11', 10, 2, 1, 0, 'uAWy6JFwGW5PFhSxPyWJj7ZxxwUjXVLx.jpg', 1483703900, 1486355550, 'http://local.incourt.update', 'Hello i am there update', 'f'),
(6, 'boparai01', 'Bhavandeep', 'Singh', 'A4Q8hlH8PmBlNUEe-DkJgwVrH42WEemV', '$2y$13$g5Vo/UdJjJ0LYDuxihdKTOLTS88I2KLerd.o3/yi/t.oFBZnO57d.', NULL, 'ghudani01@gmail.com', '8146358363', '1987-11-11', 10, 2, 0, 0, '2yAm1TCVj_-Ms-o5sXXCioipChcRswPS.jpg', 1484114514, 1484921445, NULL, NULL, NULL),
(7, 'boparai0-1', 'Bhavandeep', 'Singh', 'GbZJgQXEdDZvTLT_zy2K8eTSbbgd4kpy', '$2y$13$1lvq9n9E1xT7QIQTbZwjJehpO9P8gpUpf4y182BcyGysf0hWON.Sa', NULL, 'ghudani001@gmail.com', '8146358363', '1987-11-11', 10, 2, 0, 0, 'qGowg1I8lGboK0acAajgwSYj72bViGff.jpg', 1484115097, 1484921446, NULL, NULL, NULL),
(8, 'boparai001', 'Bhavandeep', 'Singh', '_cdSn88-Hb8A4QLJ5p0RCNlvropcta7w', '$2y$13$VlaT/HJbOG2OAa1qYv8gi.BbYuKS/DkxTR9OfTHai.q.1NKKQOtRC', NULL, 'ghudani0001@gmail.com', '8146358363', '1987-11-11', 10, 2, 0, 0, 'WNDyAHzRUeosnMdH0p6pVvZF-ikHpfru.jpg', 1484371288, 1484925246, 'http://local.incourt', 'Hello i am there', 'm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_likes`
--
ALTER TABLE `event_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_post`
--
ALTER TABLE `event_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_purchase`
--
ALTER TABLE `tickets_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `event_likes`
--
ALTER TABLE `event_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `event_post`
--
ALTER TABLE `event_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tickets_purchase`
--
ALTER TABLE `tickets_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
