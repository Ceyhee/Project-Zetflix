<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    // Cek apakah email sudah ada
    $sql_check = "SELECT * FROM tb_user WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "Email already exists.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO tb_user (nama, email, password, tanggal_lahir, alamat) VALUES ('$nama', '$email', '$hashed_password', '$tanggal_lahir', '$alamat')";

        if ($conn->query($sql) === TRUE) {
            header('Location: user/user_login.php');
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
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

        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            transition: border-color 0.3s ease;
        }

        .input-container input:focus {
            border-color: #007bff; /* Warna border saat input mendapatkan fokus */
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            font-family: 'Roboto', sans-serif;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #6c757d; /* Warna tombol saat dihover */
        }

        .login-link {
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #0056b3; /* Warna link saat dihover */
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
            margin-bottom: 20px;
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

/* Animasi fadeIn */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}


/* Animasi fadeIn */
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
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="input-container">
                <input type="text" name="nama" placeholder="Nama" required>
            </div>
            <div class="input-container">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-container">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <div class="input-container">
                <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" required>
            </div>
            <div class="input-container">
                <input type="text" name="alamat" placeholder="Alamat" required>
            </div>
            <button type="submit">Daftar</button>
        </form>

        <div class="divider"><span>atau</span></div>
        <button class="social-login-button google">
            <i class="fab fa-google"></i> Daftar dengan Google
        </button>
        <button class="social-login-button facebook">
            <i class="fab fa-facebook-f"></i> Daftar dengan Facebook
        </button>
        <p>Sudah punya akun ? <a href="user/user_login.php" class = "register-btn" class="fas fa-user">login disini</a>
    </div>
</body>
</html>


