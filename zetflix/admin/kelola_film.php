<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Film</title>
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
            max-width: 1800px;
            margin: 20px auto; /* Menambahkan margin atas dan bawah */
            padding: 20px;
            background-color: #fff; /* Memberi latar belakang putih */
            border-radius: 10px; /* Memberi border-radius */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan */
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
            background-color: #f2f2f2;
        }
        a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #333; /* Mengubah warna saat dihover */
        }
        .btn {
            padding: 10px 20px; /* Menyesuaikan padding tombol */
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn:hover {
            color: #f2f2f2;
            background-color: #333;
            filter: brightness(100%); /* Mengurangi kecerahan saat dihover */
        }
        .btn-home {
            background-color: #28a745; /* Warna hijau */
            color: #fff; /* Warna putih */
        }
        .btn-add {
            background-color: #007bff; /* Warna biru */
            color: #fff; /* Warna putih */
        }
        .btn-edit {
            background-color: #007bff; /* Warna biru */
            color: #fff; /* Warna putih */
            margin-right: -0px;
            display: block;

        }
        .btn-delete {
            background-color: #dc3545; /* Warna merah */
            color: #fff; /* Warna putih */
            display: block;
            
        }
        .btn i {
            margin-right: 5px; /* Menambahkan jarak antara ikon dan teks */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Film</h1>
        <a href="index.php" class="btn btn-home"><i class="fas fa-home"></i> Dashboard</a> <!-- Tombol Beranda dengan ikon Font Awesome -->
        <a href='tambah_film.php' class='btn btn-add'><i class='fas fa-plus'></i> Tambah Film Baru</a> <!-- Tombol Tambah Film -->
        <br><br>

        <?php
        include '../koneksi.php';

        // Memeriksa apakah terdapat data film
        $sql = "SELECT f.id_film, f.judul, f.deskripsi, f.tahun, f.sutradara, f.pemeran, g.nama_genre, f.rating, f.harga, f.poster 
                FROM tb_film f
                JOIN tb_genre g ON f.genre_id = g.id_genre";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Menampilkan daftar film
            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Judul Film</th>";
            echo "<th>Deskripsi</th>";
            echo "<th>Tahun Rilis</th>";
            echo "<th>Sutradara</th>";
            echo "<th>Pemeran</th>";
            echo "<th>Genre</th>";
            echo "<th>Rating</th>";
            echo "<th>Harga</th>";
            echo "<th>Poster</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id_film']."</td>";
                echo "<td>".$row['judul']."</td>";
                echo "<td>".$row['deskripsi']."</td>";
                echo "<td>".$row['tahun']."</td>";
                echo "<td>".$row['sutradara']."</td>";
                echo "<td>".$row['pemeran']."</td>";
                echo "<td>".$row['nama_genre']."</td>";
                echo "<td>".$row['rating']."</td>";
                echo "<td>".$row['harga']."</td>";
                echo "<td><img src='../uploads/img_film/".$row['poster']."' width='100'></td>"; // Perbaikan lokasi gambar poster
                echo "<td>";
                echo "<a href='edit_film.php?id=".$row['id_film']."' class='btn btn-edit'><i class='fas fa-edit'></i></a> | ";
                echo "<a href='hapus_film.php?id=".$row['id_film']."' class='btn btn-delete' onclick=\"return confirm('Apakah Anda yakin ingin menghapus film ini?')\"><i class='fas fa-trash-alt'></i> </a>";
                echo "</td>";
                echo "</tr>";
                
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data film.</p>";
        }

        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
