<?php
include '../koneksi.php';

// Mendapatkan id sewa dari parameter URL
if (isset($_GET['id'])) {
    $id_sewa = $_GET['id'];

    // Query untuk mendapatkan data sewa berdasarkan id
    $sql = "SELECT * FROM tb_sewafilm WHERE id_sewa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_sewa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Memasukkan data sewa ke dalam variabel $sewa
        $sewa = $result->fetch_assoc();
    } else {
        echo "Sewa tidak ditemukan.";
        exit();
    }
} else {
    echo "ID sewa tidak ditemukan.";
    exit();
}

// Jika tombol 'Update' ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_user = $_POST["id_user"];
    $id_film = $_POST["id_film"];
    $tanggal_sewa = $_POST["tanggal_sewa"];
    $tanggal_kembali = $_POST["tanggal_kembali"];

    // Query untuk update data sewa
    $sql = "UPDATE tb_sewafilm SET id_user=?, id_film=?, tanggal_sewa=?, tanggal_kembali=? WHERE id_sewa=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $id_user, $id_film, $tanggal_sewa, $tanggal_kembali, $id_sewa);
    if ($stmt->execute()) {
        echo "Data sewa berhasil diperbarui.";
        header("Location: kelola_sewafilm.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Sewa Film User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px; /* Ukuran font lebih besar */
        }

        form {
            max-width: 800px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold; /* Teks tombol jadi bold */
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333; /* Warna teks hitam */
            font-weight: bold; /* Teks beranda jadi bold */
            font-size: 18px; /* Ukuran font beranda */
        }

        a:hover {
            color: #555; /* Warna teks abu-abu gelap saat dihover */
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Sewa Film</h2>
    <a href="index.php" class="font-awesome">Beranda</a>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_sewa; ?>" method="post">
        <label>ID User:</label>
        <input type="text" name="id_user" value="<?php echo $sewa['id_user']; ?>" readonly><br>
        <label>ID Film:</label>
        <input type="text" name="id_film" value="<?php echo $sewa['id_film']; ?>" readonly><br>
        <label>Tanggal Sewa:</label>
        <input type="date" name="tanggal_sewa" value="<?php echo $sewa['tanggal_sewa']; ?>" required><br>
        <label>Tanggal Kembali:</label>
        <input type="date" name="tanggal_kembali" value="<?php echo $sewa['tanggal_kembali']; ?>" required><br>
        <input type="submit" name="update" value="Update">
    </form>
</div>
</body>
</html>
