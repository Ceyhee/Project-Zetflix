<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<footer class="footer">
    <div class="container">
        <?php if (!isset($_SESSION['user_role'])): ?>
            <p class="admin-link"><a href="/zetflix/admin/admin_login.php"><i class="fas fa-user-cog"></i> Admin Rooms</a></p>
        <?php endif; ?>
        <p>&copy; <?php echo date("Y"); ?> Zetflix. All rights reserved M.Aji Sukma.</p>
    </div>
</footer>
