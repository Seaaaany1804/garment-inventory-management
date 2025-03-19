# Garment Inventory Management System

A web-based inventory management system for garment businesses. This application helps manage products, customers, orders, and inventory levels.

## Features

- User authentication with role-based access (Admin, Sales, Staff)
- Product management with categories
- Customer management
- Order processing with status tracking
- Inventory management
- Responsive design for all devices

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP (or any similar stack like WAMP, LAMP)
- Git

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/garment-inventory-management.git
cd garment-inventory-management
```

### 2. Set Up XAMPP

1. Download and install XAMPP from [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
2. Start the XAMPP Control Panel
3. Start the Apache and MySQL services

### 3. Database Setup

1. Open your web browser and navigate to `http://localhost/phpmyadmin`
2. Create a new database named `garment_inventory`
3. Import the database schema and initial data:
   - Select the `garment_inventory` database
   - Click on "Import" in the top menu
   - Select the file `database/garment_inventory.sql` from the project
   - Click "Go" to execute the import

### 4. Project Setup

1. Move or copy the cloned repository to the XAMPP htdocs directory:
   - Windows: `C:\xampp\htdocs\garment-inventory-management`
   - macOS: `/Applications/XAMPP/htdocs/garment-inventory-management`
   - Linux: `/opt/lampp/htdocs/garment-inventory-management`

2. Ensure the database connection settings in `includes/config/database.php` match your environment:
   ```php
   $host = 'localhost';
   $dbname = 'garment_inventory';
   $username = 'root'; // Default XAMPP MySQL username
   $password = ''; // Default XAMPP MySQL password (empty)
   ```

### 5. Run the Application

1. Open your web browser and navigate to:
   ```
   http://localhost/garment-inventory-management
   ```

2. Login with the default credentials:
   - Admin: 
     - Username: admin
     - Password: admin
   - Sales:
     - Username: sales
     - Password: sales
   - Staff:
     - Username: staff
     - Password: staff

## Security Notice

For production use, please change the default passwords and secure your database connection settings.

## License

[Add your license information here]

## Contact

[Add your contact information here]
