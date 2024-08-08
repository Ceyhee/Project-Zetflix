<?php
session_start();
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
    <title>Profil Pengguna</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Google Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 i {
            margin-right: 10px;
            font-size: 1.5em;
        }

        .profil {
            text-align: left;
        }

        .profil img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profil p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
            font-weight: bold;
        }

        .profil p strong {
            color: #333;
        }

        .profil a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: bold;
        }

        .profil a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: bold;
        }

        .back-button:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
        <div class="profil">
            <img src="../uploads/img_foto_user/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Profil">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($user['nama']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Tanggal Lahir:</strong> <?php echo htmlspecialchars($user['tanggal_lahir']); ?></p>
            <p><strong>Alamat:</strong> <?php echo htmlspecialchars($user['alamat']); ?></p>
            <a href="user_editprofil.php">Edit Profil</a>
        </div>
        <a href="index.php" class="back-button">Kembali</a>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
