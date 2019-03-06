-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2018 at 04:38 AM
-- Server version: 10.1.34-MariaDB
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
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comment` tinyint(1) NOT NULL DEFAULT '0',
  `allow_ads` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ordering`, `visibility`, `allow_comment`, `allow_ads`) VALUES
(9, 'HandMade', 'Hand Made Items', 1, 0, 0, 0),
(10, 'Computer', 'Computer Items', 2, 0, 0, 0),
(11, 'Cell Phones', 'Cell Phones Items', 3, 0, 0, 0),
(12, 'Clothing', 'Clothing and Fashion', 4, 0, 0, 0),
(13, 'Tools', 'Home Tools', 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `date`, `country_made`, `image`, `status`, `rating`, `img`, `cat_id`, `member_id`) VALUES
(19, 'Nokia 7.1', 'Nokia 7.1 - Android One (Pie) - 64 GB - 12+5 MP Dual Camera ', '349', '2018-10-29', 'USA', '176623_Nokia-7.1.jpg', '1', 0, '', 11, 1),
(20, 'Samsung Galaxy S9', 'Samsung Galaxy S9 Unlocked Smartphone - 64GB - Midnight Black - US Warranty', '420', '2018-10-29', 'USA', '733186_Samsung-Galaxy-S9.jpg', '2', 0, '', 11, 2),
(21, 'CPR Call Blocker', 'CPR Call Blocker CS900 Unlocked Flip Cell Phone - Big Button - Call Blocker - SOS Emergency Assist Button (Gloss Red) CPR Call Blocker CS900 Unlocked Flip Cell Phone - Big Button ', '30', '2018-10-29', 'india', '281537_CPR-Call-Blocker.jpg', '3', 0, '', 11, 1),
(22, 'Miusey', 'Miusey Women&#39;s Long Sleeve V Neck Pleated Pullover Sweatshirts Tunic Hoodies', '16', '2018-10-30', 'USA', '590091_Miusey.jpg', '1', 0, '', 12, 1),
(23, 'LARACE', 'LARACE Womens Swing Tunic Tops Loose Fit Comfy Flattering T Shirt\r\n', '20', '2018-10-30', 'india', '91382_LARACE.jpg', '1', 0, '', 12, 1),
(24, 'Anklets', 'Your Name Anklet 16K Gold Silver Rose Gold -Plated Bar anklet - Delicate initial name anklet Bridesmaid Charms Hand Stamp Christmas Bridesmaid Wedding Gift SAME DAY SHIPPING GIFT TIL 2PM CDT', '9', '2018-10-30', 'USA', '116990_Anklets.jpg', '2', 0, '', 9, 5),
(25, 'Opal Anklets', 'Opal anklets,stone anklets,white anklets,fashion anklets for Men and Women\r\n', '4', '2018-10-30', 'China', '441791_Opal Anklets.jpg', '3', 0, '', 9, 5),
(26, 'Acer Aspire 1', 'Acer Aspire 1, 14&#34; Full HD, Intel Celeron N3450, 4GB RAM, 32GB Storage, Windows 10 Home, A114-31-C4HH\r\n', '120', '2018-10-30', 'China', '889419_Acer Aspire 1.jpg', '4', 0, '', 10, 5),
(27, 'Dell OptiPlex Desktop', 'Dell OptiPlex Desktop Complete Computer Package with Windows 10 Home - Keyboard, Mouse, 17&#34; LCD Monitor (Certified Refurbished)\r\n', '124', '2018-10-30', 'USA', '204727_Dell OptiPlex Desktop.jpg', '1', 0, '', 10, 5),
(28, 'RCA Galileo Pro ', 'Premium High Performance RCA Galileo Pro 11.5&#34; 32GB Touchscreen Tablet Computer with Keyboard Case Quad-Core 1.3Ghz Processor 1G Memory 32GB HDD Webcam Wifi Bluetooth Android 6.0-Blue\r\n', '120', '2018-10-30', 'USA', '383395_RCA Galileo Pro.jpg', '3', 0, '', 10, 5),
(29, 'SeSe Code', 'SeSe Code Womens 3/4 Roll Sleeve Shirt Notch Neck Loose Tops Plaid Tunic Blouse(FBA)\r\n', '18', '2018-10-30', 'USA', '380450_SeSe Code.jpg', '1', 0, '', 12, 1),
(30, 'Huawei P20 Lite', 'Huawei P20 Lite ANE-LX3 32GB + 4GB Dual SIM LTE Factory Unlocked Smartphone (Klein Blue)\r\n', '210', '2018-10-30', 'Korea', '522179_Huawei P20 Lite.jpg', '2', 0, '', 11, 1),
(31, 'Samsung Galaxy Note 3', 'Samsung Galaxy Note 3 N900A Unlocked Cellphone, 32GB, Black\r\n', '268', '2018-10-30', 'Korea', '381598_Samsung Galaxy Note 3.jpg', '1', 0, '', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL COMMENT 'to identify users',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'login information',
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `permissionid` int(11) DEFAULT '0' COMMENT 'identify permissions',
  `truststatus` int(11) NOT NULL DEFAULT '0' COMMENT 'seller rank',
  `regstatus` int(11) NOT NULL DEFAULT '0' COMMENT 'pending approval',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`, `fullname`, `permissionid`, `truststatus`, `regstatus`, `date`) VALUES
(1, 'hesham', '7c222fb2927d828af22f592134e8932480637c0d', 'scihesham12@gmail.com', 'hesham samir mohamed', 1, 1, 1, '2018-04-11'),
(2, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed_rae@yahoo.com', 'ahmed walid hassan zero', 0, 0, 0, '2018-08-10'),
(3, 'mohamed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohamed@yahoo.com', 'mohamed halabsa', 1, 0, 1, '2018-08-23'),
(5, 'mahmoud', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mahali@gmail.com', 'mahmoud hassan ahmed', 0, 0, 0, '2018-09-03'),
(8, 'hassan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hassan@yahoo.com', 'hassan elmasry', 0, 0, 0, '2018-09-21'),
(9, 'youssef', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'youssef@hotmail.com', 'youssef zaki', 0, 0, 1, '2018-09-22'),
(10, 'hesh', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hess@yahoo.com', 'hhhas asjjasj asjjj', 1, 1, 1, '2018-10-10'),
(11, 'mesho', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'sci11@gmail.com', 'hesham samir mohamed', 0, 0, 0, '2018-10-13'),
(12, 'aaahhh', 'c6acc03bc6a7b892db6f7db777223a3a96a35fdc', 'aahmed_rae@yahoo.com', 'mahmoud hassan ahmed', 0, 0, 1, '2018-10-13'),
(13, 'mememe', '747417f2206148a3118d02f3adf20b5e4139baac', 'scihesham012@gmail.com', 'mahmoud hassan ahmed', 0, 0, 0, '2018-10-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_comment` (`item_id`),
  ADD KEY `user_comment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_1` (`cat_id`),
  ADD KEY `member_1` (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify users', AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
