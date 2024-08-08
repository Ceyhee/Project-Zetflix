<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna sudah login dan merupakan admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Query untuk menghapus semua data sewa
$sql = "DELETE FROM tb_sewafilm";

if ($conn->query($sql) === TRUE) {
    $_SESSION['success_message'] = '';
} else {
    $_SESSION['error_message'] = '' . $conn->error;
}

$conn->close();

header("Location: kelola_sewafilm.php");
exit();
?>
