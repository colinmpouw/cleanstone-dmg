-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 10 jun 2026 om 10:32
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cleanstone`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `addresses`
--

CREATE TABLE `addresses` (
                             `id` int(11) NOT NULL,
                             `user_id` int(11) NOT NULL,
                             `first_name` varchar(100) DEFAULT NULL,
                             `last_name` varchar(100) DEFAULT NULL,
                             `street` varchar(255) DEFAULT NULL,
                             `house_number` varchar(20) DEFAULT NULL,
                             `postal_code` varchar(20) DEFAULT NULL,
                             `city` varchar(100) DEFAULT NULL,
                             `country` varchar(100) DEFAULT NULL,
                             `phone` varchar(20) DEFAULT NULL,
                             `invoice_address` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `first_name`, `last_name`, `street`, `house_number`, `postal_code`, `city`, `country`, `phone`, `invoice_address`) VALUES
                                                                                                                                                                 (1, 1, 'Admin', 'User', 'Mainstraat', '1', '1234AB', 'Amsterdam', 'NL', '0611111111', 1),
                                                                                                                                                                 (2, 2, 'John', 'Doe', 'Teststraat', '12', '5678CD', 'Utrecht', 'NL', '0622222222', 1),
                                                                                                                                                                 (3, 3, 'Jane', 'Smith', 'Demoweg', '8', '9999ZZ', 'Rotterdam', 'NL', '0633333333', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blog`
--

