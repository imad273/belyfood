-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2021 at 03:51 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belyfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_id` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_id`, `UserName`, `Password`, `Email`, `FullName`, `Date`) VALUES
(1, 'admin', '$2y$10$tDKrOqLQy/WfMtCDWc.tGebcuHbV85vNIC/LXjM/UY2.6T8AABcC6', 'admin@email.com', 'super admin', '2021-08-18'),
(2, 'new_admin', '$2y$10$x.dksEbkgiJFr8f1KwROHuPhNnO.XL4TUTjaykIkccOVx8QWBop0C', 'newadmin@email.com', 'new admin', '2021-08-19'),
(6, 'test', '$2y$10$VRb.IEqgM.rl01SOHVGswOuBq7AYNPWtwq4wEkiBUXyX.AjoYEI6m', 'test@gggg', 'test', '2021-08-20');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Dish_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Dish_id`, `Name`, `Description`, `Image`, `Price`) VALUES
(2, 'Burger King', 'Burger King advertises the Whopper as &#34;America&#39;s Favorite Burger,&#34; and there&#39;s no doubting its iconic status. More than 11 million customers walk through Burger King&#39;s doors each day, many of them in pursuit of the famous burger.', '98502192_burger-king.jpg', 20),
(3, 'Sonic Cherry Limeade', 'Sonic holds a daily Happy Hour that features half-priced drinks, and people turn up on schedule for the Cherry Limeade.', '45285690_sonic-limeade.jpg', 10),
(4, 'Taco Bell Burrito Supreme', 'Taco Bell has crowned this burrito &#34;The Supreme Ruler of the Burrito Empire,&#34; and it has many loyal subjects to prove it.', '82629359_taco-burrito.jpg', 24),
(5, 'Domino&#39;s Pepperoni Pizza', 'Domino&#39;s may be the number-two pizza chain in America, but it&#39;s quickly gaining steam on Pizza Hut and could surpass it in popularity. According to QSR, its pepperoni pizza is easily the most-delivered item on the menu.', '1797454_dominos-pepperoni.jpg', 27),
(6, 'Hash Browns', 'Sure, everyone knows that French fries are the star of the Mickey D&#39;s sides menu. But McDonald&#39;s Hash Browns are a close second, and have the added advantage of being &#34;breakfast friendly.&#34;', '50725085_hash-browns.jpg', 16),
(7, 'Papa John&#39;s Cheese Pizza', 'Papa John&#39;s attributes its popularity to &#34;real meat and fresh veggies&#34; on its website. But sometimes, a classic cheese pizza hits the spot, too.', '36124305_papa-johns.jpg', 35);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_id` int(11) NOT NULL,
  `Dish_name` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Client_name` varchar(255) NOT NULL,
  `Client_address` varchar(255) NOT NULL,
  `Client_phone` varchar(18) NOT NULL,
  `Quantity` smallint(6) NOT NULL,
  `Order_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_id`, `Dish_name`, `Price`, `Client_name`, `Client_address`, `Client_phone`, `Quantity`, `Order_date`) VALUES
(1, 'Burger King\r\n', 20, 'Ann L. Cruz', '3306 Traction Street\r\nGreenville, SC 29607', '845-563-4072', 2, '2021-08-21 22:55:28'),
(2, 'Taco Bell Burrito Supreme', 24, 'Angelo Y. Brown', '2166 Pin Oak Drive\nClinton, IA 52732', '563-321-1495', 1, '2021-08-19 14:55:28'),
(3, 'Taco Bell Burrito Supreme', 48, 'Charles C. Bridges', '931 Bloomfield Way Augusta, ME 04330', '207-624-3660', 2, '2021-08-23 10:09:24'),
(4, 'Hash Browns', 48, 'John R. Heffernan', '1431 Private Lane Albany, GA 31707', '229-291-1965', 3, '2021-08-23 10:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_id` int(11) NOT NULL,
  `Reviewer_name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Rate` smallint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_id`, `Reviewer_name`, `Description`, `Rate`) VALUES
(2, 'Kenneth J. Rockwell', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illum molestias ipsa tenetur.', 7),
(3, 'Matthew A. Tucker', 'consectetur adipisicing elit. Illum molestias ipsa tenetur .Lorem ipsum, dolor sit amet', 8),
(4, 'Jeanette T. Best', 'consectetur adipisicing Lorem ipsum, dolor sit  elit. Illum molestias ipsa tenetur. amet ', 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Dish_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
