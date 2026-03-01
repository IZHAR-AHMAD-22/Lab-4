<?php
require 'config.php';

$message = "";
$msgType = "success";
if (isset($_GET['deleted'])) { $message = "User deleted and IDs resequenced."; }
if (isset($_GET['updated'])) { $message = "User record updated successfully."; }
if (isset($_GET['added']))   { $message = "New user added successfully."; }

$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
$total  = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users | UserBase</title>
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
        .main { margin-left: 230px; flex: 1; padding: 44px 48px; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; gap: 16px; }
        .page-header h1 { font-size: 1.45rem; font-weight: 700; color: #f1f5f9; }
        .page-header p { font-size: 0.85rem; color: #64748b; margin-top: 5px; }
        .header-actions { display: flex; gap: 10px; align-items: center; }

        /* Stat pill */
        .stat-pill { background: rgba(45,212,191,0.08); border: 1px solid rgba(45,212,191,0.2); color: #2dd4bf; border-radius: 20px; padding: 5px 14px; font-size: 0.78rem; font-weight: 600; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 20px; border-radius: 8px; border: none; font-size: 0.83rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; transition: all 0.18s; }
        .btn-teal { background: #2dd4bf; color: #0f1117; }
        .btn-teal:hover { background: #14b8a6; }
        .btn-ghost { background: transparent; color: #64748b; border: 1px solid #1e2535; }
        .btn-ghost:hover { background: #1e2535; color: #94a3b8; }
        .btn-sm { padding: 6px 14px; font-size: 0.78rem; border-radius: 6px; }
        .btn-amber { background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2); }
        .btn-amber:hover { background: rgba(251,191,36,0.22); }
        .btn-red { background: rgba(248,113,113,0.1); color: #f87171; border: 1px solid rgba(248,113,113,0.2); }
        .btn-red:hover { background: rgba(248,113,113,0.2); }

        /* Alert */
        .alert { display: flex; align-items: center; gap: 12px; padding: 13px 18px; border-radius: 10px; margin-bottom: 26px; font-size: 0.85rem; font-weight: 500; }
        .alert-success { background: rgba(45,212,191,0.07); border: 1px solid rgba(45,212,191,0.22); color: #2dd4bf; }

        /* Table */
        .table-wrap { background: #161b27; border: 1px solid #1e2535; border-radius: 14px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1a2032; border-bottom: 1px solid #1e2535; }
        thead th { padding: 13px 18px; text-align: left; font-size: 0.72rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.07em; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #1a1f2e; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #1a2032; }
        tbody td { padding: 14px 18px; font-size: 0.875rem; color: #cbd5e1; }
        .id-cell { font-weight: 700; color: #2dd4bf; font-size: 0.8rem; }
        .name-cell { font-weight: 600; color: #f1f5f9; }
        .actions-cell { display: flex; gap: 8px; }
        .empty-row td { text-align: center; padding: 52px 18px; color: #4a5568; font-size: 0.9rem; }
        .empty-row a { color: #2dd4bf; text-decoration: none; }
        .empty-row a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">&#9670; UserBase</div>
        <div class="tagline">User Management System</div>
    </div>
    <nav>
        <a class="nav-link" href="home.php">&#43;&nbsp; Add User</a>
        <a class="nav-link active" href="users.php">&#9776;&nbsp; All Users</a>
    </nav>
    <div class="sidebar-footer">
        <strong>Izhar Ahmad</strong><br>
        PHP CRUD &mdash; <?= date('Y') ?>
    </div>
</aside>

<main class="main">
    <div class="page-header">
        <div>
            <h1>All Users</h1>
            <p>Manage and view all registered user records.</p>
        </div>
        <div class="header-actions">
            <span class="stat-pill"><?= $total ?> record<?= $total != 1 ? 's' : '' ?></span>
            <a href="home.php" class="btn btn-teal">&#43; Add User</a>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success">&#10003;&nbsp; <?= $message ?></div>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="id-cell">#<?= $row['id'] ?></td>
                        <td class="name-cell"><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td class="actions-cell">
                            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-amber">Edit</a>
                            <a href="remove.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-red"
                               onclick="return confirm('Delete this user permanently?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="7">No users found. <a href="home.php">Add the first one.</a></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
