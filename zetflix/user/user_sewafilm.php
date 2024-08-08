<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_user = $_SESSION['user_id'];
$tanggal_sewa = date('Y-m-d');
$tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

$sql = "INSERT INTO tb_sewafilm (id_user, id_film, tanggal_sewa, tanggal_kembali) 
        VALUES ($id_user, $id_film, '$tanggal_sewa', '$tanggal_kembali')";

if ($conn->query($sql) === TRUE) {
    echo "Film berhasil disewa.";
    header('Location: ../detail_film.php?id=' . $id_film);
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
