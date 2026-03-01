# PHP CRUD Application
> **Author:** Izhar Ahmad

A simple CRUD (Create, Read, Update, Delete) web application built with PHP and MySQL.

## Features

- ✅ View all users in a styled table
- ➕ Add new user via form
- ✏️ Edit existing user
- 🗑️ Delete user
- 🔢 Auto ID resequencing after delete
- 🏙️ City field support

## Technologies Used

- PHP (MySQLi with prepared statements)
- MySQL
- HTML & CSS (no frameworks)
- Laragon (Local Server)

## Folder Structure

```
crud/
├── DB.php        # Database connection and table setup
├── INDEX.php     # Add new user form
├── VIEW.php      # Display all users with Edit & Delete actions
├── EDIT.php      # Edit/update user
├── DELETE.php    # Delete user and resequence IDs
└── README.md     # This file
```

## Database Setup

1. Open **Laragon** and start Apache and MySQL.
2. Open **HeidiSQL** (or phpMyAdmin) from Laragon.
3. Connect to `Laragon.MySQL`.
4. Open a query tab and run:

```sql
CREATE DATABASE php_crud_db;
USE php_crud_db;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    age INT,
    city VARCHAR(100)
);
```
*Made with ❤️ by **Izhar Ahmad***
