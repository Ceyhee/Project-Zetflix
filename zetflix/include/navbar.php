<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetflix</title>
    <link rel="stylesheet" type="text/css" href="/zetflix/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-brand">
        <a href="/zetflix/index.php">
            <img src="/zetflix/uploads/img_logo/circle.png" alt="Zetflix Logo" class="logo">
            <span class="brand-name">Zetflix</span>
        </a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
            <span class="admin-label"> Mode Administrator</span>
        <?php endif; ?>
    </div>
    <ul class="navbar-menu">
        <li><a href="/zetflix/index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="/zetflix/search.php"><i class="fas fa-search"></i> Search</a></li>
        <?php if (isset($_SESSION['user_role'])): ?>
            <?php if ($_SESSION['user_role'] == 'admin'): ?>
                <li><a href="/zetflix/admin/index.php"><i class="fas fa-user-cog"></i> Admin Panel</a></li>
            <?php else: ?>
                <li><a href="/zetflix/user/index.php"><i class="fas fa-user"></i> My Account</a></li>
            <?php endif; ?>
            <li><a href="/zetflix/user/user_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php else: ?>
            <li><a href="/zetflix/user/user_login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li><a href="/zetflix/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<style>
    .admin-label {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        color: red;
        font-size: 30px;
        font-weight: bold;
        margin-left: 10px;
    }
</style>
</body>
</html>
