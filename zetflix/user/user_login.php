<?php
session_start();
include '../koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tb_user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_role'] = 'user';
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        .login-form p {
            color: ;
        }
        .login-form button,
        .back-button {
            transition: transform 0.3s ease;
        }

        .login-form button:hover,
        .back-button:hover {
            transform: scale(1.05);
        }

        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            padding-left: 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'San Francisco', Arial, sans-serif;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #343a40;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            font-family: 'San Francisco', Arial, sans-serif;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #6c757d;

        }

        .back-button {
            margin-top: 20px;
            margin-bottom: 30px;
            background-color: #333;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            font-family: 'San Francisco', Arial, sans-serif;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: red;
        }

        .social-login-button {
            margin-top: 10px;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            font-family: 'San Francisco', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .social-login-button:hover {
            transform: scale(1.05);
        }

        .social-login-button.google {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .social-login-button.google:hover {
            background-color: red;
            color: #ddd;
        }

        .social-login-button.facebook {
            background-color: #3b5998; /* Facebook color */
        }

        .social-login-button.facebook:hover {
            background-color: blue;
            color: #ddd;
        }

        .social-login-button i {
            margin-right: 10px;
        }
        .divider {
            position: relative;
            margin: 20px 0;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            display: inline-block;
            padding: 0 10px;
            background-color: #fff;
            color: #888;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login User</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="input-container">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login">Masuk</button>
        </form>
        <div class="divider"><span>atau</span></div>
        <button class="social-login-button google">
            <i class="fab fa-google"></i> Login dengan Google
        </button>
        <button class="social-login-button facebook">
            <i class="fab fa-facebook-f"></i> Login dengan Facebook
        </button>
        <button class="back-button" onclick="history.back()">Kembali</button>

        <p>Belum punya akun?<a href="../register.php" class="register-btn">Daftar sekarang</a>

    </div>

</body>
</html>