CREATE TABLE `blog` (
                        `blog_id` int(11) NOT NULL,
                        `title` varchar(45) NOT NULL,
                        `article` text NOT NULL,
                        `arthor` varchar(45) NOT NULL,
                        `tag` varchar(45) NOT NULL,
                        `date` timestamp NOT NULL DEFAULT current_timestamp(),
                        `image` varchar(255) DEFAULT NULL,
                        `excerpt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `blog`
--

INSERT INTO `blog` (`blog_id`, `title`, `article`, `arthor`, `tag`, `date`, `image`, `excerpt`) VALUES
                                                                                                   (1, 'Clean Stone Tips', 'How to clean stone', 'Admin', 'clean', '2026-06-06 17:44:23', '/public/assets/schone_tegel.png', 'How to clean stone'),
                                                                                                   (2, 'Protect Stone', 'Tips for protection', 'Admin', 'protect', '2026-06-06 17:44:23', '/public/assets/schone_tegel.png', 'Tips for protection');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blogtags`
--

CREATE TABLE `blogtags` (
                            `id` int(11) NOT NULL,
                            `name` varchar(45) NOT NULL,
                            `display_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `blogtags`
--

INSERT INTO `blogtags` (`id`, `name`, `display_order`) VALUES
                                                          (1, 'Algemeen', 1),
                                                          (2, 'Buitenplaatsen', 2),
                                                          (3, 'Composiet', 3),
                                                          (4, 'Graniet', 4),
                                                          (5, 'Hardsteen', 5),
                                                          (6, 'Marmer', 6),
                                                          (7, 'Onze Merken', 7);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blog_blogtags`
--

CREATE TABLE `blog_blogtags` (
                                 `blog_id` int(11) NOT NULL,
                                 `blogtag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brands`
--

CREATE TABLE `brands` (
                          `id` int(11) NOT NULL,
                          `name` varchar(100) NOT NULL,
                          `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
                                                (1, 'Lithofin', NULL),
                                                (2, 'Akemi', NULL),
                                                (3, 'Bellinzoni', NULL),
                                                (4, 'Lantania', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bundles`
--

CREATE TABLE `bundles` (
                           `id` int(11) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `description` text DEFAULT NULL,
                           `price` decimal(10,2) NOT NULL,
                           `image` varchar(255) DEFAULT NULL,
                           `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bundles`
--

INSERT INTO `bundles` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
                                                                                        (1, 'Starter Kit', 'so good description', 49.99, NULL, '2026-06-06 17:44:23'),
                                                                                        (2, 'Pro Kit', NULL, 99.99, NULL, '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Stand-in structuur voor view `bundle_full_details`
-- (Zie onder voor de actuele view)
--
CREATE TABLE `bundle_full_details` (
                                       `id` int(11)
    ,`name` varchar(255)
    ,`description` text
    ,`price` decimal(10,2)
    ,`image` varchar(255)
    ,`created_at` timestamp
    ,`product_id` int(11)
    ,`product_name` varchar(255)
    ,`quantity` int(11)
    ,`product_price` decimal(10,2)
    ,`product_tag_id` int(11)
    ,`product_tag_name` varchar(100)
    ,`product_avg_rating` decimal(14,4)
    ,`bundle_tag` varchar(45)
);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bundle_products`
--

CREATE TABLE `bundle_products` (
                                   `id` int(11) NOT NULL,
                                   `bundle_id` int(11) NOT NULL,
                                   `product_id` int(11) NOT NULL,
                                   `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bundle_products`
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
-- Tabelstructuur voor tabel `bundle_tags`
--

CREATE TABLE `bundle_tags` (
                               `bundle_id` int(11) NOT NULL,
                               `tag` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bundle_tags`
--

INSERT INTO `bundle_tags` (`bundle_id`, `tag`) VALUES
    (1, 'so good');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cart_items`
--

CREATE TABLE `cart_items` (
                              `id` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `product_id` int(11) NOT NULL,
                              `quantity` int(11) DEFAULT 1,
                              `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
                                                                                       (4, 2, 1, 2, '2026-06-06 17:44:23'),
                                                                                       (5, 2, 5, 1, '2026-06-06 17:44:23'),
                                                                                       (6, 3, 10, 3, '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
                              `id` int(11) NOT NULL,
                              `parent_id` int(11) DEFAULT NULL,
                              `name` varchar(100) NOT NULL,
                              `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`) VALUES
                                                                 (1, NULL, 'Reinigen', 'reinigen'),
                                                                 (2, NULL, 'Beschermen', 'beschermen'),
                                                                 (3, NULL, 'Onderhoud', 'onderhoud'),
                                                                 (4, NULL, 'Toebehoren', 'toebehoren');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact_messages`
--

CREATE TABLE `contact_messages` (
                                    `id` int(11) NOT NULL,
                                    `name` varchar(100) DEFAULT NULL,
                                    `email` varchar(100) DEFAULT NULL,
                                    `subject` varchar(255) DEFAULT NULL,
                                    `message` text DEFAULT NULL,
                                    `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
    (1, 'Test User', 'test@test.com', 'Info', 'I need help', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
                          `id` int(11) NOT NULL,
                          `user_id` int(11) DEFAULT NULL,
                          `total_price` decimal(10,2) NOT NULL,
                          `status` enum('pending','paid','processing','shipped','completed','cancelled') DEFAULT 'pending',
                          `payment_method` varchar(50) DEFAULT NULL,
                          `shipping_address_id` int(11) DEFAULT NULL,
                          `created_at` timestamp NULL DEFAULT current_timestamp(),
                          `invoice_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address_id`, `created_at`, `invoice_address_id`) VALUES
                                                                                                                                                 (1, 2, 40.00, 'pending', 'ideal', 2, '2026-06-06 17:44:23', 2),
                                                                                                                                                 (2, 3, 75.00, 'paid', 'paypal', 3, '2026-06-06 17:44:23', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_items`
--

CREATE TABLE `order_items` (
                               `id` int(11) NOT NULL,
                               `order_id` int(11) NOT NULL,
                               `product_id` int(11) DEFAULT NULL,
                               `quantity` int(11) NOT NULL DEFAULT 1,
                               `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
                                                                                    (1, 1, 1, 2, 12.95),
                                                                                    (2, 1, 5, 1, 15.00),
                                                                                    (3, 2, 10, 3, 17.50);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
                            `id` int(11) NOT NULL,
                            `category_id` int(11) DEFAULT NULL,
                            `brand_id` int(11) DEFAULT NULL,
                            `name` varchar(255) NOT NULL,
                            `slug` varchar(255) DEFAULT NULL,
                            `sku` varchar(100) DEFAULT NULL,
                            `description` text DEFAULT NULL,
                            `short_description` text DEFAULT NULL,
                            `price` decimal(10,2) NOT NULL,
                            `sale_price` decimal(10,2) DEFAULT NULL,
                            `stock` int(11) DEFAULT 0,
                            `image` varchar(255) DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `sale_price`, `stock`, `image`, `created_at`) VALUES
                                                                                                                                                                               (1, 1, 1, 'Lithofin MN Clean 1L', 'p1', 'SKU001', 'Cleaner', 'Stone cleaner', 12.95, NULL, 50, 'lithofin-mn-allesreiniger.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (2, 1, 1, 'Lithofin MN Clean 5L', 'p2', 'SKU002', 'Cleaner bulk', 'Bulk', 62.00, 55.00, 20, 'lithofin-kf-intense-clean.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (3, 1, 1, 'Lithofin Vuiloplosser', 'p3', 'SKU003', 'Heavy cleaner', 'Strong', 12.40, NULL, 30, 'akemi-anti-drop.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (4, 1, 2, 'Akemi Crystal Spray', 'p4', 'SKU004', 'Spray', 'Easy spray', 15.00, NULL, 25, 'akemi-marble-protector.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (5, 2, 2, 'Akemi Triple Effect', 'p5', 'SKU005', '3 in 1', 'All in one', 19.50, NULL, 20, 'bellinzoni-idea-stone.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (6, 2, 2, 'Akemi Nano Protect', 'p6', 'SKU006', 'Protection', 'Nano', 27.00, NULL, 15, 'lantania-natural-stone-sealer.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (7, 2, 3, 'Bellinzoni Wax', 'p7', 'SKU007', 'Wax', 'Polish', 14.50, NULL, 20, 'lithofin-mn-allesreiniger.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (8, 2, 3, 'Bellinzoni Wax Large', 'p8', 'SKU008', 'Wax large', 'Polish', 20.50, NULL, 15, 'lithofin-kf-intense-clean.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (9, 1, 4, 'Lantania Cleaner', 'p9', 'SKU009', 'Cleaner', 'General', 17.00, NULL, 25, 'akemi-anti-drop.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (10, 2, 4, 'Lantania Protect', 'p10', 'SKU010', 'Protect', 'Surface', 22.00, NULL, 20, 'akemi-marble-protector.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (11, 1, 1, 'Cleaner X1', 'p11', 'SKU011', 'Cleaner', '-', 10.00, NULL, 40, 'bellinzoni-idea-stone.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (12, 1, 1, 'Cleaner X2', 'p12', 'SKU012', 'Cleaner', '-', 11.00, NULL, 35, 'lantania-natural-stone-sealer.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (13, 1, 1, 'Cleaner X3', 'p13', 'SKU013', 'Cleaner', '-', 12.00, NULL, 30, 'lithofin-mn-allesreiniger.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (14, 1, 1, 'Cleaner X4', 'p14', 'SKU014', 'Cleaner', '-', 13.00, NULL, 25, 'lithofin-kf-intense-clean.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (15, 1, 1, 'Cleaner X5', 'p15', 'SKU015', 'Cleaner', '-', 14.00, NULL, 20, 'akemi-anti-drop.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (16, 2, 2, 'Protector A', 'p16', 'SKU016', 'Protect', '-', 20.00, NULL, 25, 'akemi-marble-protector.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (17, 2, 2, 'Protector B', 'p17', 'SKU017', 'Protect', '-', 22.00, NULL, 20, 'bellinzoni-idea-stone.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (18, 2, 2, 'Protector C', 'p18', 'SKU018', 'Protect', '-', 25.00, NULL, 18, 'lantania-natural-stone-sealer.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (19, 3, 1, 'Maintenance A', 'p19', 'SKU019', 'Maintain', '-', 15.00, NULL, 40, 'lithofin-mn-allesreiniger.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (20, 3, 1, 'Maintenance B', 'p20', 'SKU020', 'Maintain', '-', 18.00, NULL, 30, 'lithofin-kf-intense-clean.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (21, 4, 1, 'Cloth', 'p21', 'SKU021', 'Accessory', '-', 5.00, NULL, 100, 'akemi-anti-drop.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (22, 4, 1, 'Brush', 'p22', 'SKU022', 'Accessory', '-', 8.00, NULL, 80, 'akemi-marble-protector.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (23, 4, 1, 'Sponge', 'p23', 'SKU023', 'Accessory', '-', 4.00, NULL, 90, 'bellinzoni-idea-stone.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (24, 3, 3, 'Stone Care Pro', 'p24', 'SKU024', 'Maintain', '-', 21.00, NULL, 20, 'lantania-natural-stone-sealer.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (25, 3, 3, 'Stone Shine', 'p25', 'SKU025', 'Maintain', '-', 24.00, NULL, 15, 'lithofin-mn-allesreiniger.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (26, 1, 4, 'Quick Cleaner', 'p26', 'SKU026', 'Cleaner', '-', 10.00, NULL, 50, 'lithofin-kf-intense-clean.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (27, 2, 4, 'Quick Protect', 'p27', 'SKU027', 'Protect', '-', 19.00, NULL, 25, 'akemi-anti-drop.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (28, 4, 3, 'Kit Small', 'p28', 'SKU028', 'Accessory', '-', 15.00, NULL, 35, 'akemi-marble-protector.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (29, 4, 3, 'Kit Large', 'p29', 'SKU029', 'Accessory', '-', 30.00, NULL, 20, 'bellinzoni-idea-stone.jpg', '2026-06-06 17:44:23'),
                                                                                                                                                                               (30, 1, 1, 'Ultimate Cleaner', 'p30', 'SKU030', 'Cleaner', '-', 18.00, NULL, 18, 'lantania-natural-stone-sealer.jpg', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_features`
--

CREATE TABLE `product_features` (
                                    `id` int(11) NOT NULL,
                                    `product_id` int(11) NOT NULL,
                                    `feature` varchar(255) NOT NULL,
                                    `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_features`
--

INSERT INTO `product_features` (`id`, `product_id`, `feature`, `display_order`) VALUES
                                                                                    (1, 1, 'pH-neutraal en veilig voor natuursteen', 1),
                                                                                    (2, 1, 'Geconcentreerd: 1 liter = 100 liter schoonmakwater', 2),
                                                                                    (3, 1, 'Geschikt voor alle steensoorten', 3),
                                                                                    (4, 1, 'Laat geen strepen of vlekken achter', 4),
                                                                                    (5, 1, 'Milieuvriendelijk en biologisch afbreekbaar', 5),
                                                                                    (6, 1, 'pH-neutraal en veilig voor natuursteen', 1),
                                                                                    (7, 1, 'Geconcentreerd: 1 liter = 100 liter schoonmakwater', 2),
                                                                                    (8, 1, 'Geschikt voor alle steensoorten', 3),
                                                                                    (9, 1, 'Laat geen strepen of vlekken achter', 4),
                                                                                    (10, 1, 'Milieuvriendelijk en biologisch afbreekbaar', 5),
                                                                                    (11, 1, 'pH-neutraal en veilig voor natuursteen', 1),
                                                                                    (12, 1, 'Geconcentreerd: 1 liter = 100 liter schoonmakwater', 2),
                                                                                    (13, 1, 'Geschikt voor alle steensoorten', 3),
                                                                                    (14, 1, 'Laat geen strepen of vlekken achter', 4),
                                                                                    (15, 1, 'Milieuvriendelijk en biologisch afbreekbaar', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_images`
--

CREATE TABLE `product_images` (
                                  `id` int(11) NOT NULL,
                                  `product_id` int(11) NOT NULL,
                                  `url` varchar(255) NOT NULL,
                                  `alt_text` varchar(255) DEFAULT NULL,
                                  `is_primary` tinyint(4) DEFAULT 0,
                                  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `alt_text`, `is_primary`, `image`) VALUES
                                                                                                (1, 1, '', NULL, 0, 'img1.jpg'),
                                                                                                (2, 2, '', NULL, 0, 'img2.jpg'),
                                                                                                (3, 3, '', NULL, 0, 'img3.jpg'),
                                                                                                (4, 4, '', NULL, 0, 'img4.jpg'),
                                                                                                (5, 1, 'lithofin-mn-allesreiniger.jpg', 'Lithofin MN Allesreiniger', 1, ''),
                                                                                                (6, 1, 'lithofin-kf-intense-clean.jpg', 'Lithofin KF Intense Clean', 0, ''),
                                                                                                (7, 2, 'akemi-anti-drop.jpg', 'Akemi Anti Drop', 1, ''),
                                                                                                (8, 3, 'akemi-marble-protector.pjg', 'Akemi Marble Protector', 1, ''),
                                                                                                (9, 4, 'bellinzoni-idea-stone.jpg', 'Bellinzoni Idea Stone', 1, ''),
                                                                                                (10, 5, 'lantania-natural-stone-sealer.jpg', 'Lantania Natural Stone Sealer', 1, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_instructions`
--

CREATE TABLE `product_instructions` (
                                        `id` int(11) NOT NULL,
                                        `product_id` int(11) NOT NULL,
                                        `step_number` int(11) NOT NULL,
                                        `instruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_instructions`
--

INSERT INTO `product_instructions` (`id`, `product_id`, `step_number`, `instruction`) VALUES
                                                                                          (1, 1, 1, 'Verdun 10ml reiniger in 1 liter water'),
                                                                                          (2, 1, 2, 'Breng aan met een vochtige doek of mop'),
                                                                                          (3, 1, 3, 'Laat kort inwerken en draag met schone doek'),
                                                                                          (4, 1, 4, 'Voor hardnekkige vlekken langer laten inwerken'),
                                                                                          (5, 1, 1, 'Verdun 10ml reiniger in 1 liter water'),
                                                                                          (6, 1, 2, 'Breng aan met een vochtige doek of mop'),
                                                                                          (7, 1, 3, 'Laat kort inwerken en draag met schone doek'),
                                                                                          (8, 1, 4, 'Voor hardnekkige vlekken langer laten inwerken');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_specifications`
--

CREATE TABLE `product_specifications` (
                                          `id` int(11) NOT NULL,
                                          `product_id` int(11) NOT NULL,
                                          `name` varchar(255) NOT NULL,
                                          `value` varchar(255) NOT NULL,
                                          `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `name`, `value`, `display_order`) VALUES
                                                                                                (1, 1, 'Inhoud', '1 liter', 1),
                                                                                                (2, 1, 'pH', '7-8 (neutraal)', 2),
                                                                                                (3, 1, 'Verdunning', '1:100', 3),
                                                                                                (4, 1, 'Toepassing', 'Alle natuursteensoorten', 4),
                                                                                                (5, 1, 'Inhoud', '1 liter', 1),
                                                                                                (6, 1, 'pH', '7-8 (neutraal)', 2),
                                                                                                (7, 1, 'Verdunning', '1:100', 3),
                                                                                                (8, 1, 'Toepassing', 'Alle natuursteensoorten', 4),
                                                                                                (9, 1, 'Inhoud', '1 liter', 1),
                                                                                                (10, 1, 'pH', '7-8 (neutraal)', 2),
                                                                                                (11, 1, 'Verdunning', '1:100', 3),
                                                                                                (12, 1, 'Toepassing', 'Alle natuursteensoorten', 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_tags`
--

CREATE TABLE `product_tags` (
                                `product_id` int(11) NOT NULL,
                                `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_tags`
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
-- Tabelstructuur voor tabel `reviews`
--

CREATE TABLE `reviews` (
                           `id` int(11) NOT NULL,
                           `user_id` int(11) DEFAULT NULL,
                           `product_id` int(11) DEFAULT NULL,
                           `rating` int(11) DEFAULT NULL,
                           `review` text DEFAULT NULL,
                           `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review`, `created_at`) VALUES
                                                                                            (1, 2, 1, 3, 'Very good product', '2026-06-06 17:44:23'),
                                                                                            (2, 3, 5, 4, 'Works well', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags`
--

CREATE TABLE `tags` (
                        `id` int(11) NOT NULL,
                        `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
                                      (4, 'accessory'),
                                      (1, 'cleaner'),
                                      (3, 'maintenance'),
                                      (2, 'protect');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `password_hash` varchar(255) NOT NULL,
                         `phone` varchar(20) DEFAULT NULL,
                         `role` enum('admin','customer') DEFAULT 'customer',
                         `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `phone`, `role`, `created_at`) VALUES
                                                                                                    (1, 'admin', 'admin@test.com', 'hash', '0611111111', 'admin', '2026-06-06 17:44:23'),
                                                                                                    (2, 'user1', 'user1@test.com', 'hash', '0622222222', 'customer', '2026-06-06 17:44:23'),
                                                                                                    (3, 'user2', 'user2@test.com', 'hash', '0633333333', 'customer', '2026-06-06 17:44:23');

-- --------------------------------------------------------

--
-- Structuur voor de view `bundle_full_details`
--
DROP TABLE IF EXISTS `bundle_full_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bundle_full_details`  AS SELECT `b`.`id` AS `id`, `b`.`name` AS `name`, `b`.`description` AS `description`, `b`.`price` AS `price`, `b`.`image` AS `image`, `b`.`created_at` AS `created_at`, `p`.`id` AS `product_id`, `p`.`name` AS `product_name`, `bp`.`quantity` AS `quantity`, `p`.`price` AS `product_price`, `t`.`id` AS `product_tag_id`, `t`.`name` AS `product_tag_name`, `r`.`avg_rating` AS `product_avg_rating`, `bt`.`tag` AS `bundle_tag` FROM ((((((`bundles` `b` left join `bundle_products` `bp` on(`b`.`id` = `bp`.`bundle_id`)) left join `products` `p` on(`bp`.`product_id` = `p`.`id`)) left join `product_tags` `pt` on(`p`.`id` = `pt`.`product_id`)) left join `tags` `t` on(`pt`.`tag_id` = `t`.`id`)) left join (select `reviews`.`product_id` AS `product_id`,avg(`reviews`.`rating`) AS `avg_rating` from `reviews` group by `reviews`.`product_id`) `r` on(`p`.`id` = `r`.`product_id`)) left join `bundle_tags` `bt` on(`b`.`id` = `bt`.`bundle_id`)) GROUP BY `b`.`id`, `b`.`name`, `b`.`description`, `b`.`price`, `b`.`image`, `b`.`created_at`, `p`.`id`, `p`.`name`, `bp`.`quantity`, `p`.`price`, `t`.`id`, `t`.`name`, `bt`.`tag`, `r`.`avg_rating` ;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `addresses`
--
ALTER TABLE `addresses`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `blog`
--
ALTER TABLE `blog`
    ADD PRIMARY KEY (`blog_id`);

--
-- Indexen voor tabel `blogtags`
--
ALTER TABLE `blogtags`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Indexen voor tabel `blog_blogtags`
--
ALTER TABLE `blog_blogtags`
    ADD PRIMARY KEY (`blog_id`, `blogtag_id`),
    ADD KEY `blogtag_id` (`blogtag_id`);

--
-- Indexen voor tabel `brands`
--
ALTER TABLE `brands`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bundles`
--
ALTER TABLE `bundles`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bundle_products`
--
ALTER TABLE `bundle_products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `bundle_id` (`bundle_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `bundle_tags`
--
ALTER TABLE `bundle_tags`
    ADD KEY `fk_bundels_tags_product_bundles1_idx` (`bundle_id`);

--
-- Indexen voor tabel `cart_items`
--
ALTER TABLE `cart_items`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexen voor tabel `contact_messages`
--
ALTER TABLE `contact_messages`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_address_id` (`shipping_address_id`),
  ADD KEY `fk_orders_addresses1_idx` (`invoice_address_id`);

--
-- Indexen voor tabel `order_items`
--
ALTER TABLE `order_items`
    ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexen voor tabel `product_features`
--
ALTER TABLE `product_features`
    ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `product_images`
--
ALTER TABLE `product_images`
    ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `product_instructions`
--
ALTER TABLE `product_instructions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `product_specifications`
--
ALTER TABLE `product_specifications`
    ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `product_tags`
--
ALTER TABLE `product_tags`
    ADD PRIMARY KEY (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexen voor tabel `reviews`
--
ALTER TABLE `reviews`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `tags`
--
ALTER TABLE `tags`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `addresses`
--
ALTER TABLE `addresses`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `blogtags`
--
ALTER TABLE `blogtags`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `brands`
--
ALTER TABLE `brands`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `bundles`
--
ALTER TABLE `bundles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `bundle_products`
--
ALTER TABLE `bundle_products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `cart_items`
--
ALTER TABLE `cart_items`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `contact_messages`
--
ALTER TABLE `contact_messages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `order_items`
--
ALTER TABLE `order_items`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT voor een tabel `product_features`
--
ALTER TABLE `product_features`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `product_images`
--
ALTER TABLE `product_images`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `product_instructions`
--
ALTER TABLE `product_instructions`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `product_specifications`
--
ALTER TABLE `product_specifications`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `reviews`
--
ALTER TABLE `reviews`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `tags`
--
ALTER TABLE `tags`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `blog_blogtags`
--
ALTER TABLE `blog_blogtags`
    ADD CONSTRAINT `blog_blogtags_blog_fk` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `blog_blogtags_blogtag_fk` FOREIGN KEY (`blogtag_id`) REFERENCES `blogtags` (`id`) ON DELETE CASCADE;

--

--
-- Beperkingen voor tabel `addresses`
--
ALTER TABLE `addresses`
    ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `bundle_products`
--
ALTER TABLE `bundle_products`
    ADD CONSTRAINT `bundle_products_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bundle_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `bundle_tags`
--
ALTER TABLE `bundle_tags`
    ADD CONSTRAINT `fk_bundels_tags_product_bundles1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`);

--
-- Beperkingen voor tabel `cart_items`
--
ALTER TABLE `cart_items`
    ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `categories`
--
ALTER TABLE `categories`
    ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
    ADD CONSTRAINT `fk_orders_addresses1` FOREIGN KEY (`invoice_address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `order_items`
--
ALTER TABLE `order_items`
    ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
    ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `product_features`
--
ALTER TABLE `product_features`
    ADD CONSTRAINT `product_features_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `product_images`
--
ALTER TABLE `product_images`
    ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `product_instructions`
--
ALTER TABLE `product_instructions`
    ADD CONSTRAINT `product_instructions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `product_specifications`
--
ALTER TABLE `product_specifications`
    ADD CONSTRAINT `product_specifications_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `product_tags`
--
ALTER TABLE `product_tags`
    ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `reviews`
--
ALTER TABLE `reviews`
    ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
