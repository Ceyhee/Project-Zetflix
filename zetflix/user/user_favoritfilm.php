<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id_film = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_user = $_SESSION['user_id'];

$sql = "INSERT INTO tb_filmfavorit (id_user, id_film) VALUES ($id_user, $id_film)";

if ($conn->query($sql) === TRUE) {
    echo "Film berhasil ditambahkan ke favorit.";
    header('Location: ../detail_film.php?id=' . $id_film);
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
