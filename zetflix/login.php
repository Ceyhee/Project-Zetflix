<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna
    $sql_user = "SELECT * FROM tb_user WHERE email = ? AND password = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("ss", $email, $password);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user = $result_user->fetch_assoc();

    // Query untuk mendapatkan data admin
    $sql_admin = "SELECT * FROM tb_admin WHERE email = ? AND password = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("ss", $email, $password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    $admin = $result_admin->fetch_assoc();

    if ($user) {
        // Jika pengguna ditemukan
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['nama'];
        unset($_SESSION['is_admin']); // Pastikan is_admin dihapus untuk user biasa
        header("Location: index.php");
        exit();
    } elseif ($admin) {
        // Jika admin ditemukan
        $_SESSION['user_id'] = $admin['id_admin'];
        $_SESSION['user_name'] = $admin['nama'];
        $_SESSION['is_admin'] = true; // Set session is_admin untuk admin
        header("Location: admin_dashboard.php"); // Atur halaman dashboard admin
        exit();
    } else {
        // Jika tidak ditemukan
        $error = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Zetflix</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
