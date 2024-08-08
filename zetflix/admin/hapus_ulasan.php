<?php
include '../koneksi.php';
session_start(); // Start session to use session variables for user feedback

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id_ulasan = $_GET['id'];

    // Use a prepared statement to delete the review to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM tb_ulasan WHERE id_ulasan = ?");
    $stmt->bind_param("i", $id_ulasan);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Data ulasan berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
    
    // Redirect to kelola_ulasan.php with a success or error message
    header("Location: kelola_ulasan.php");
    exit();
} else {
    $_SESSION['message'] = "ID ulasan tidak ditemukan.";
    header("Location: kelola_ulasan.php");
    exit();
}
?>
