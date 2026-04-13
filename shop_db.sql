-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 06, 2026 at 11:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `line1` varchar(255) NOT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `label`, `recipient_name`, `phone`, `line1`, `ward`, `district`, `city`, `is_default`, `created_at`) VALUES
(1, 1, NULL, 'Admin', '24', '14', NULL, NULL, 'Việt Nam', 0, '2026-04-06 14:18:55'),
(2, 1, NULL, 'Admin', '123', '142', NULL, NULL, 'Việt Nam', 0, '2026-04-06 14:35:44'),
(3, 3, NULL, 'Hiển', '123', '123', NULL, NULL, 'Việt Nam', 0, '2026-04-06 14:38:59'),
(4, 1, NULL, 'Admin', '123', '213', NULL, NULL, 'Việt Nam', 0, '2026-04-06 14:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `status`, `created_at`) VALUES
(1, 1, 'active', '2026-04-06 14:18:43'),
(2, 3, 'active', '2026-04-06 14:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`) VALUES
(1, NULL, 'Điện thoại', 'Điện-thoại'),
(2, NULL, 'Laptop', 'laptop'),
(3, NULL, 'Đồng hồ thông minh', 'Đồng-hồ-thông-minh'),
(4, NULL, 'Máy tính bảng', 'máy-tính-bảng'),
(5, NULL, 'Phụ kiện', 'phụ-kiện');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `subtotal`, `shipping_fee`, `total`, `status`, `created_at`) VALUES
(1, 1, 1, 22500000.00, 0.00, 22500000.00, 'cancelled', '2026-04-06 14:18:55'),
(2, 1, 2, 29990000.00, 0.00, 29990000.00, 'cancelled', '2026-04-06 14:35:44'),
(3, 3, 3, 2140000.00, 0.00, 2140000.00, 'cancelled', '2026-04-06 14:38:59'),
(4, 1, 4, 550000.00, 0.00, 550000.00, 'cancelled', '2026-04-06 14:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 6, 1, 22500000.00),
(2, 2, 1, 29990000.00),
(3, 29, 1, 550000.00),
(3, 30, 1, 1590000.00),
(4, 29, 1, 550000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(50) NOT NULL,
  `provider_txn_id` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `amount` decimal(12,2) NOT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `provider_txn_id`, `status`, `amount`, `paid_at`) VALUES
(1, 1, 'COD', 'COD-1-1775459935', 'pending', 22500000.00, NULL),
(2, 2, 'COD', 'COD-2-1775460944', 'pending', 29990000.00, NULL),
(3, 3, 'COD', 'COD-3-1775461139', 'pending', 2140000.00, NULL),
(4, 4, 'COD', 'COD-4-1775461390', 'pending', 550000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `sku`, `price`, `stock`, `status`, `created_at`) VALUES
(2, 1, 'iPhone 15 Pro Max - Apple', 'PHO-APP-01', 29990000.00, 100, 'active', '2026-04-06 14:05:33'),
(3, 1, 'Galaxy S24 Ultra - Samsung', 'PHO-SAM-01', 31990000.00, 89, 'active', '2026-04-06 14:06:51'),
(4, 1, 'Xperia 1 V - Sony', 'PHO-SON-01', 27990000.00, 67, 'active', '2026-04-06 14:08:29'),
(5, 1, 'ROG Phone 8 - Asus', 'PHO-ASU-01', 25990000.00, 86, 'active', '2026-04-06 14:12:57'),
(6, 1, 'Xiaomi 14 Pro - Xiaomi', 'PHO-XIA-01', 22500000.00, 78, 'active', '2026-04-06 14:14:15'),
(7, 1, 'Galaxy Z Fold 5 - Samsung', 'PHO-SAM-02', 38990000.00, 100, 'active', '2026-04-06 14:15:00'),
(8, 2, 'MacBook Pro 16 M3 - Apple', 'LAP-APP-01', 59990000.00, 23, 'active', '2026-04-06 14:15:48'),
(9, 2, 'Galaxy Book 4 Pro - Samsung', 'LAP-SAM-01', 42990000.00, 45, 'active', '2026-04-06 14:16:25'),
(10, 2, 'Vaio Z Series - Sony', 'LAP-SON-01', 45000000.00, 57, 'active', '2026-04-06 14:17:35'),
(11, 2, 'XPS 15 9530 - Dell', 'LAP-DEL-01', 55990000.00, 78, 'active', '2026-04-06 14:18:13'),
(12, 2, 'ZenBook 14 OLED - Asus', 'LAP-ASU-01', 26500000.00, 67, 'active', '2026-04-06 14:20:31'),
(13, 2, 'RedmiBook Pro 15 - Xiaomi', 'LAP-XIA-01', 18990000.00, 78, 'active', '2026-04-06 14:21:01'),
(14, 3, 'Apple Watch Series 9 - Apple', 'SWA-APP-01', 10990000.00, 56, 'active', '2026-04-06 14:21:49'),
(15, 3, 'Galaxy Watch 6 Classic - Samsung', 'SWA-SAM-01', 8990000.00, 68, 'active', '2026-04-06 14:22:24'),
(16, 3, 'SmartWatch 3 - Sony', 'SWA-SON-01', 4990000.00, 78, 'active', '2026-04-06 14:23:22'),
(17, 3, 'Watch S3 - Xiaomi', 'SWA-XIA-01', 3990000.00, 48, 'active', '2026-04-06 14:23:55'),
(18, 3, 'VivoWatch 6 - Asus', 'SWA-ASU-01', 7500000.00, 78, 'active', '2026-04-06 14:24:26'),
(19, 3, 'Apple Watch Ultra 2 - Apple', 'SWA-APP-02', 21990000.00, 98, 'active', '2026-04-06 14:24:56'),
(20, 4, 'iPad Pro 11 inch M2 - Apple', 'TAB-APP-01', 23990000.00, 89, 'active', '2026-04-06 14:25:43'),
(21, 4, 'Galaxy Tab S9 Ultra - Samsung', 'TAB-SAM-01', 28990000.00, 92, 'active', '2026-04-06 14:26:19'),
(22, 4, 'Xperia Tablet Z4 - Sony', 'TAB-SON-01', 16500000.00, 64, 'active', '2026-04-06 14:27:10'),
(23, 4, 'Venue Pro 11 - Dell', 'TAB-DEL-01', 15990000.00, 78, 'active', '2026-04-06 14:27:45'),
(24, 4, 'ROG Flow Z13 - Asus', 'TAB-ASU-01', 39990000.00, 86, 'active', '2026-04-06 14:28:35'),
(25, 4, 'Pad 6 Max - Xiaomi', 'TAB-XIA-01', 12990000.00, 58, 'active', '2026-04-06 14:29:05'),
(26, 5, 'AirPods Pro 2 - Apple', 'ACC-APP-01', 6200000.00, 85, 'active', '2026-04-06 14:29:39'),
(27, 5, 'Sạc dự phòng 10000mAh - Samsung', 'ACC-SAM-01', 890000.00, 45, 'active', '2026-04-06 14:30:08'),
(28, 5, 'Tai nghe WH-1000XM5 - Sony', 'ACC-SON-01', 8490000.00, 100, 'active', '2026-04-06 14:30:44'),
(29, 5, 'Chuột không dây MS3320W - Dell', 'ACC-DEL-01', 550000.00, 89, 'active', '2026-04-06 14:31:16'),
(30, 5, 'Chuột gaming ROG Gladius - Asus', 'ACC-ASU-01', 1590000.00, 97, 'active', '2026-04-06 14:32:58'),
(31, 5, 'Củ sạc nhanh 67W - Xiaomi', 'ACC-XIA-01', 450000.00, 100, 'active', '2026-04-06 14:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(1024) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `sort_order`) VALUES
(2, 2, 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcQpT12WZc2xQm6Sc_6fmugjssT6cR6IKDn9AT7BlXW8P2_6EsgwP3RAFddL3Od4rnHKMomg-063XFmP6UIS2McEdUTIc6qiz9i9gOQHzahCrYdo4m1s5N1SLg', 0),
(3, 3, 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcTJjSZoYMEDlxkoRQ98HNBz6geukrE9rQhRJi0tDaHmzGZLt-6mvaMXNOY9qS-5egRjHw43ZyF6m_Pr_kG3A89uDInGgpaY', 0),
(4, 4, 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcTUNKIzsiltg93rUyYJx1g58QgD5wJtC2owIUD4j7hwX4M9jPyaTAMKm7ySrBDwG0hwxC38UgRu1uoxhWN0m29iUIvKJu_M', 0),
(5, 5, 'https://cdn.mobilecity.vn/mobilecity-vn/images/2024/01/asus-rog-phone-8-den.jpg.webp', 0),
(6, 6, 'https://cdn.tgdd.vn/Products/Images/42/307882/xiaomi-14-pro-600x600.jpg', 0),
(7, 7, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/a/samsung-z-fold5.png', 0),
(8, 8, 'https://iphonethanhnhan.vn/upload/product/macbook-pro-m3-xam-5554.jpeg', 0),
(9, 9, 'https://mac24h.vn/images/detailed/94/galaxy-book4-pro-16-inch-mac24h-1.jpeg', 0),
(10, 10, 'https://laptopgiasi.vn/wp-content/uploads/2024/02/Mua-Ban-Laptop-Sony-Vaio-VJS131C11N-Gia-Si-Sieu-Re-Moi-Cu-Core-i5-6200U-8GB-256GB-Intel-HD-Graphics-520-3.jpg', 0),
(11, 11, 'https://mac24h.vn/images/companies/1/Laptop%201/XPS%2015/99071CC3-E082-41F4-BDF5-EBBC54D03E4C.jpeg?1686894827530', 0),
(12, 12, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_29__9_22_1_2_2.png', 0),
(13, 13, 'https://sazo.vn/storage/products/redmi-book-15/3-2.png', 0),
(14, 14, 'https://halomobile.vn/wp-content/uploads/2021/10/watch-s9-den.png', 0),
(15, 15, 'https://cdn.tgdd.vn/Products/Images/7077/310858/samsung-galaxy-watch6-classic-47mm-bac-1-750x500.png', 0),
(16, 16, 'https://thuonggiado.vn/uploads/images/SanPham/dong-ho-thong-minh-sony-smartwatch-3-swr50-chinh-hang-1.webp', 0),
(17, 17, 'https://cdn.tgdd.vn/Products/Images/7077/321817/xiaomi-watch-s-3-den-2-1-750x500.jpg', 0),
(18, 18, 'https://dlcdnwebimgs.asus.com/gain/849b1639-7201-4d34-9540-eea1a4f9a687/', 0),
(19, 19, 'https://cdn.tgdd.vn/Products/Images/7077/329168/s16/t%C3%A1ch%20n%E1%BB%81n%20site%2016%20(3)-650x650.png', 0),
(20, 20, 'https://product.hstatic.net/1000259254/product/ipad_pro_m2_11_inch_wi-fi_space_gray-1_8eaea70029fc4c99b33e37954f4ac448_grande.jpg', 0),
(21, 21, 'https://bachlongstore.vn/vnt_upload/product/10_2023/thumbs/1000_97491.png', 0),
(22, 22, 'https://cdn.tgdd.vn/Products/Images/522/71098/sony-xperia-z4-tablet-300-nowatermark-300x300.jpg', 0),
(23, 23, 'https://minhhightech.com/admin/sanpham/Dell-Venue-11-Pro-6.jpg', 0),
(24, 24, 'https://dlcdnwebimgs.asus.com/files/media/2523515c-4a57-41a5-9004-67490621ae51/v1/images/large/1x/kv_z13_front.png', 0),
(25, 25, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEGEdTvGcUJz8rDxjGXFZwcThLYARNkgeW8w&s', 0),
(26, 26, 'https://cdn.tgdd.vn/Products/Images/54/315014/tai-nghe-bluetooth-airpods-pro-2nd-gen-usb-c-charge-apple-1-750x500.jpg', 0),
(27, 27, 'https://www.phukiensamsung.com/Uploads/pin-sac-du-phong-nhanh-25w-samsung-10000mah-chinh-hang.jpg', 0),
(28, 28, 'https://cdn.nguyenkimmall.com/images/detailed/807/10052478-tai-nghe-khong-day-sony-wh-1000xm5-bac-1.jpg', 0),
(29, 29, 'https://bizweb.dktcdn.net/thumb/1024x1024/100/329/122/products/chuot-khong-day-dell-ms3320w-06.jpg?v=1718599749553', 0),
(30, 30, 'https://product.hstatic.net/1000333506/product/h732_9fdf05198d4a4f3e92d6452c82fc5926__1__d28ff6961bf447e9b952dcc817cac756_grande.png', 0),
(31, 31, 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/9499/332324/bo-adapter-sac-67w-kem-cap-type-c-1m-xiaomi-hypercharge-trang-2-638677218325988704-750x500.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `full_name`, `phone`, `created_at`) VALUES
(1, 'admin@nanotech.com', '$2y$10$.vyb/vLSTOsCNuvXmM740eEuyDS9ykfEC/W9G7yeWZJ6wJtC4oIo6', 'Admin', '0123456789', '2026-04-05 15:41:12'),
(2, 'Test@mail.com', '$2y$10$2l/mqM0J.4YC46ME0Pb1OerUz8Gl99B6BgHOP3pYnC.NWsnk7Wh.e', 'Test', NULL, '2026-04-06 13:39:50'),
(3, 'Hien@gmail.com', '$2y$10$9rSSbictxkzWuI/q2xMI1OjSUIqJzlabu.y8MybMKgm3cZGYcoIMO', 'Hiển', NULL, '2026-04-06 14:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`, `created_at`) VALUES
(1, 1, '2026-04-05 15:41:12'),
(2, 2, '2026-04-06 13:39:50'),
(3, 2, '2026-04-06 14:38:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_addresses_user` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_carts_user` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_id`,`product_id`),
  ADD KEY `fk_cart_items_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_user` (`user_id`),
  ADD KEY `idx_orders_address` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_txn_id` (`provider_txn_id`),
  ADD KEY `idx_payments_order` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_products_category` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_images_product` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_roles_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
