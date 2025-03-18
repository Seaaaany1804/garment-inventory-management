-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS garment_inventory;
USE garment_inventory;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'sales', 'staff') NOT NULL,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    price DECIMAL(10, 2) NOT NULL,
    cost_price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    min_stock_level INT DEFAULT 10,
    size VARCHAR(20),
    color VARCHAR(30),
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Customers table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    customer_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Inventory transactions
CREATE TABLE IF NOT EXISTS inventory_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    transaction_type ENUM('purchase', 'sale', 'return', 'adjustment') NOT NULL,
    reference_id INT,
    reference_type VARCHAR(50),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Activity log
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert initial admin user (password: admin123)
INSERT INTO users (username, password, full_name, role)
VALUES ('admin1234', 'admin1234', 'Admin User', 'admin');

-- Insert initial sales user (password: sales123)
INSERT INTO users (username, password, full_name, role)
VALUES ('sales1234', 'sales1234', 'Sales User', 'sales');

-- Insert initial staff user (password: staff123)
INSERT INTO users (username, password, full_name, role)
VALUES ('staff1234', 'staff1234', 'Staff User', 'staff');

-- Insert sample categories
INSERT INTO categories (name) VALUES 
('T-Shirts'),
('Jeans'),
('Dresses'),
('Outerwear'),
('Accessories');

-- Insert sample products
INSERT INTO products (sku, name, category_id, price, cost_price, stock_quantity, size, color, status)
VALUES 
('TS-001', 'Basic Cotton T-Shirt', 1, 19.99, 8.50, 250, 'M', 'Black', 1),
('TS-002', 'V-Neck T-Shirt', 1, 24.99, 10.75, 175, 'L', 'White', 1),
('JN-001', 'Slim Fit Jeans', 2, 49.99, 22.50, 120, '32', 'Blue', 1),
('JN-002', 'Relaxed Fit Denim', 2, 45.99, 19.75, 85, '34', 'Dark Blue', 1),
('DR-001', 'Summer Dress', 3, 39.99, 17.25, 65, 'S', 'Floral', 1),
('OW-001', 'Winter Jacket', 4, 89.99, 42.50, 45, 'XL', 'Black', 1),
('OW-002', 'Cotton Hoodie', 4, 39.99, 15.75, 78, 'M', 'Gray', 1),
('AC-001', 'Knit Beanie', 5, 14.99, 5.25, 95, 'One Size', 'Black', 1);

-- Insert sample customers
INSERT INTO customers (name, phone, address)
VALUES 
('John Smith', '555-123-4567', '123 Main St, Boston, MA 02108'),
('Emma Johnson', '555-234-5678', '456 Oak Ave, New York, NY 10001'),
('Michael Brown', '555-345-6789', '789 Pine Blvd, Chicago, IL 60601'),
('Sarah Wilson', '555-456-7890', '321 Elm St, San Francisco, CA 94105'); 