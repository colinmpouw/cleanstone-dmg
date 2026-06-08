-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2026-06-08 06:43:08
-- 服务器版本： 8.0.41
-- PHP 版本： 8.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cleanstone`
--

-- --------------------------------------------------------

--
-- 表的结构 `addresses`
--

CREATE TABLE `addresses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(20) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `invoice_address` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `first_name`, `last_name`, `street`, `house_number`, `postal_code`, `city`, `country`, `phone`, `invoice_address`) VALUES
(1, 1, 'Admin', 'User', 'Mainstraat', '1', '1234AB', 'Amsterdam', 'NL', '0611111111', 1),
(2, 2, 'John', 'Doe', 'Teststraat', '12', '5678CD', 'Utrecht', 'NL', '0622222222', 1),
(3, 3, 'Jane', 'Smith', 'Demoweg', '8', '9999ZZ', 'Rotterdam', 'NL', '0633333333', 1);

-- --------------------------------------------------------

--
-- 表的结构 `blog`
--

CREATE TABLE `blog` (
  `blog_id` int NOT NULL,
  `title` varchar(45) NOT NULL,
  `article` text NOT NULL,
  `arthor` varchar(45) NOT NULL,
  `tag` varchar(45) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `blog`
--

INSERT INTO `blog` (`blog_id`, `title`, `article`, `arthor`, `tag`, `date`) VALUES
(1, 'Clean Stone Tips', 'How to clean stone', 'Admin', 'clean', '2026-06-06 17:44:23'),
(2, 'Protect Stone', 'Tips for protection', 'Admin', 'protect', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
(1, 'Lithofin', NULL),
(2, 'Akemi', NULL),
(3, 'Bellinzoni', NULL),
(4, 'Lantania', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `bundles`
--

CREATE TABLE `bundles` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `bundles`
--

INSERT INTO `bundles` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Starter Kit', NULL, 49.99, NULL, '2026-06-06 17:44:23'),
(2, 'Pro Kit', NULL, 99.99, NULL, '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `bundle_products`
--

CREATE TABLE `bundle_products` (
  `id` int NOT NULL,
  `bundle_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `bundle_products`
--

INSERT INTO `bundle_products` (`id`, `bundle_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 1, 4, 1),
(3, 2, 1, 2),
(4, 2, 5, 2),
(5, 1, 1, 1),
(6, 1, 2, 2),
(7, 1, 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `bundle_tags`
--

CREATE TABLE `bundle_tags` (
  `bundle_id` int NOT NULL,
  `tag` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(4, 2, 1, 2, '2026-06-06 17:44:23'),
(5, 2, 5, 1, '2026-06-06 17:44:23'),
(6, 3, 10, 3, '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`) VALUES
(1, NULL, 'Reinigen', 'reinigen'),
(2, NULL, 'Beschermen', 'beschermen'),
(3, NULL, 'Onderhoud', 'onderhoud'),
(4, NULL, 'Toebehoren', 'toebehoren');

-- --------------------------------------------------------

--
-- 表的结构 `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Test User', 'test@test.com', 'Info', 'I need help', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','processing','shipped','completed','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_address_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address_id`, `created_at`, `invoice_address_id`) VALUES
(1, 2, 40.00, 'pending', 'ideal', 2, '2026-06-06 17:44:23', 2),
(2, 3, 75.00, 'paid', 'paypal', 3, '2026-06-06 17:44:23', 3);

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 12.95),
(2, 1, 5, 1, 15.00),
(3, 2, 10, 3, 17.50);

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `description` text,
  `short_description` text,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `sale_price`, `stock`, `image`, `created_at`) VALUES
(1, 1, 1, 'Lithofin MN Clean 1L', 'p1', 'SKU001', 'Cleaner', 'Stone cleaner', 12.95, NULL, 50, NULL, '2026-06-06 17:44:23'),
(2, 1, 1, 'Lithofin MN Clean 5L', 'p2', 'SKU002', 'Cleaner bulk', 'Bulk', 62.00, 55.00, 20, NULL, '2026-06-06 17:44:23'),
(3, 1, 1, 'Lithofin Vuiloplosser', 'p3', 'SKU003', 'Heavy cleaner', 'Strong', 12.40, NULL, 30, NULL, '2026-06-06 17:44:23'),
(4, 1, 2, 'Akemi Crystal Spray', 'p4', 'SKU004', 'Spray', 'Easy spray', 15.00, NULL, 25, NULL, '2026-06-06 17:44:23'),
(5, 2, 2, 'Akemi Triple Effect', 'p5', 'SKU005', '3 in 1', 'All in one', 19.50, NULL, 20, NULL, '2026-06-06 17:44:23'),
(6, 2, 2, 'Akemi Nano Protect', 'p6', 'SKU006', 'Protection', 'Nano', 27.00, NULL, 15, NULL, '2026-06-06 17:44:23'),
(7, 2, 3, 'Bellinzoni Wax', 'p7', 'SKU007', 'Wax', 'Polish', 14.50, NULL, 20, NULL, '2026-06-06 17:44:23'),
(8, 2, 3, 'Bellinzoni Wax Large', 'p8', 'SKU008', 'Wax large', 'Polish', 20.50, NULL, 15, NULL, '2026-06-06 17:44:23'),
(9, 1, 4, 'Lantania Cleaner', 'p9', 'SKU009', 'Cleaner', 'General', 17.00, NULL, 25, NULL, '2026-06-06 17:44:23'),
(10, 2, 4, 'Lantania Protect', 'p10', 'SKU010', 'Protect', 'Surface', 22.00, NULL, 20, NULL, '2026-06-06 17:44:23'),
(11, 1, 1, 'Cleaner X1', 'p11', 'SKU011', 'Cleaner', '-', 10.00, NULL, 40, NULL, '2026-06-06 17:44:23'),
(12, 1, 1, 'Cleaner X2', 'p12', 'SKU012', 'Cleaner', '-', 11.00, NULL, 35, NULL, '2026-06-06 17:44:23'),
(13, 1, 1, 'Cleaner X3', 'p13', 'SKU013', 'Cleaner', '-', 12.00, NULL, 30, NULL, '2026-06-06 17:44:23'),
(14, 1, 1, 'Cleaner X4', 'p14', 'SKU014', 'Cleaner', '-', 13.00, NULL, 25, NULL, '2026-06-06 17:44:23'),
(15, 1, 1, 'Cleaner X5', 'p15', 'SKU015', 'Cleaner', '-', 14.00, NULL, 20, NULL, '2026-06-06 17:44:23'),
(16, 2, 2, 'Protector A', 'p16', 'SKU016', 'Protect', '-', 20.00, NULL, 25, NULL, '2026-06-06 17:44:23'),
(17, 2, 2, 'Protector B', 'p17', 'SKU017', 'Protect', '-', 22.00, NULL, 20, NULL, '2026-06-06 17:44:23'),
(18, 2, 2, 'Protector C', 'p18', 'SKU018', 'Protect', '-', 25.00, NULL, 18, NULL, '2026-06-06 17:44:23'),
(19, 3, 1, 'Maintenance A', 'p19', 'SKU019', 'Maintain', '-', 15.00, NULL, 40, NULL, '2026-06-06 17:44:23'),
(20, 3, 1, 'Maintenance B', 'p20', 'SKU020', 'Maintain', '-', 18.00, NULL, 30, NULL, '2026-06-06 17:44:23'),
(21, 4, 1, 'Cloth', 'p21', 'SKU021', 'Accessory', '-', 5.00, NULL, 100, NULL, '2026-06-06 17:44:23'),
(22, 4, 1, 'Brush', 'p22', 'SKU022', 'Accessory', '-', 8.00, NULL, 80, NULL, '2026-06-06 17:44:23'),
(23, 4, 1, 'Sponge', 'p23', 'SKU023', 'Accessory', '-', 4.00, NULL, 90, NULL, '2026-06-06 17:44:23'),
(24, 3, 3, 'Stone Care Pro', 'p24', 'SKU024', 'Maintain', '-', 21.00, NULL, 20, NULL, '2026-06-06 17:44:23'),
(25, 3, 3, 'Stone Shine', 'p25', 'SKU025', 'Maintain', '-', 24.00, NULL, 15, NULL, '2026-06-06 17:44:23'),
(26, 1, 4, 'Quick Cleaner', 'p26', 'SKU026', 'Cleaner', '-', 10.00, NULL, 50, NULL, '2026-06-06 17:44:23'),
(27, 2, 4, 'Quick Protect', 'p27', 'SKU027', 'Protect', '-', 19.00, NULL, 25, NULL, '2026-06-06 17:44:23'),
(28, 4, 3, 'Kit Small', 'p28', 'SKU028', 'Accessory', '-', 15.00, NULL, 35, NULL, '2026-06-06 17:44:23'),
(29, 4, 3, 'Kit Large', 'p29', 'SKU029', 'Accessory', '-', 30.00, NULL, 20, NULL, '2026-06-06 17:44:23'),
(30, 1, 1, 'Ultimate Cleaner', 'p30', 'SKU030', 'Cleaner', '-', 18.00, NULL, 18, NULL, '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`) VALUES
(1, 1, 'img1.jpg'),
(2, 2, 'img2.jpg'),
(3, 3, 'img3.jpg'),
(4, 4, 'img4.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `product_tags`
--

CREATE TABLE `product_tags` (
  `product_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `product_tags`
--

INSERT INTO `product_tags` (`product_id`, `tag_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 2),
(6, 2),
(19, 3),
(20, 3),
(21, 4),
(22, 4);

-- --------------------------------------------------------

--
-- 表的结构 `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `review` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review`, `created_at`) VALUES
(1, 2, 1, 5, 'Very good product', '2026-06-06 17:44:23'),
(2, 3, 5, 4, 'Works well', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `tags`
--

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(4, 'accessory'),
(1, 'cleaner'),
(3, 'maintenance'),
(2, 'protect');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `phone`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@test.com', 'hash', '0611111111', 'admin', '2026-06-06 17:44:23'),
(2, 'user1', 'user1@test.com', 'hash', '0622222222', 'customer', '2026-06-06 17:44:23'),
(3, 'user2', 'user2@test.com', 'hash', '0633333333', 'customer', '2026-06-06 17:44:23');

--
-- 转储表的索引
--

--
-- 表的索引 `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 表的索引 `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- 表的索引 `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `bundle_products`
--
ALTER TABLE `bundle_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bundle_id` (`bundle_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `bundle_tags`
--
ALTER TABLE `bundle_tags`
  ADD KEY `fk_bundels_tags_product_bundles1_idx` (`bundle_id`);

--
-- 表的索引 `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- 表的索引 `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_address_id` (`shipping_address_id`),
  ADD KEY `fk_orders_addresses1_idx` (`invoice_address_id`);

--
-- 表的索引 `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- 表的索引 `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- 表的索引 `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `bundle_products`
--
ALTER TABLE `bundle_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- 使用表AUTO_INCREMENT `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 限制导出的表
--

--
-- 限制表 `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `bundle_products`
--
ALTER TABLE `bundle_products`
  ADD CONSTRAINT `bundle_products_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bundle_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `bundle_tags`
--
ALTER TABLE `bundle_tags`
  ADD CONSTRAINT `fk_bundels_tags_product_bundles1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`);

--
-- 限制表 `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_addresses1` FOREIGN KEY (`invoice_address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- 限制表 `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- 限制表 `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- 限制表 `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 限制表 `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- 限制表 `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
