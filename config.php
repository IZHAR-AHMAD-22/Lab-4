<?php
/**
 * PHP CRUD Application
 * Author: Izhar Ahmad
 * Database Connection & Table Setup
 */

$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "php_crud_db";

// Step 1: Connect WITHOUT selecting a database first
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Create the database if it doesn't exist yet
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`")) {
    die("Could not create database: " . $conn->error);
}

// Step 3: Select the database
$conn->select_db($dbname);

// Step 4: Create the users table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    age   INT,
    city  VARCHAR(100)
)");
?>
