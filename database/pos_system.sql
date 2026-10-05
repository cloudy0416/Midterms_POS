CREATE DATABASE IF NOT EXISTS pos_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pos_system;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS sales;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    customer_id INT NULL,
    sold_by INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_sales_product FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT fk_sales_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
    CONSTRAINT fk_sales_user FOREIGN KEY (sold_by) REFERENCES users(id)
) ENGINE=InnoDB;

INSERT INTO customers (full_name, email, phone, created_at) VALUES
('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
('Maria Santos', 'maria@example.com', '09181234567', NOW()),
('Pedro Reyes', 'pedro@example.com', '09191234567', NOW());

INSERT INTO products (name, price, stock_quantity, image, created_at) VALUES
('Coffee', 85.00, 25, NULL, NOW()),
('Sandwich', 120.00, 15, NULL, NOW()),
('Bottled Water', 35.00, 30, NULL, NOW());
