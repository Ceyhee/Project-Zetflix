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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $foto = $_FILES['foto']['name'];

    // Periksa apakah ada file foto yang diunggah
    if ($foto) {
        $target_dir = "../uploads/img_user/";
        $target_file = $target_dir . basename($foto);
        
        // Pindahkan file foto yang diunggah ke direktori tujuan
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        // Perbarui data pengguna termasuk foto
        $sql = "UPDATE tb_user SET nama = ?, email = ?, tanggal_lahir = ?, alamat = ?, foto = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $email, $tanggal_lahir, $alamat, $foto, $user_id);
    } else {
        // Perbarui data pengguna tanpa mengubah foto
        $sql = "UPDATE tb_user SET nama = ?, email = ?, tanggal_lahir = ?, alamat = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $email, $tanggal_lahir, $alamat, $user_id);
    }

    // Eksekusi pernyataan SQL
    if ($stmt->execute()) {
        header('Location: user_profil.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil Pengguna</title>
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
            text-align: left;
        }

        form {
            text-align: left;
        }

        form label {
            margin-bottom: 10px;
            font-weight: bold;
            display: block;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="date"],
        form input[type="file"],
        form input[type="submit"],
        .back-button {
            margin-bottom: 20px;
            padding: 10px;
            width: calc(100% - 20px); /* Adjusted width to accommodate the padding */
            box-sizing: border-box;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        form input[type="submit"],
        .back-button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            text-decoration: none;
        }

        form input[type="submit"]:hover,
        .back-button:hover {
            background-color: #0056b3;
        }

        form input[type="file"] {
            padding: 5px;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="date"]:focus,
        form input[type="file"]:focus,
        .back-button:focus {
            border-color: #007bff;
            outline: none;
        }

        .back-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <h1>Edit Profil</h1>
        <form action="user_editprofil.php" method="post" enctype="multipart/form-data">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Tanggal Lahir:</label>
            <input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars($user['tanggal_lahir']); ?>" required>
            <label>Alamat:</label>
            <input type="text" name="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>" required>
            <label>Foto Profil:</label>
            <input type="file" name="foto">
            <input type="submit" name="update" value="Update">
        </form>
        <a href="../user/index.php" class="back-button"><i class="fas fa-chevron-left"></i> Back</a>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>


