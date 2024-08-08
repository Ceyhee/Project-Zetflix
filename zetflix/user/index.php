<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$sql = "SELECT * FROM tb_user WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$sql = "SELECT * FROM tb_user WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetflix - User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/zetflix/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: "SF Pro Display", "Arial", sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }

        .dashboard-item {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .dashboard-item:hover {
            transform: translateY(-5px);
        }

        .dashboard-item i {
            font-size: 36px;
            color: #333;
            margin-bottom: 10px;
        }

        .dashboard-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333333;
            margin-bottom: 10px;
        }

        .dashboard-item p {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }

        .navbar {
            width: 100%;
            margin-bottom: 40px;
        }

        .footer {
            width: 100%;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <p>This is your dashboard.</p>
        
        <div class="dashboard-container">
            <a href="user_profil.php" class="dashboard-item">
                <i class="fas fa-user"></i>
                <h3>Lihat Profil</h3>
                <p>Lihat detail profil Anda</p>
            </a>
            <a href="user_editprofil.php" class="dashboard-item">
                <i class="fas fa-edit"></i>
                <h3>Edit Profil</h3>
                <p>Perbarui informasi profil Anda</p>
            </a>
            <a href="user_updatefavoritfilm.php" class="dashboard-item">
                <i class="fas fa-heart"></i>
                <h3>Film Favorit</h3>
                <p>Daftar film favorit Anda</p>
            </a>
            <a href="user_infosewafilm.php" class="dashboard-item">
                <i class="fas fa-film"></i>
                <h3>Tonton Film</h3>
                <p>Lihat riwayat dan tonton penyewaan film mu</p>
            </a>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>

