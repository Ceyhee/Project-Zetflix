<?php
include '../koneksi.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Kelola Ulasan Film</title>";
echo "<style>";
echo "body {";
echo "    font-family: 'Arial', sans-serif;";
echo "    background-color: #f4f4f4;";
echo "    margin: 0;";
echo "    padding: 0;";
echo "}";
echo ".container {";
echo "    width: 80%;";
echo "    margin: 20px auto;";
echo "    background-color: #fff;";
echo "    padding: 20px;";
echo "    border-radius: 8px;";
echo "    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);";
echo "}";
echo ".title {";
echo "    text-align: center;";
echo "    margin-bottom: 20px;";
echo "    font-weight: bold;";
echo "}";
echo ".btn {";
echo "    display: inline-block;";
echo "    text-align: center;";
echo "    text-decoration: none;";
echo "    color: #fff;";
echo "    background-color: #28a745;";
echo "    padding: 10px 20px;";
echo "    border-radius: 5px;";
echo "}";
echo ".btn:hover {";
echo "    background-color: #333;";
echo "}";
echo ".review-table {";
echo "    width: 100%;";
echo "    border-collapse: collapse;";
echo "}";
echo ".review-table th, .review-table td {";
echo "    border: 1px solid #ddd;";
echo "    padding: 8px;";
echo "    text-align: left;";
echo "}";
echo ".review-table th {";
echo "    background-color: #333;";
echo "    color: #fff;";
echo "}";
echo ".delete-btn {";
echo "    text-decoration: none;";
echo "    color: #dc3545;";
echo "    font-weight: bold;";
echo "}";
echo ".delete-btn:hover {";
echo "    text-decoration: underline;";
echo "    color: #dc3545;";
echo "}";
echo ".no-data-msg, .error-msg, .success-msg {";
echo "    text-align: center;";
echo "    font-weight: bold;";
echo "}";
echo ".error-msg {";
echo "    color: #dc3545;";
echo "}";
echo ".success-msg {";
echo "    color: #28a745;";
echo "}";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1 class='title'>Kelola Ulasan Film</h1>";
echo "<a href='index.php' class='btn'>Beranda</a>"; // Tombol Beranda
echo "<form action='' method='post' style='display:inline-block; margin-left: 20px;'>";
echo "<button type='submit' name='hapus_semua' class='btn' style='background-color: #dc3545;'>Hapus Semua</button>";
echo "</form>";
echo "<br><br>";

// Display messages
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'success') {
        echo "<p class='success-msg'>Ulasan berhasil dihapus.</p>";
    } elseif ($_GET['message'] == 'error') {
        echo "<p class='error-msg'>Terjadi kesalahan saat menghapus ulasan.</p>";
    } elseif ($_GET['message'] == 'notfound') {
        echo "<p class='error-msg'>ID ulasan tidak ditemukan.</p>";
    }
}

if ($conn) {
    if (isset($_POST['hapus_semua'])) {
        // Disable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=0");

        // Menghapus semua ulasan
        $sql_hapus_semua = "DELETE FROM tb_ulasan";
        if ($conn->query($sql_hapus_semua) === TRUE) {
            echo "<p class='success-msg'>Semua ulasan berhasil dihapus.</p>";
        } else {
            echo "<p class='error-msg'>Error: " . $conn->error . "</p>";
        }

        // Enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");
    }

    $sql = "SELECT * FROM tb_ulasan";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Tampilkan data ulasan
            echo "<table class='review-table'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>ID User</th>";
            echo "<th>ID Admin</th>";
            echo "<th>ID Film</th>";
            echo "<th>Ulasan</th>";
            echo "<th>Rating</th>";
            echo "<th>Tanggal Ulasan</th>";
            echo "<th>Aksi</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id_ulasan']."</td>";
                echo "<td>".$row['id_user']."</td>";
                echo "<td>".$row['id_admin']."</td>";
                echo "<td>".$row['id_film']."</td>";
                echo "<td>".$row['ulasan']."</td>";
                echo "<td>".$row['rating']."</td>";
                echo "<td>".$row['tanggal_ulasan']."</td>";
                echo "<td>";
                echo "<a href='hapus_ulasan.php?id=".$row['id_ulasan']."' class='delete-btn' onclick=\"return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')\">Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='no-data-msg'>Tidak ada data ulasan.</p>";
        }
    } else {
        echo "<p class='error-msg'>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='error-msg'>Koneksi ke basis data gagal.</p>";
}

echo "</div>";
echo "</body>";
echo "</html>";

$conn->close();
?>
