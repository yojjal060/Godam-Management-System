# Inventory Management System

This project is a simple Inventory Management System built using HTML, CSS, and core PHP. The system allows users to manage products, sales, and suppliers. It includes functionalities such as user login, an admin dashboard, and CRUD operations for products and sales.

## Features

- User Authentication
- Admin Dashboard
- Manage Products
- Record and Manage Sales
- Manage Suppliers
- Simple and Clean UI

## Installation

1. **Clone the repository:**
    `sh
    git clone https://github.com/yojjal060/godam-management-system.git
    `
2. **Navigate to the project directory:**
    `sh
    cd godam-management-system
    `
3. **Set up your database:**
    - Import the inventory_system.sql file located in the  directory into your MySQL database. 

4. **Configure the database connection:**
    - Open includes/db.php and update the database connection details:
    `php
     = new mysqli('your_server', 'your_username', 'your_password', 'your_database');
    `

5. **Start the project:**
    - Run your local server (e.g., XAMPP, WAMP) and navigate to the project directory in your web browser.

## Usage

### User Login

1. **Navigate to the login page:**
    - Open your browser and go to http://localhost/godam-management-system/login.php.

2. **Log in with the following credentials:**
    - **Admin:**
        - Username: admin
        - password:
   

### Admin Dashboard

1. **After logging in as an admin, you can:**
    - Manage Products
    - Record and Manage Sales
    - Manage Suppliers

### Manage Products

- **Add New Product:**
    - Navigate to the 
Products section and fill out the form to add a new product.
- **Edit Product:**
    - Click the Edit link next to the product you wish to edit, make changes, and save.
- **Delete Product:**
    - Click the Delete link next to the product you wish to delete.

### Manage Sales

- **Record New Sale:**
    - Navigate to the Sales section and fill out the form to record a new sale.
- **Edit Sale:**
    - Click the Edit link next to the sale you wish to edit, make changes, and save.
- **Delete Sale:**
    - Click the Delete link next to the sale you wish to delete.



