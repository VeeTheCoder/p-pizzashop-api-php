-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2020 at 02:02 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201109171838', '2020-11-09 09:19:15', 509),
('DoctrineMigrations\\Version20201109173303', '2020-11-09 09:33:11', 74);

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_type`
--

CREATE TABLE `ingredient_type` (
  `id` int NOT NULL,
  `ingredient_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredient_type`
--

INSERT INTO `ingredient_type` (`id`, `ingredient_type`) VALUES
(1, 'Sauce'),
(2, 'Topping');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'Cancelled'),
(2, 'Order Started'),
(3, 'Order Placed'),
(4, 'Prep'),
(5, 'Bake'),
(6, 'Box'),
(7, 'Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_combination`
--

CREATE TABLE `pizza_combination` (
  `id` int NOT NULL,
  `pizza_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  `section_number` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_ingredient`
--

CREATE TABLE `pizza_ingredient` (
  `id` int NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `ingredient_type_id` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizza_ingredient`
--

INSERT INTO `pizza_ingredient` (`id`, `ingredient_name`, `ingredient_type_id`, `price_dollar`, `price_cent`) VALUES
(1, 'Ham', 2, 0, 50),
(2, 'Beef', 2, 0, 50),
(3, 'Salami', 2, 0, 50),
(4, 'Pepperoni', 2, 0, 50),
(5, 'Italian Sausage', 2, 0, 50),
(6, 'Premium Chicken', 2, 0, 75),
(7, 'Bacon', 2, 0, 75),
(8, 'Philly Steak', 2, 0, 75),
(9, 'Garlic', 2, 0, 50),
(10, 'Jalapeno Peppers', 2, 0, 50),
(11, 'Onions', 2, 0, 50),
(12, 'Banana Peppers', 2, 0, 50),
(13, 'Diced Tomatoes', 2, 0, 50),
(14, 'Black Olives', 2, 0, 50),
(15, 'Mushrooms', 2, 0, 50),
(16, 'Pineapple', 2, 0, 50),
(17, 'Green Peppers', 2, 0, 50),
(18, 'Cheese', 2, 0, 0),
(19, 'Spinach', 2, 0, 50),
(20, 'Fire Roasted Red Peppers', 2, 0, 50),
(21, 'Marinara', 1, 0, 0),
(22, 'BBQ', 1, 0, 25),
(23, 'Alfredo', 1, 0, 25);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_order`
--

CREATE TABLE `pizza_order` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status_id` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_order_line`
--

CREATE TABLE `pizza_order_line` (
  `id` int NOT NULL,
  `pizza_order_id` int NOT NULL,
  `pizza_combination_id` int NOT NULL,
  `pizza_size_id` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_size`
--

CREATE TABLE `pizza_size` (
  `id` int NOT NULL,
  `size` varchar(25) NOT NULL,
  `price_cent` smallint NOT NULL,
  `price_dollar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizza_size`
--

INSERT INTO `pizza_size` (`id`, `size`, `price_cent`, `price_dollar`) VALUES
(1, 'Small', 0, 5),
(2, 'Medium', 50, 6),
(3, 'Large', 0, 8),
(4, 'X-Large', 0, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `ingredient_type`
--
ALTER TABLE `ingredient_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_combination`
--
ALTER TABLE `pizza_combination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_ingredient`
--
ALTER TABLE `pizza_ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_order`
--
ALTER TABLE `pizza_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_order_line`
--
ALTER TABLE `pizza_order_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_size`
--
ALTER TABLE `pizza_size`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ingredient_type`
--
ALTER TABLE `ingredient_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pizza_combination`
--
ALTER TABLE `pizza_combination`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizza_ingredient`
--
ALTER TABLE `pizza_ingredient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pizza_order`
--
ALTER TABLE `pizza_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pizza_order_line`
--
ALTER TABLE `pizza_order_line`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pizza_size`
--
ALTER TABLE `pizza_size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
