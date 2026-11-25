CREATE DATABASE IF NOT EXISTS db_shopease;
USE db_shopease;

CREATE TABLE IF NOT EXISTS categories (
  id_category INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(100) NOT NULL,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  description TEXT,
  created_at  DATETIME NULL,
  updated_at  DATETIME NULL
);

CREATE TABLE IF NOT EXISTS products (
  id_product  INT AUTO_INCREMENT PRIMARY KEY,
  id_category INT NOT NULL,
  name        VARCHAR(150) NOT NULL,
  slug        VARCHAR(180) NOT NULL UNIQUE,
  description TEXT,
  price       DECIMAL(12,2) NOT NULL DEFAULT 0,
  stock       INT NOT NULL DEFAULT 0,
  status      ENUM('tersedia','tidak_tersedia') NOT NULL DEFAULT 'tersedia',
  created_at  DATETIME NULL,
  updated_at  DATETIME NULL,
  CONSTRAINT fk_product_category FOREIGN KEY (id_category)
    REFERENCES categories(id_category) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS product_images (
  id_image   INT AUTO_INCREMENT PRIMARY KEY,
  id_product INT NOT NULL,
  image      VARCHAR(255) NOT NULL,
  is_primary TINYINT(1) DEFAULT 0,
  created_at DATETIME NULL,
  CONSTRAINT fk_image_product FOREIGN KEY (id_product)
    REFERENCES products(id_product) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO categories (name, slug, description) VALUES
('Fashion', 'fashion', 'Produk fashion'),
('Elektronik', 'elektronik', 'Produk elektronik'),
('Olahraga', 'olahraga', 'Perlengkapan olahraga');

INSERT INTO products (id_category, name, slug, description, price, stock, status) VALUES
(1, 'Sepatu Sneakers', 'sepatu-sneakers', 'Sepatu casual', 299000, 15, 'tersedia'),
(2, 'Headphone Bluetooth', 'headphone-bluetooth', 'Headphone wireless', 350000, 10, 'tersedia');
