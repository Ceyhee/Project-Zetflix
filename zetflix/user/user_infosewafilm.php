<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data sewa film pengguna
$sql = "SELECT tb_sewafilm.*, tb_film.judul, tb_film.poster, tb_film.harga, tb_film.link_film
        FROM tb_sewafilm 
        JOIN tb_film ON tb_sewafilm.id_film = tb_film.id_film 
        WHERE tb_sewafilm.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Array untuk melacak film yang sudah ditampilkan
$displayedFilms = [];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Informasi Sewa Film</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .rental-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .rental-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            display: block;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .rental-item img {
            width: 100px;
            height: auto;
            border-radius: 8px;
            margin-right: 10px;
            transition: transform 0.3s;
        }

        .rental-item img:hover {
            transform: scale(1.1);
        }

        .rental-item h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .rental-item p {
            margin: 5px 0;
        }

        .no-rental-message {
            font-weight: bold;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        .button-container a {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }

        .watch-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .watch-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <h1>Informasi Sewa Film</h1>
        <div class="rental-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php if (!in_array($row['id_film'], $displayedFilms)): ?>
                        <div class="rental-item">
                            <img src="../uploads/img_film/<?php echo htmlspecialchars($row['poster']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                            <div>
                                <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                                <p>Tanggal Sewa: <?php echo htmlspecialchars($row['tanggal_sewa']); ?></p>
                                <p>Tanggal Kembali: <?php echo htmlspecialchars($row['tanggal_kembali']); ?></p>
                                <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            </div>
                            <a href="tonton_film.php?id_film=<?php echo $row['id_film']; ?>" class="watch-button">Tonton Sekarang</a>
                        </div>
                        <?php $displayedFilms[] = $row['id_film']; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-rental-message">Anda belum menyewa film apapun.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
