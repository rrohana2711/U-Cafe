-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3301
-- Generation Time: Jul 18, 2025 at 08:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u-cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `category` enum('set','masakan','kuah','western','side','drink','juice') NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `category`, `item_name`, `price`, `image_url`) VALUES
(1, 'drink', 'Teh O Ais', 1.50, 'img/tehoais.png'),
(2, 'drink', 'Matcha Ais', 3.00, 'img/matcha.png'),
(3, 'drink', 'Kopi O', 1.00, 'img/kopio.png'),
(4, 'drink', 'Teh O', 1.00, 'img/teho.png'),
(5, 'drink', 'Teh Tarik', 1.00, 'img/tehtarik.png'),
(6, 'drink', 'Milo', 2.50, 'img/milopanas.png'),
(7, 'juice', 'Apple Juice', 2.20, 'img/applejuice.png'),
(8, 'juice', 'Orange Juice', 2.50, 'img/orangejuice.png'),
(9, 'juice', 'Watermelon Juice', 3.00, 'img/tembikaijuice.png'),
(10, 'set', 'Nasi Ayam', 6.00, 'img/nasi ayam.png'),
(11, 'set', 'Nasi Lemak', 2.00, 'img/nasi lemak.png'),
(12, 'set', 'Nasi Bujang', 4.00, 'img/nasi bujang.png'),
(13, 'set', 'Nasi Geprek', 6.00, 'img/Nasi Geprek.png'),
(14, 'set', 'Nasi Lemak Ayam', 6.00, 'img/nasi lemak ayam.png'),
(15, 'set', 'Nasi Tomato', 6.00, 'img/nasi Tomato.png'),
(16, 'masakan', 'Nasi Goreng', 4.50, 'img/nasi goreng.png'),
(17, 'masakan', 'Mee Goreng', 4.00, 'img/mee goreng.png'),
(18, 'masakan', 'Kuey Teow Goreng', 4.00, 'img/kuey teow goreng.png'),
(19, 'masakan', 'Maggie Goreng', 4.00, 'img/Maggi goreng.png'),
(20, 'kuah', 'Mi Kari', 5.00, 'img/mi kari.png'),
(21, 'kuah', 'Laksa', 4.50, 'img/laksa.png'),
(22, 'kuah', 'Tomyam', 5.50, 'img/tomyam.png'),
(23, 'western', 'Chicken Chop', 8.90, 'img/chicken chop.png'),
(24, 'western', 'Spaghetti Bolognese', 5.00, 'img/bolognese.png'),
(25, 'western', 'Spaghetti Carbonara', 5.00, 'img/cabonara.png'),
(26, 'western', 'Spaghetti Aglio Olio', 5.00, 'img/aglio.png'),
(27, 'side', 'French Fries', 3.00, 'img/fries.png'),
(28, 'side', 'Nuggets', 0.80, 'img/Nugget.png'),
(29, 'side', 'Takoyaki', 5.00, 'img/Takoyaki.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `order_type` enum('dine_in','take_away') NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','preparing','ready','completed','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `customer_name`, `customer_phone`, `order_type`, `order_date`, `status`, `total_amount`) VALUES
(1, 'ORD-00001', 'Khadijah', '60189772733', 'dine_in', '2025-07-18 11:46:32', 'ready', 16.50),
(2, 'ORD-00002', 'Hafiz', '60179056761', 'take_away', '2025-07-18 11:52:38', 'completed', 17.60),
(3, 'ORD-00003', 'Auni', '6012456789', 'dine_in', '2025-07-18 11:55:06', 'ready', 19.50),
(5, 'ORD-00004', 'Safi', '60185642345', 'take_away', '2025-07-18 12:02:21', 'preparing', 51.70),
(6, 'ORD-00005', 'Hana', '60183908708', 'dine_in', '2025-07-18 12:18:17', 'completed', 5.50),
(7, 'ORD-00006', 'Shamil', '60183908708', 'dine_in', '2025-07-18 12:18:57', 'preparing', 7.00),
(8, 'ORD-00007', 'Aina ', '60107975868', 'dine_in', '2025-07-18 12:20:23', 'preparing', 10.00),
(9, 'ORD-00008', 'Ameera', '60122427712', 'take_away', '2025-07-18 12:22:25', 'pending', 6.00),
(10, 'ORD-00009', 'Fasha', '60109418809', 'dine_in', '2025-07-18 12:23:39', 'pending', 5.00),
(11, 'ORD-00010', 'Hana', '60183908708', 'dine_in', '2025-07-18 14:36:23', 'pending', 1.00),
(12, 'ORD-00011', 'khadijah', '601567897', 'dine_in', '2025-07-18 15:19:25', 'pending', 4.70),
(15, 'ORD-00012', 'Ali', '60123456789', 'dine_in', '2025-07-18 15:51:35', 'pending', 6.00),
(16, 'ORD-00013', 'khadijah', '60189772733', 'dine_in', '2025-07-18 16:16:27', 'completed', 11.70),
(17, 'ORD-00014', 'Dijah', '60123456789', 'dine_in', '2025-07-18 16:31:54', 'pending', 6.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `item_name`, `price`, `quantity`) VALUES
(1, 1, 10, 'Nasi Ayam', 6.00, 1),
(2, 1, 14, 'Nasi Lemak Ayam', 6.00, 1),
(3, 1, 1, 'Teh O Ais', 1.50, 1),
(4, 1, 9, 'Watermelon Juice', 3.00, 1),
(5, 2, 2, 'Matcha Ais', 3.00, 1),
(6, 2, 14, 'Nasi Lemak Ayam', 6.00, 1),
(7, 2, 13, 'Nasi Geprek', 6.00, 1),
(8, 2, 4, 'Teh O', 1.00, 1),
(9, 2, 28, 'Nuggets', 0.80, 2),
(10, 3, 20, 'Mi Kari', 5.00, 3),
(11, 3, 21, 'Laksa', 4.50, 1),
(14, 5, 23, 'Chicken Chop', 8.90, 3),
(15, 5, 25, 'Spaghetti Carbonara', 5.00, 1),
(16, 5, 26, 'Spaghetti Aglio Olio', 5.00, 2),
(17, 5, 24, 'Spaghetti Bolognese', 5.00, 2),
(18, 5, 23, 'Chicken Chop', 8.90, 3),
(19, 5, 25, 'Spaghetti Carbonara', 5.00, 1),
(20, 5, 26, 'Spaghetti Aglio Olio', 5.00, 2),
(21, 5, 24, 'Spaghetti Bolognese', 5.00, 2),
(22, 6, 21, 'Laksa', 4.50, 1),
(23, 6, 4, 'Teh O', 1.00, 1),
(24, 7, 9, 'Watermelon Juice', 3.00, 1),
(25, 7, 12, 'Nasi Bujang', 4.00, 1),
(26, 8, 1, 'Teh O Ais', 1.50, 1),
(27, 8, 16, 'Nasi Goreng', 4.50, 1),
(28, 8, 17, 'Mee Goreng', 4.00, 1),
(29, 9, 14, 'Nasi Lemak Ayam', 6.00, 1),
(30, 10, 20, 'Mi Kari', 5.00, 1),
(31, 11, 3, 'Kopi O', 1.00, 1),
(32, 12, 7, 'Apple Juice', 2.20, 1),
(33, 12, 8, 'Orange Juice', 2.50, 1),
(36, 15, NULL, 'Nasi Lemak Ayam', 0.00, 1),
(37, 16, 20, 'Mi Kari', 5.00, 1),
(38, 16, 16, 'Nasi Goreng', 4.50, 1),
(39, 16, 7, 'Apple Juice', 2.20, 1),
(40, 17, NULL, 'Nasi Lemak Ayam', 0.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD UNIQUE KEY `order_number_2` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_item` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
