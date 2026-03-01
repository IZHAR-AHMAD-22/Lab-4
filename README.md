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

## Installation

1. Copy the `crud/` folder into `C:\laragon\www\`.
2. Start Laragon (Apache + MySQL).
3. Visit: `http://localhost/crud/INDEX.php`

## Changes & Updates

### ✅ Issues Fixed

| Issue | Fix Applied |
|-------|-------------|
| City showing `0` on update | Corrected `bind_param` types in `EDIT.php` (`"sssisi"`) |
| ID gap after delete | Added resequencing queries in `DELETE.php` |
| `AUTO_INCREMENT` jumping | Reset with `ALTER TABLE users AUTO_INCREMENT = 1` |
| Table already exists error | Used `CREATE TABLE IF NOT EXISTS` |

### 🔧 Features Added

- Actions column with Edit & Delete buttons in `VIEW.php`
- Success alerts after record add/update/delete
- City field included in form, table, and database
- ID resequencing after delete to remove gaps

## Video Tutorial

🎬 [https://www.loom.com/share/1a9f0b940ace40b4be58684e8dacdf4f](https://www.loom.com/share/1a9f0b940ace40b4be58684e8dacdf4f)

---

*Made with ❤️ by **Izhar Ahmad***
