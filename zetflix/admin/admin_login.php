<?php
session_start();
include '../koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tb_admin WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['user_id'] = $admin['id_admin'];
        $_SESSION['user_name'] = $admin['nama'];
        $_SESSION['user_role'] = 'admin';
        header('Location: index.php');
        exit();
    } else {
        $error = "Admin tidak terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=San+Francisco:wght@500&display=swap');

        body {
            font-family: 'San Francisco', Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        .login-form p {
            color: red;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color:  #333;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            font-family: 'San Francisco', Arial, sans-serif;
        }

        .login-form button:hover {
            background-color: #6c757d;
        }

        .back-button {
            margin-top: 20px;
            background-color: #6c757d;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            font-family: 'San Francisco', Arial, sans-serif;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <button class="back-button" onclick="history.back()">Kembali</button>
    </div>
</body>
</html>
