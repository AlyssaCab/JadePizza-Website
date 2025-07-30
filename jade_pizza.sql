-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2025 at 09:49 PM
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
-- Database: `jade_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$GN10Ub2OTrxHiGO32rAJWOlZEDpQotOtdyanZJZwdJAh7GuifIdli');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `flat_price` decimal(6,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `menu_item_id`, `flat_price`, `description`) VALUES
(1, 19, 15.99, 'Pick any two medium pizzas for a discounted price.'),
(2, 20, 19.99, 'Includes 1 large pizza, 1 garlic bread, and 2 drinks.');

-- --------------------------------------------------------

--
-- Table structure for table `deal_requirements`
--

CREATE TABLE `deal_requirements` (
  `id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `required_category` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `required_size` varchar(20) DEFAULT NULL,
  `required_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deal_requirements`
--

INSERT INTO `deal_requirements` (`id`, `deal_id`, `required_category`, `quantity`, `required_size`, `required_name`) VALUES
(1, 1, 'Pizza', 2, 'Medium', NULL),
(2, 2, 'Pizza', 1, 'Large', NULL),
(3, 2, 'Side', 1, 'Regular', 'Garlic Bread'),
(4, 2, 'Drink', 2, 'Can', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_special` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `image`, `category`, `is_special`) VALUES
(1, 'Nutella Pizza', 'Sweet hazelnut spread, dusted with powdered sugar.', 'images/nutella.png', 'Pizza', 1),
(2, 'BLT Pizza', 'Cheese and bacon cooked dough, topped with mayo, lettuce, and tomato.', 'images/blt.png', 'Pizza', 1),
(4, '4 Cheese Pizza', 'Classic rich tomato sauce, topped with a blend of fresh mozzarella, cheddar, feta, and parmesan cheese.', 'images/4cheese.png', 'Pizza', 0),
(5, 'Pepperoni Pizza', 'Delicious round pepperoni on a bed of fresh mozzarella and our classic tomato sauce.', 'images/pepperoni.png', 'Pizza', 0),
(6, 'Meat Lovers Pizza', 'A meat lovers fantasy! Pepperoni, sausage, bacon, and ham all on one delicious pizza.', 'images/meat-lovers.png', 'Pizza', 0),
(7, 'Hawaiian Pizza', 'Sweet and savoury! Delicious ham and bacon, alongside fresh pineapple and mozzarella.', 'images/hawaiian.png', 'Pizza', 0),
(8, 'Veggie Pizza', 'Fresh and delicious! Sliced mushrooms, olives, roasted red peppers, and onions on a bed of fresh mozzarella cheese.', 'images/veggie.png', 'Pizza', 0),
(9, 'Sausage Pizza', 'Classic rich tomato sauce, topped with Italian sausage and fresh mozzarella cheese.', 'images/sausage.png', 'Pizza', 0),
(10, 'Ham Pizza', 'Classic rich tomato sauce, topped with fresh mozzarella cheese and ham.', 'images/ham.png', 'Pizza', 0),
(11, 'Margarita Pizza', 'Classic rich tomato sauce, topped with fresh basil and mozzarella cheese.', 'images/margarita.png', 'Pizza', 0),
(12, 'Spinach and Feta Pizza', 'Creamy Alfredo sauce, topped with fresh spinach, onions, feta, and mozzarella cheese.', 'images/spinach-and-feta.png', 'Pizza', 0),
(13, 'Greek Pizza', 'Tomatoes, olives, onions, feta and mozzarella cheese.', 'images/greek.png', 'Pizza', 0),
(14, 'BBQ Chicken Pizza', 'Chicken, roasted red peppers, onions, fresh mozzarella and BBQ sauce.', 'images/bbq-chicken.png', 'Pizza', 0),
(15, 'Garlic Bread', 'Cheesy, delicious, garlic butter covered pizza dough.', 'images/garlic-bread.png', 'Side', 0),
(16, 'Caesar Salad', 'Creamy homemade Caesar salad dressing on a fresh bed of lettuce, topped with bacon and croutons.', 'images/caesar.png', 'Side', 0),
(17, 'Jade Cola', 'A bold and refreshing cola with a smooth, classic taste—perfect with any pizza.', 'images/jade.png', 'Drink', 0),
(18, 'Frost Pop', 'A crisp lemon-lime soda bursting with icy citrus flavor to cool you down.', 'images/frost.png', 'Drink', 0),
(19, '2 Medium Pizzas Deal!', 'Choose any two medium pizzas for a discounted price! Limited time only!', 'images/2medium.png', 'Deal', 0),
(20, 'Family Combo!', 'Try our family combo! 1 Large Pizza, Garlic Bread and 2 Drinks!', 'images/family-combo.png', 'Deal', 0),
(26, 'Cheese Pizza', 'Classic rich tomato sauce, topped with fresh mozzarella cheese.', 'images/cheese.png', 'Pizza', 0),
(27, 'Deluxe Pizza', 'Pepperoni, Italian sausage, fresh green peppers, mushrooms, onions, and mozzarella cheese.', 'images/deluxe.png', 'Pizza', 0),
(29, 'Philly Steak Pizza', 'Classic rich tomato sauce, topped with tender slices of steak, fresh onions, green peppers, mushrooms, and mozzarella cheese.', 'images/philly-steak.png', 'Pizza', 0),
(30, 'Four Seasons Pizza', 'Classic rich tomato sauce, topped with ham, olives, artichokes, green peppers, mushrooms, and mozzarella cheese.', 'images/4seasons.png', 'Pizza', 0),
(31, 'Porto Pizza', 'Classic rich tomato sauce, topped with Portuguese chorizo, roasted red peppers, olives, onions, and fresh mozzarella cheese.', 'images/porto.png', 'Pizza', 0),
(32, 'Super Pizza', 'Classic rich tomato sauce, pepperoni, bacon, mushrooms, green peppers, and fresh mozzarella cheese.', 'images/super.png', 'Pizza', 0),
(33, 'Bacon Pizza', 'Classic rich tomato sauce, topped with bacon and fresh mozzarella cheese.', 'images/bacon.png', 'Pizza', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_sizes`
--

CREATE TABLE `menu_item_sizes` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `size` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_sizes`
--

INSERT INTO `menu_item_sizes` (`id`, `menu_item_id`, `size`, `price`) VALUES
(1, 1, 'Small', 7.99),
(2, 1, 'Medium', 9.99),
(3, 1, 'Large', 12.99),
(4, 2, 'Small', 7.99),
(5, 2, 'Medium', 9.99),
(6, 2, 'Large', 12.99),
(10, 4, 'Small', 7.99),
(11, 4, 'Medium', 9.99),
(12, 4, 'Large', 12.99),
(13, 5, 'Small', 7.99),
(14, 5, 'Medium', 9.99),
(15, 5, 'Large', 12.99),
(16, 6, 'Small', 7.99),
(17, 6, 'Medium', 9.99),
(18, 6, 'Large', 12.99),
(19, 7, 'Small', 7.99),
(20, 7, 'Medium', 9.99),
(21, 7, 'Large', 12.99),
(22, 8, 'Small', 7.99),
(23, 8, 'Medium', 9.99),
(24, 8, 'Large', 12.99),
(25, 9, 'Small', 7.99),
(26, 9, 'Medium', 9.99),
(27, 9, 'Large', 12.99),
(28, 10, 'Small', 7.99),
(29, 10, 'Medium', 9.99),
(30, 10, 'Large', 12.99),
(31, 11, 'Small', 7.99),
(32, 11, 'Medium', 9.99),
(33, 11, 'Large', 12.99),
(34, 12, 'Small', 7.99),
(35, 12, 'Medium', 9.99),
(36, 12, 'Large', 12.99),
(37, 13, 'Small', 7.99),
(38, 13, 'Medium', 9.99),
(39, 13, 'Large', 12.99),
(40, 14, 'Small', 7.99),
(41, 14, 'Medium', 9.99),
(42, 14, 'Large', 12.99),
(43, 15, 'Regular', 4.99),
(44, 16, 'Regular', 5.99),
(45, 17, 'Can', 1.99),
(46, 18, 'Can', 1.99),
(47, 26, 'Small', 7.99),
(48, 26, 'Medium', 9.99),
(49, 26, 'Large', 12.99),
(50, 27, 'Small', 7.99),
(51, 27, 'Medium', 9.99),
(52, 27, 'Large', 12.99),
(55, 29, 'Small', 7.99),
(56, 29, 'Medium', 9.99),
(57, 29, 'Large', 12.99),
(58, 30, 'Small', 7.99),
(59, 30, 'Medium', 9.99),
(60, 30, 'Large', 12.99),
(61, 31, 'Small', 7.99),
(62, 31, 'Medium', 9.99),
(63, 31, 'Large', 12.99),
(64, 32, 'Small', 7.99),
(65, 32, 'Medium', 9.99),
(66, 32, 'Large', 12.99),
(67, 33, 'Small', 7.99),
(68, 33, 'Medium', 9.99),
(69, 33, 'Large', 12.99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `deal_discount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `deal_discount`, `tax`, `total`, `created_at`) VALUES
(11, 1, 9.99, 0.00, 1.30, 11.29, '2025-07-29 20:27:05'),
(13, 1, 19.98, 3.99, 2.08, 18.07, '2025-07-29 20:42:53'),
(14, 6, 9.99, 0.00, 1.30, 11.29, '2025-07-30 16:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `size` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `name`, `size`, `quantity`, `price`) VALUES
(6, 11, 'Nutella Pizza', 'Medium', 1, 9.99),
(8, 13, 'BLT Pizza', 'Medium', 2, 9.99),
(9, 14, '4 Cheese Pizza', 'Medium', 1, 9.99);

-- --------------------------------------------------------

--
-- Table structure for table `site_themes`
--

CREATE TABLE `site_themes` (
  `id` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_themes`
--

INSERT INTO `site_themes` (`id`, `theme`, `is_active`) VALUES
(1, 'spring', 1),
(2, 'summer', 0),
(3, 'winter', 0),
(4, 'fall', 0);

-- --------------------------------------------------------

--
-- Table structure for table `support_requests`
--

CREATE TABLE `support_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_requests`
--

INSERT INTO `support_requests` (`id`, `user_id`, `subject`, `message`, `created_at`, `response`) VALUES
(6, 1, 'test', 'test', '2025-07-29 20:30:59', 'test response');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(6, 'Alyssa', 'cabanaa@uwindsor.ca', '$2y$10$WlH7S2R8LyUav7ZTACg4VOMNPHvu9YgvpRes.QIv3WUYk9cb/JFr6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deals_menu_item` (`menu_item_id`);

--
-- Indexes for table `deal_requirements`
--
ALTER TABLE `deal_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deal_id` (`deal_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item_sizes`
--
ALTER TABLE `menu_item_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `site_themes`
--
ALTER TABLE `site_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_requests`
--
ALTER TABLE `support_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deal_requirements`
--
ALTER TABLE `deal_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `menu_item_sizes`
--
ALTER TABLE `menu_item_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_themes`
--
ALTER TABLE `site_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `support_requests`
--
ALTER TABLE `support_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `fk_deals_menu_item` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deal_requirements`
--
ALTER TABLE `deal_requirements`
  ADD CONSTRAINT `deal_requirements_ibfk_1` FOREIGN KEY (`deal_id`) REFERENCES `deals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_item_sizes`
--
ALTER TABLE `menu_item_sizes`
  ADD CONSTRAINT `fk_menu_item` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
