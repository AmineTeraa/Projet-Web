CREATE DATABASE IF NOT EXISTS mini_shop;
USE mini_shop;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  category_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name) VALUES
('Laptops'),
('Phones'),
('Accessories');

INSERT INTO products (name, price, image_url, category_id) VALUES
('AeroBook Pro 14', 999.99, 'assets/img/laptop-1.jpg', 1),
('NovaPhone X', 799.00, 'assets/img/phone-1.jpg', 2),
('PulseBuds 2', 129.50, 'assets/img/acc-1.jpg', 3),
('AeroBook Air 13', 749.00, 'assets/img/laptop-2.jpg', 1),
('NovaPhone Mini', 499.00, 'assets/img/phone-2.jpg', 2);
