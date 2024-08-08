<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data film favorit pengguna
$sql = "SELECT tb_filmfavorit.id_favorit, tb_film.judul, tb_film.poster 
        FROM tb_filmfavorit 
        JOIN tb_film ON tb_filmfavorit.id_film = tb_film.id_film 
        WHERE tb_filmfavorit.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Proses penghapusan film favorit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_favorite'])) {
    $id_favorit = $_POST['id_favorit'];

    $delete_sql = "DELETE FROM tb_filmfavorit WHERE id_favorit = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id_favorit);
    if ($delete_stmt->execute()) {
        header('Location: user_updatefavoritfilm.php');
        exit();
    } else {
        $error = "Gagal menghapus film favorit.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Film Favorit Saya</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
        }

        .favorite-list {
            flex: 1 1 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .favorite-item {
            flex: 1 1 30%;
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .favorite-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .favorite-item h3 {
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: bold;
        }

        .favorite-item .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .favorite-item .delete-button:hover {
            background-color: #c82333;
        }

        .no-favorite-message {
            flex: 1 1 100%;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <h1>Film Favorit Saya</h1>
        <div class="favorite-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="favorite-item">
                        <img src="../uploads/img_film/<?php echo htmlspecialchars($row['poster']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <form method="post" action="">
                            <input type="hidden" name="id_favorit" value="<?php echo $row['id_favorit']; ?>">
                            <button type="submit" name="delete_favorite" class="delete-button">Hapus dari Favorit</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-favorite-message">Anda belum menambahkan film favorit apapun.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>

