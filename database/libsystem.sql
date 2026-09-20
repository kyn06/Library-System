-- ============================================================
-- Library System Database
-- Database Name: libsystem
-- Tables: users, books
-- ============================================================

CREATE DATABASE IF NOT EXISTS `libsystem`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE `libsystem`;

-- ------------------------------------------------------------
-- Table: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name`  VARCHAR(100) NOT NULL,
    `email`      VARCHAR(255) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `role`       ENUM('librarian', 'admin', 'super-admin') NOT NULL DEFAULT 'librarian',
    `status`     ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------
-- Table: books
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `books` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sku`            VARCHAR(50) NOT NULL UNIQUE,
    `title`          VARCHAR(255) NOT NULL,
    `author`         VARCHAR(255) NOT NULL,
    `genre`          VARCHAR(100) NOT NULL,
    `year_published` INT NOT NULL,
    `price`          DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `currency`       ENUM('PHP', 'USD', 'EUR') NOT NULL DEFAULT 'PHP',
    `stock`          INT NOT NULL DEFAULT 0,
    `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------
-- Seed Data
-- Default super-admin login:
--   Email:    admin@library.com
--   Password: admin123
-- ------------------------------------------------------------
INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `role`, `status`) VALUES
('System', 'Admin', 'admin@library.com', '$2y$10$f3v5HDMKrR6oZqG/z/4KsuJ89ZaZxNIrQQeBQjCyvYFWsBrkNLdbK', 'super-admin', 'active'),
('Juan', 'Dela Cruz', 'juan@library.com', '$2y$10$f3v5HDMKrR6oZqG/z/4KsuJ89ZaZxNIrQQeBQjCyvYFWsBrkNLdbK', 'librarian', 'active'),
('Maria', 'Santos', 'maria@library.com', '$2y$10$f3v5HDMKrR6oZqG/z/4KsuJ89ZaZxNIrQQeBQjCyvYFWsBrkNLdbK', 'admin', 'inactive');

INSERT INTO `books` (`sku`, `title`, `author`, `genre`, `year_published`, `price`, `currency`, `stock`) VALUES
('BK-001', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 1925, 12.99, 'USD', 5),
('BK-002', 'To Kill a Mockingbird', 'Harper Lee', 'Classic', 1960, 10.99, 'USD', 8),
('BK-003', '1984', 'George Orwell', 'Dystopian', 1949, 9.99, 'USD', 3),
('BK-004', 'Noli Me Tangere', 'Jose Rizal', 'Historical Fiction', 1887, 450.00, 'PHP', 10),
('BK-005', 'El Filibusterismo', 'Jose Rizal', 'Historical Fiction', 1891, 425.00, 'PHP', 6);