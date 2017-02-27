-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2017 at 11:51 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flockjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `timestamp` bigint(50) NOT NULL,
  `salary` varchar(255) NOT NULL DEFAULT 'Unspecified'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `company`, `location`, `timestamp`, `salary`) VALUES
(1, 'PHP Developer', 'a jsdflkasd faksldhfklhals kjdhfjadhs hafsdhkjf adsjhfa sdfahsd fadsf asdhf asdjkfasd fakjsdhfjahsdj fasjdhfkajsdh fkjahsdfa dsfasd fasdfkj asdfjasdk fakdjfhad', 'Facebook', 'Sydney, NSW', 1487754115, '60000'),
(2, 'PHP Developer', 'a jsdflkasd faksldhfklhals kjdhfjadhs hafsdhkjf adsjhfa sdfahsd fadsf asdhf asdjkfasd fakjsdhfjahsdj fasjdhfkajsdh fkjahsdfa dsfasd fasdfkj asdfjasdk fakdjfhad', 'Twitter', 'Sydney, NSW', 1487754115, '65000'),
(3, 'Java Developer', 'falsdhjfla dskfasdjf kajsdfk jasdkfjalk sjdflka', 'Google', 'Sydney, NSW', 1487754115, '85000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `salt`) VALUES
(4, 'Chris Richards', 'chrisrichardsdev@gmail.com', '110b85a186309a81435dd4672f12ee528502242cc87e034b1b47ec0030325f42', '7211728823c64fa2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
