<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Disable foreign key checks to handle deletion of dependent records
    if (!$conn->query("SET FOREIGN_KEY_CHECKS=0")) {
        echo "Error: " . $conn->error;
        exit();
    }

    // Delete all reviews by the user
    $sql_delete_ulasan = "DELETE FROM tb_ulasan WHERE id_user = ?";
    $stmt_delete_ulasan = $conn->prepare($sql_delete_ulasan);
    $stmt_delete_ulasan->bind_param("i", $id_user);
    $stmt_delete_ulasan->execute();

    // Delete all favorite films of the user
    $sql_delete_favorit = "DELETE FROM tb_filmfavorit WHERE id_user = ?";
    $stmt_delete_favorit = $conn->prepare($sql_delete_favorit);
    $stmt_delete_favorit->bind_param("i", $id_user);
    $stmt_delete_favorit->execute();

    // Delete all ongoing film rentals by the user
    $sql_delete_sewa = "DELETE FROM tb_sewafilm WHERE id_user = ?";
    $stmt_delete_sewa = $conn->prepare($sql_delete_sewa);
    $stmt_delete_sewa->bind_param("i", $id_user);
    $stmt_delete_sewa->execute();

    // Delete the user account
    $sql_delete_user = "DELETE FROM tb_user WHERE id_user = ?";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bind_param("i", $id_user);
    
    if ($stmt_delete_user->execute()) {
        echo "<script>alert('Akun pengguna dan semua data terkait berhasil dihapus.')</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menghapus akun pengguna.')</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }

    // Re-enable foreign key checks after deletion
    if (!$conn->query("SET FOREIGN_KEY_CHECKS=1")) {
        echo "Error: " . $conn->error;
        exit();
    }
} else {
    // Jika tidak ada parameter ID yang diberikan, kembalikan ke halaman utama
    header("Location: index.php");
    exit();
}
?>
