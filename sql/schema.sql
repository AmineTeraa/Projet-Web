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
('AeroBook Pro 16', 1299.00, 'assets/img/laptop-2.jpg', 1),
('AeroBook Air 13', 749.00, 'assets/img/laptop-3.jpg', 1),
('VoltBook Studio 15', 1149.00, NULL, 1),
('VoltBook Studio 17', 1399.00, NULL, 1),
('PulseBook Edge 14', 899.00, NULL, 1),
('PulseBook Edge 15', 979.00, NULL, 1),
('NovaBook Lite 13', 649.00, NULL, 1),
('NovaBook Lite 15', 699.00, NULL, 1),
('TitanBook Max 17', 1599.00, NULL, 1),
('TitanBook Max 15', 1499.00, NULL, 1),
('ZenithBook Pro 14', 1099.00, NULL, 1),
('ZenithBook Pro 16', 1249.00, NULL, 1),
('OrbitBook Flex 13', 799.00, NULL, 1),
('OrbitBook Flex 15', 899.00, NULL, 1),
('SignalBook Go 14', 699.00, NULL, 1),
('SignalBook Go 15', 759.00, NULL, 1),
('CoreBook Prime 14', 999.00, NULL, 1),
('CoreBook Prime 16', 1199.00, NULL, 1),
('StrataBook X 15', 1349.00, NULL, 1),
('NovaPhone X', 799.00, 'assets/img/phone-1.jpg', 2),
('NovaPhone X Pro', 949.00, 'assets/img/phone-2.jpg', 2),
('NovaPhone Mini', 499.00, 'assets/img/phone-3.jpg', 2),
('AeroPhone S', 699.00, NULL, 2),
('AeroPhone S Plus', 799.00, NULL, 2),
('VoltPhone Edge', 629.00, NULL, 2),
('VoltPhone Edge Pro', 799.00, NULL, 2),
('PulsePhone Z', 699.00, NULL, 2),
('PulsePhone Z Mini', 549.00, NULL, 2),
('OrbitPhone 10', 679.00, NULL, 2),
('OrbitPhone 10 Pro', 849.00, NULL, 2),
('CorePhone One', 599.00, NULL, 2),
('CorePhone One Plus', 699.00, NULL, 2),
('SignalPhone 5G', 729.00, NULL, 2),
('SignalPhone 5G Pro', 899.00, NULL, 2),
('ZenithPhone A', 499.00, NULL, 2),
('ZenithPhone A Plus', 579.00, NULL, 2),
('TitanPhone Max', 999.00, NULL, 2),
('TitanPhone Mini', 459.00, NULL, 2),
('StrataPhone Neo', 639.00, NULL, 2),
('PulseBuds 2', 129.50, 'assets/img/acc-1.jpg', 3),
('PulseBuds 2 Pro', 179.00, NULL, 3),
('VoltCharger 65W', 49.00, NULL, 3),
('VoltCharger 100W', 69.00, NULL, 3),
('AeroMouse Pro', 59.00, NULL, 3),
('AeroKeyboard Slim', 89.00, NULL, 3),
('NovaCase Rugged', 39.00, NULL, 3),
('NovaCase Clear', 29.00, NULL, 3),
('OrbitDock USB-C', 79.00, NULL, 3),
('TitanBackpack', 119.00, NULL, 3);
