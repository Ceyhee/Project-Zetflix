<?php
include '../koneksi.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Kelola Penyewaan Film</title>";
echo "<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
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

h1 {
    text-align: center;
    margin-bottom: 20px;
}

a {
    display: inline-block;
    margin-bottom: 10px;
    text-decoration: none;
    color: #333;
    transition: color 0.3s ease;
    font-weight: bold;
    font-size: 18px;
}

a:hover {
    color: #555;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 18px;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.edit-btn, .delete-btn {
    text-decoration: none;
    color: #333;
    transition: color 0.3s ease;
}

.edit-btn:hover, .delete-btn:hover {
    color: #555;
}

.icon {
    margin-right: 5px;
}

.delete-all-btn {
    display: inline-block;
    margin-bottom: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #d9534f;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-weight: bold;
    font-size: 18px;
}

.delete-all-btn:hover {
    background-color: #c9302c;
}

.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    color: #fff;
    text-align: center;
}

.success {
    background-color: #5cb85c;
}

.error {
    background-color: #d9534f;
}
</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>Kelola Sewafilm User</h1>";
echo "<a href='index.php'><i class='icon fas fa-home'></i>🏠︎ Beranda</a>"; // Tombol Beranda dengan ikon
echo "<br><br>";

// Tombol Hapus Semua
echo "<a href='hapus_sewafilm.php' class='delete-all-btn' onclick=\"return confirm('Apakah Anda yakin ingin menghapus semua data penyewaan?')\"><i class='icon fas fa-trash'></i> Hapus Semua</a>";
echo "<br><br>";

// Tampilkan pesan sukses atau error
if (isset($_SESSION['success_message'])) {
    echo "<div class='message success'>".$_SESSION['success_message']."</div>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<div class='message error'>".$_SESSION['error_message']."</div>";
    unset($_SESSION['error_message']);
}

if ($conn) {
    // Query untuk mendapatkan data penyewaan lengkap dengan nama user, judul film, dan harga
    $sql = "
        SELECT 
            tb_sewafilm.id_sewa, 
            tb_user.nama AS username, 
            tb_film.judul AS judul_film, 
            tb_film.harga, 
            tb_sewafilm.tanggal_sewa, 
            tb_sewafilm.tanggal_kembali 
        FROM 
            tb_sewafilm 
        JOIN 
            tb_user ON tb_sewafilm.id_user = tb_user.id_user 
        JOIN 
            tb_film ON tb_sewafilm.id_film = tb_film.id_film
    ";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Tampilkan data penyewaan film
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>ID Sewa</th>";
            echo "<th>Nama Pengguna</th>";
            echo "<th>Judul Film</th>";
            echo "<th>Harga</th>";
            echo "<th>Tanggal Sewa</th>";
            echo "<th>Tanggal Batas Kembali</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id_sewa']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['judul_film']."</td>";
                echo "<td>".number_format($row['harga'], 0, ',', '.')."</td>"; // Format harga dengan titik sebagai pemisah ribuan
                echo "<td>".$row['tanggal_sewa']."</td>";
                echo "<td>".$row['tanggal_kembali']."</td>";
                echo "<td>";
                echo "<a href='edit_sewafilm.php?id=".$row['id_sewa']."' class='edit-btn'><i class='icon fas fa-edit'></i> Edit</a> | ";
                echo "<a href='hapus_sewafilm.php?id=".$row['id_sewa']."' class='delete-btn' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data penyewaan ini?')\"><i class='icon fas fa-trash'></i> Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada data penyewaan film.</p>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Koneksi ke basis data gagal.";
}

echo "</div>";
echo "</body>";
echo "</html>";

$conn->close();
?>
