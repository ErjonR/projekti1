-- shopdb with sample data
CREATE DATABASE IF NOT EXISTS shopdb;
USE shopdb;

DROP TABLE IF EXISTS `sales`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `subcategories`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategory_id` (`subcategory_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `sale_date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* Insert sample admin user: admin@example.com / admin123  */
/* Password hash generated for 'admin123' */
INSERT INTO users (name, email, password, role) VALUES
('Super Admin', 'admin@example.com', '$2y$10$Wl7y./YtMUPoa1RkVhVpbeUpwTX7X7ej.z46dOx6YDcH6upzCFP7K', 'admin'),
('Test User', 'user@example.com', '$2y$10$Wl7y./YtMUPoa1RkVhVpbeUpwTX7X7ej.z46dOx6YDcH6upzCFP7K', 'user');

INSERT INTO categories (name, created_at) VALUES
('Veshje', UNIX_TIMESTAMP()),
('Kembet', UNIX_TIMESTAMP());

INSERT INTO subcategories (category_id, name, created_at) VALUES
(1, 'Duksa', UNIX_TIMESTAMP()),
(1, 'Kapuçë', UNIX_TIMESTAMP()),
(2, 'Atlete', UNIX_TIMESTAMP());

INSERT INTO products (subcategory_id, name, price, stock, created_at) VALUES
(1, 'Duksa e zeze', 2500, 10, UNIX_TIMESTAMP()),
(2, 'Kapuçë e bardhë', 1500, 5, UNIX_TIMESTAMP()),
(3, 'Atlete sportive', 3000, 8, UNIX_TIMESTAMP());

