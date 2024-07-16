-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2024 at 09:21 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutrition_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `addlist`
--

CREATE TABLE `addlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `cid` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `pret` int NOT NULL,
  `imagine` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `addlist`
--

INSERT INTO `addlist` (`id`, `user_id`, `cid`, `nume`, `pret`, `imagine`) VALUES
(21, 10, 5, 'varza chinezeasca', 5, 'img1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `cid` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `pret` int NOT NULL,
  `cantitate` int NOT NULL,
  `imagine` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `cid`, `nume`, `pret`, `cantitate`, `imagine`) VALUES
(27, 10, 7, 'morcov', 5, 1, 'img3.png');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `numar` varchar(15) NOT NULL,
  `mesaj` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `nume`, `email`, `numar`, `mesaj`) VALUES
(3, 10, 'Bossss', 'bosss@gmail.com', '123132123', 'message'),
(4, 10, 'Bossss', 'bosss@gmail.com', '13121216787', 'another one');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `numar` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `metoda` varchar(100) NOT NULL,
  `adresa` varchar(600) NOT NULL,
  `produse_total` varchar(1500) NOT NULL,
  `pret_total` int NOT NULL,
  `plasare` varchar(100) NOT NULL,
  `status_plata` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `nume`, `numar`, `email`, `metoda`, `adresa`, `produse_total`, `pret_total`, `plasare`, `status_plata`) VALUES
(4, 10, 'Bossss', '221313131312', 'bosss@gmail.com', 'credit card', 'flat no. adwadadw adwdadw adwad adadaw adadwa - 21313', ', varza chinezeasca ( 1 ) , morcov ( 1 ) ', 10, '01-Jun-2024', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `categorie` varchar(30) NOT NULL,
  `detalii` varchar(500) NOT NULL,
  `pret` int NOT NULL,
  `imagine` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nume`, `categorie`, `detalii`, `pret`, `imagine`) VALUES
(2, 'lamaine', 'fruits', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 5, 'img5.jpg'),
(5, 'varza chinezeasca', 'vegitables', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 5, 'img1.jpg'),
(7, 'morcov', 'vegitables', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 5, 'img3.png'),
(8, 'pui', 'meat', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 10, 'img8.png'),
(9, 'pastrav', 'fish', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 20, 'img9.png'),
(10, 'banana', 'fruits', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC', 2, 'img2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nume` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `parola` varchar(150) NOT NULL,
  `tip_user` varchar(30) NOT NULL,
  `imagine` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nume`, `email`, `parola`, `tip_user`, `imagine`) VALUES
(6, 'Alex', 'aka@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'prs3.jpg'),
(8, 'Ioana', 'we@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', 'prs5.png'),
(10, 'Bossss', 'bosss@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', 'prs5.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addlist`
--
ALTER TABLE `addlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `addlist`
--
ALTER TABLE `addlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
