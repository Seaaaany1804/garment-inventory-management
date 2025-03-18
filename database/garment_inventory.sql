-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS garment_inventory;
USE garment_inventory;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'sales', 'staff') NOT NULL,
    status TINYINT(1) DEFAULT 1,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Product categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category_id INT,
    price DECIMAL(10, 2) NOT NULL,
    cost_price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    min_stock_level INT DEFAULT 10,
    size VARCHAR(20),
    color VARCHAR(30),
    image_url VARCHAR(255),
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Customers table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    postal_code VARCHAR(20),
    country VARCHAR(50) DEFAULT 'USA',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    customer_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_address TEXT,
    shipping_city VARCHAR(50),
    shipping_state VARCHAR(50),
    shipping_postal_code VARCHAR(20),
    shipping_country VARCHAR(50) DEFAULT 'USA',
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    discount DECIMAL(10, 2) DEFAULT 0,
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
    notes TEXT,
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
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert initial admin user (password: admin123)
INSERT INTO users (username, password, full_name, email, role)
VALUES ('admin', '$2y$10$KFo6YzMdnRnGs7DSWPBzROPAj69oWb.zbKEZZzQOL67XoglyN.1Z.', 'Admin User', 'admin@example.com', 'admin');

-- Insert initial sales user (password: sales123)
INSERT INTO users (username, password, full_name, email, role)
VALUES ('sales', '$2y$10$TqRyaWBbRnKYWf8YPMnMuOeKQpVZWPCGj5q.qjM4X9KVmGn1wTHN.', 'Sales User', 'sales@example.com', 'sales');

-- Insert initial staff user (password: staff123)
INSERT INTO users (username, password, full_name, email, role)
VALUES ('staff', '$2y$10$LHPLXE34SaToBbq2k/JGm.DRlkTvBCs6hULss7SdjijW0QM5dprm2', 'Staff User', 'staff@example.com', 'staff');

-- Insert sample categories
INSERT INTO categories (name, description) VALUES 
('T-Shirts', 'All types of t-shirts'),
('Jeans', 'Denim pants and shorts'),
('Dresses', 'All types of dresses'),
('Outerwear', 'Jackets, coats, and hoodies'),
('Accessories', 'Hats, scarves, and other accessories');

-- Insert sample products
INSERT INTO products (sku, name, description, category_id, price, cost_price, stock_quantity, size, color, status)
VALUES 
('TS-001', 'Basic Cotton T-Shirt', 'Comfortable cotton t-shirt for everyday wear', 1, 19.99, 8.50, 250, 'M', 'Black', 1),
('TS-002', 'V-Neck T-Shirt', 'Stylish v-neck t-shirt', 1, 24.99, 10.75, 175, 'L', 'White', 1),
('JN-001', 'Slim Fit Jeans', 'Modern slim fit denim jeans', 2, 49.99, 22.50, 120, '32', 'Blue', 1),
('JN-002', 'Relaxed Fit Denim', 'Comfortable relaxed fit jeans', 2, 45.99, 19.75, 85, '34', 'Dark Blue', 1),
('DR-001', 'Summer Dress', 'Light and flowy summer dress', 3, 39.99, 17.25, 65, 'S', 'Floral', 1),
('OW-001', 'Winter Jacket', 'Warm winter jacket with hood', 4, 89.99, 42.50, 45, 'XL', 'Black', 1),
('OW-002', 'Cotton Hoodie', 'Comfortable cotton hoodie for casual wear', 4, 39.99, 15.75, 78, 'M', 'Gray', 1),
('AC-001', 'Knit Beanie', 'Warm knit beanie for winter', 5, 14.99, 5.25, 95, 'One Size', 'Black', 1);

-- Insert sample customers
INSERT INTO customers (name, email, phone, address, city, state, postal_code)
VALUES 
('John Smith', 'john@example.com', '555-123-4567', '123 Main St', 'Boston', 'MA', '02108'),
('Emma Johnson', 'emma@example.com', '555-234-5678', '456 Oak Ave', 'New York', 'NY', '10001'),
('Michael Brown', 'michael@example.com', '555-345-6789', '789 Pine Blvd', 'Chicago', 'IL', '60601'),
('Sarah Wilson', 'sarah@example.com', '555-456-7890', '321 Elm St', 'San Francisco', 'CA', '94105'); 