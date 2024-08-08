<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Sesuaikan dengan lokasi file CSS Anda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome untuk ikon -->
    <style>
        body {
            font-family: "SF Pro Display", "Arial", sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
        }
        h1 {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            color: #f2f2f2;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
        }
        a:hover {
            color: #fff;
            background-color: #333;
        }
        .btn-edit {
            background-color: #17a2b8;
            margin-right: 5px;
        }
        .btn-delete {
            background-color: #dc3545;
            margin-right: 5px;
        }
        .btn-home {
            background-color: #28a745;
            margin-right: 5px;
        }
        .btn-new-user {
            background-color: #007bff;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Pengguna</h1>
        <a href="index.php" class="btn-home"><i class="fas fa-home"></i> Dashboard</a> <!-- Tombol Beranda dengan ikon Font Awesome -->
        <a href="tambah_user.php" class="btn-new-user"><i class="fas fa-plus"></i> Tambah Pengguna Baru</a> <!-- Tombol Tambah Pengguna Baru dengan ikon Font Awesome -->
        <br><br>

        <?php
        include '../koneksi.php';

        if ($conn) {
            $sql = "SELECT * FROM tb_user";
            $result = $conn->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    // Tampilkan data pengguna
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Nama</th>";
                    echo "<th>Email</th>";
                    echo "<th>Tanggal Lahir</th>";
                    echo "<th>Alamat</th>";
                    echo "<th>Aksi</th>";
                    echo "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id_user']."</td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['tanggal_lahir']."</td>";
                        echo "<td>".$row['alamat']."</td>";
                        echo "<td>";
                        echo "<a href='edit_user.php?id=".$row['id_user']."' class='btn-edit'><i class='fas fa-edit'></i> Edit</a>";
                        echo "<a href='hapus_user.php?id=".$row['id_user']."' onclick=\"return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')\" class='btn-delete'><i class='fas fa-trash'></i> Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>Tidak ada data pengguna.</p>";
                }
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Koneksi ke basis data gagal.";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
