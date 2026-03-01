<?php
require 'config.php';

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age   = $_POST['age'];
    $city  = $_POST['city'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, age, city) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $email, $phone, $age, $city);
    $stmt->execute();
    $stmt->close();

    $success = "User record has been added successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User | UserBase</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f1117; color: #e2e8f0; min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar { width: 230px; min-height: 100vh; background: #161b27; border-right: 1px solid #1e2535; display: flex; flex-direction: column; padding: 28px 0; position: fixed; top: 0; left: 0; }
        .sidebar-brand { padding: 0 22px 24px; border-bottom: 1px solid #1e2535; }
        .sidebar-brand .logo { font-size: 1.2rem; font-weight: 700; color: #2dd4bf; letter-spacing: -0.3px; }
        .sidebar-brand .tagline { font-size: 0.7rem; color: #4a5568; margin-top: 4px; }
        .sidebar nav { padding: 18px 10px; display: flex; flex-direction: column; gap: 3px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 14px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 500; color: #94a3b8; transition: all 0.18s; }
        .nav-link:hover { background: #1e2535; color: #e2e8f0; }
        .nav-link.active { background: rgba(45,212,191,0.1); color: #2dd4bf; }
        .sidebar-footer { margin-top: auto; padding: 18px 22px 0; border-top: 1px solid #1e2535; font-size: 0.74rem; color: #4a5568; line-height: 1.7; }
        .sidebar-footer strong { color: #64748b; }

        /* Main */
        .main { margin-left: 230px; flex: 1; padding: 44px 48px; max-width: 820px; }
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 1.45rem; font-weight: 700; color: #f1f5f9; }
        .page-header p { font-size: 0.85rem; color: #64748b; margin-top: 5px; }

        /* Form card */
        .form-card { background: #161b27; border: 1px solid #1e2535; border-radius: 14px; padding: 34px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 7px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; }
        input { background: #0f1117; border: 1px solid #1e2535; border-radius: 8px; padding: 10px 14px; color: #e2e8f0; font-size: 0.875rem; font-family: inherit; transition: border-color 0.18s, box-shadow 0.18s; }
        input::placeholder { color: #2d3748; }
        input:focus { outline: none; border-color: #2dd4bf; box-shadow: 0 0 0 3px rgba(45,212,191,0.09); }
        .form-actions { display: flex; gap: 12px; margin-top: 26px; padding-top: 22px; border-top: 1px solid #1e2535; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 22px; border-radius: 8px; border: none; font-size: 0.85rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; transition: all 0.18s; }
        .btn-teal { background: #2dd4bf; color: #0f1117; }
        .btn-teal:hover { background: #14b8a6; }
        .btn-ghost { background: transparent; color: #64748b; border: 1px solid #1e2535; }
        .btn-ghost:hover { background: #1e2535; color: #94a3b8; }

        /* Alert */
        .alert { display: flex; align-items: center; gap: 12px; padding: 13px 18px; border-radius: 10px; margin-bottom: 26px; font-size: 0.85rem; font-weight: 500; }
        .alert-success { background: rgba(45,212,191,0.07); border: 1px solid rgba(45,212,191,0.22); color: #2dd4bf; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">&#9670; UserBase</div>
        <div class="tagline">User Management System</div>
    </div>
    <nav>
        <a class="nav-link active" href="home.php">&#43;&nbsp; Add User</a>
        <a class="nav-link" href="users.php">&#9776;&nbsp; All Users</a>
    </nav>
    <div class="sidebar-footer">
        <strong>Izhar Ahmad</strong><br>
        PHP CRUD &mdash; <?= date('Y') ?>
    </div>
</aside>

<main class="main">
    <div class="page-header">
        <h1>Add New User</h1>
        <p>Fill in the details below to register a new user record.</p>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success">&#10003;&nbsp; <?= $success ?>
    </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group full">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="e.g. Muhammad Ali" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="user@example.com" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="+92 300 0000000">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" placeholder="25" min="1" max="120">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="e.g. Lahore">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-teal">&#43; Save User</button>
                <a href="users.php" class="btn btn-ghost">View All Users</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
