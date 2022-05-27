-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2022 at 01:53 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinas`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `price` double DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `caption`, `price`, `img`, `category`) VALUES
(1, 'Spaghetti', 'Cheesy pasta with vegetables and bechamel sauce', 400, 'spaghetti.jpg', 'starter'),
(3, 'Tagliatelle', 'Spicy pasta with bolognese sauce and vegetables or meat of choice.', 325, 'tagliatelle.jpg', 'pasta'),
(4, 'Macaroni', 'Tomato sauce pasta. Add-ons with chicken, cheese.', 300, 'macaroni.jpg', 'pasta'),
(9, 'Tagliatelle', 'Pasta with bolognese sauce and vegetables or meat of choice.', 325, 'tagliatelle.jpg', 'Starter'),
(12, 'Gelato', 'Chocolat ice cream with chocolate sirup.', 100, 'gelato.jpg', 'dessert'),
(13, 'Margheritta', 'Tomato sauce pasta. Add-ons with chicken, cheese.', 300, 'pizza.jpg', 'pizza'),
(162, 'Mozzarella Arancini', 'Crispy arancini risotto balls with a soft mozzarella center.', 100, 'default.jpg', 'Starter'),
(163, 'Green Tea', 'A cold glass of freshly made green tea with lime and mint.', 125, 'greentea.jpg', 'drinks'),
(164, 'Lasagna ', 'With basil, sausage, ground beef and three types of cheese', 450, 'lasagna.jpg', 'Pasta'),
(167, 'Macaroni', 'Tomato sauce pasta. Add-ons with chicken, cheese.', 300, 'macaroni.jpg', 'Starter'),
(170, 'Aperitivo', 'Fresh glass of juice with orange.', 300, 'aperitivo.jpg', 'Drinks'),
(182, ' Chestnut', 'Creamy dessert with fresh cream on top', 150, 'chestnut.jpg', 'Dessert'),
(190, 'Gnocchi', 'Pasta with white sauce and some vegetables.', 375, 'gnocchi.jpg', 'Starter'),
(191, 'Chicken Mayo', 'Pizza with chicken and mayonnaise. One of our favorite.', 400, 'pizza.jpg', 'Pizza'),
(195, 'Four Cheese', 'Mozzarella, Gorgonzola, Fontina and Parmigiano.', 400, 'pizza-four-cheese.jpg', 'Pizza'),
(197, 'Rasberry Beret', 'Juice to drink when you are very hungry.', 150, 'rasberry_beret.jpg', 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `party_size` smallint(6) NOT NULL,
  `date` date NOT NULL,
  `time` tinyint(4) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `uid`, `party_size`, `date`, `time`, `status`) VALUES
(3001, 1002, 3, '2022-05-20', 5, 'approved'),
(3002, 1003, 4, '2022-05-20', 6, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `res_tab`
--

CREATE TABLE `res_tab` (
  `id` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `tid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `res_tab`
--

INSERT INTO `res_tab` (`id`, `rid`, `tid`) VALUES
(6, 3001, 1),
(7, 3001, 2),
(8, 3002, 1),
(9, 3002, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `tab_num` int(11) NOT NULL,
  `placement` varchar(255) NOT NULL DEFAULT 'inside'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `tab_num`, `placement`) VALUES
(1, 0, 'inside'),
(2, 0, 'outside'),
(3, 0, 'vip'),
(4, 0, 'inside');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_admin` varchar(3) NOT NULL DEFAULT 'no',
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `phone`, `is_admin`, `google_id`) VALUES
(1001, 'admin', '$2y$10$35qZlmtHjdLfkmWOO8hpGekOpGoXsSnGmFTEwcaC7ZCo2/vaK5OU6', 'Admin Account', 'admin@dinas.restaurant.com', '59040040', 'yes', NULL),
(1002, 'user', '$2y$10$G/gzic1rWmUdVnHeAqaEjOZjQVLFrM6qTCjngk2tu43rJCVVAgr5K', 'User One', 'userone@gmail.com', '59382719', 'no', NULL),
(1003, 'ved', '$2y$10$AnKbazPFH8TG0uK463eYpeqK38TZ0XyVcunE1jODstic/udO9JZa6', 'Ved Rowjee', 'ved.rowjee@umail.uom.ac.mu', '59740029', 'no', NULL),
(1006, 'vedrowjee', '$2y$10$0Gsvekd7/zl908KmCRPth.9Yoes7grWkMT.qs2m7Nn1Dxm.R5cuDK', 'Ved Rowjee', 'vedrowjee@gmail.com', '', 'no', '100135122360841924426'),
(1007, 'user2', '$2y$10$wHf/ED1/wkvSjV5MfyWfeuB2XDWTxhgGHOcuuPj17tpNgbBPc6ym2', 'User Two', 'usertwo@yahoo.com', '79200192', 'no', NULL),
(1008, 'zakari', '$2y$10$RhAdubhSmyNN4.TL/xV1QeLqbO/iuWn7utUSHx2WEwzI8gtiPVgU2', 'Zakari', 'zakaaa13@hotmail.com', '59720019', 'no', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_u_fk` (`uid`);

--
-- Indexes for table `res_tab`
--
ALTER TABLE `res_tab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_r_fk` (`rid`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2001;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3003;

--
-- AUTO_INCREMENT for table `res_tab`
--
ALTER TABLE `res_tab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `r_u_fk` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
