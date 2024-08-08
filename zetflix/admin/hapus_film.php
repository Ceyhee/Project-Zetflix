<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna sudah login dan merupakan admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

$id_film = $_GET['id'];

// Mulai transaksi
$conn->begin_transaction();

try {
    // Matikan foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    // Hapus sewa terkait film ini
    $sql_delete_sewa = "DELETE FROM tb_sewafilm WHERE id_film = ?";
    $stmt_delete_sewa = $conn->prepare($sql_delete_sewa);
    $stmt_delete_sewa->bind_param("i", $id_film);
    $stmt_delete_sewa->execute();

    // Hapus ulasan terkait film ini
    $sql_delete_ulasan = "DELETE FROM tb_ulasan WHERE id_film = ?";
    $stmt_delete_ulasan = $conn->prepare($sql_delete_ulasan);
    $stmt_delete_ulasan->bind_param("i", $id_film);
    $stmt_delete_ulasan->execute();

    // Hapus favorit terkait film ini
    $sql_delete_favorit = "DELETE FROM tb_filmfavorit WHERE id_film = ?";
    $stmt_delete_favorit = $conn->prepare($sql_delete_favorit);
    $stmt_delete_favorit->bind_param("i", $id_film);
    $stmt_delete_favorit->execute();

    // Hapus film dari database
    $sql_delete_film = "DELETE FROM tb_film WHERE id_film = ?";
    $stmt_delete_film = $conn->prepare($sql_delete_film);
    $stmt_delete_film->bind_param("i", $id_film);
    if ($stmt_delete_film->execute()) {
        $_SESSION['success_message'] = "";
    } else {
        throw new Exception("");
    }

    // Nyalakan kembali foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    // Commit transaksi
    $conn->commit();

    header('Location: ../index.php');
    exit();
} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
    header('Location: ../detail_film.php?id=' . $id_film);
    exit();
}
?>
