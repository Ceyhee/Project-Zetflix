<?php
include '../koneksi.php';

// Mendapatkan id user dari parameter URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    
    // Query untuk mendapatkan data user berdasarkan id
    $sql = "SELECT * FROM tb_user WHERE id_user = $id_user";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Memasukkan data user ke dalam variabel $user
        $user = $result->fetch_assoc();
    } else {
        echo "User tidak ditemukan.";
        exit();
    }
} else {
    echo "ID user tidak ditemukan.";
    exit();
}

// Jika tombol 'Update' ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $alamat = $_POST["alamat"];

    // Query untuk update data user
    $sql = "UPDATE tb_user SET nama='$nama', email='$email', password='$password', tanggal_lahir='$tanggal_lahir', alamat='$alamat' WHERE id_user=$id_user";

    if ($conn->query($sql) === TRUE) {
        echo "Data user berhasil diperbarui.";
        header("Location: kelola_user.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel='stylesheet' type='text/css' href='style.css'> <!-- Sesuaikan dengan lokasi file CSS Anda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome untuk ikon -->
    <style>
        body {
            font-family: "SF Pro Display", "Arial", sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            font-family: "SF Pro Display", "Arial", sans-serif;
        }
        input[type="submit"] {
            background-color: green;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #686868;
        }
        a {
            color: red;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        a:hover {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <a href="../admin/index.php"><i class="fas fas fa-user-cog"></i> Admin Dashbord</a> <!-- Tombol Beranda dengan ikon Font Awesome -->
        <br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_user; ?>" method="post">
            <label><i class="fas fa-user"></i> Nama:</label>
            <input type="text" name="nama" value="<?php echo $user['nama']; ?>" required>
            <label><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <label><i class="fas fa-lock"></i> Password:</label>
            <input type="text" name="password" value="<?php echo str_repeat('*', strlen($user['password'])); ?>" readonly>
            <label><i class="fas fa-calendar-alt"></i> Tanggal Lahir:</label>
            <input type="date" name="tanggal_lahir" value="<?php echo $user['tanggal_lahir']; ?>" required>
            <label><i class="fas fa-map-marker-alt"></i> Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $user['alamat']; ?>" required>
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>

