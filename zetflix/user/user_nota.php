<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the latest payment information
$sql_nota = "SELECT * FROM tb_nota WHERE id_user = ? ORDER BY id_nota DESC LIMIT 1";
$stmt_nota = $conn->prepare($sql_nota);

if ($stmt_nota) {
    $stmt_nota->bind_param("i", $user_id);
    $stmt_nota->execute();
    $result_nota = $stmt_nota->get_result();
    $nota = $result_nota->fetch_assoc();

    $id_film = $nota['id_film'];
    $harga_film = $nota['harga_film'];
    $nominal_bayar = $nota['nominal_bayar'];
    $uang_kembalian = $nota['uang_kembalian'];
    $tanggal_bayar = $nota['tanggal_bayar'];
    $jam_bayar = $nota['jam_bayar'];
    $tanggal_kembali = $nota['tanggal_kembali'];
    $jam_kembali = $nota['jam_kembali'];
    $metode_pembayaran = $nota['metode_pembayaran'];

    // Fetch film details
    $sql_film = "SELECT judul, tahun, sutradara, rating, poster FROM tb_film WHERE id_film = ?";
    $stmt_film = $conn->prepare($sql_film);

    if ($stmt_film) {
        $stmt_film->bind_param("i", $id_film);
        $stmt_film->execute();
        $result_film = $stmt_film->get_result();
        $film = $result_film->fetch_assoc();

        // Fetch user details
        $sql_user = "SELECT nama FROM tb_user WHERE id_user = ?";
        $stmt_user = $conn->prepare($sql_user);

        if ($stmt_user) {
            $stmt_user->bind_param("i", $user_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $user = $result_user->fetch_assoc();
            $nama_user = $user['nama'];
        } else {
            echo "Error preparing user query: " . $conn->error;
        }
    } else {
        echo "Error preparing film query: " . $conn->error;
    }
} else {
    echo "Error preparing nota query: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    <link rel="stylesheet" href="../assets/css/stylenota.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
    color: #333;
    margin: 0;
    padding: 0;
}
h1 {
    margin-top: 50px;
    text-align: center;
}

.container {
    margin: 20px auto;
    width: 80%;
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 20px;
}

@media (min-width: 768px) {
    .container {
        grid-template-columns: 1fr 1fr;
    }
}

.film-info h1 {
    text-align: left;
    font-size: 50px;
    margin-top: -20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.film-info h1 img {
    max-width: 50px;
    height: auto;
    margin-left: 20px;
}

.film-info h2 {
    text-align: center;
    font-size: 35px;
    margin-bottom: 10px;
}

.film-info,
.payment-details {
    font-size: 20px;
    text-align: left;
    padding: 50px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.film-info h3,
.payment-details h3, h4 {
    font-size: 1.5em;
    margin-bottom: 20px;
}

.film-info p,
.payment-details p {
    margin: 5px 0;
}

.film-info h5 {
    text-align: center;
    margin-bottom: -10px;
    font-size: 30px;
}

.film-poster img {
    max-width: 95%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 8px;
}

.button-container a {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    margin-left: auto;
    margin-right: auto;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.button-container a.watch-now-btn {
    background-color: #ffc107; /* Warna kuning untuk tombol "Nonton Sekarang" */
    color: #fff;
    margin-top: 50px;
    margin-left: 100px;
}

.button-container a.home-btn {
    background-color: #28a745; /* Warna hijau untuk tombol "Kembali ke Beranda" */
    color: #fff;
    margin-top: 50px;
    margin-left: 100px;
}

.button-container a:hover {
    filter: brightness(90%);
}


.divider {
    color: green;
    font-size: 40px;
    position: relative;
    margin: 10px 0;
    text-align: center;
}

.divider::before,
.divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 40%;
    height: 1px;
    background-color: black;
}

.divider::before {
    left: 0;
}

.divider::after {
    right: 0;
}

.fa-icon {
    margin-right: 0px;
}
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <h1>Pergi ke Navigasi My Account dan ke"Tonton Film" untuk Melihat Film Sewaan mu</h1>
    <div class="container">
        <div class="film-info">
            <h1>Zetflix</h1>
            <h2> Pembayaran Berhasil </h2>
            <div class="divider"><i class="fas fa-circle-check fa-icon"></i></div>
            <h3><i class="fas fa-film fa-icon"></i> Informasi Film</h3>
            <p><b><?php echo htmlspecialchars($film['judul']); ?></b></p>
            <p><i class="fas fa-calendar-alt fa-icon"></i> Tahun: <?php echo htmlspecialchars($film['tahun']); ?></p>
            <p><i class="fas fa-user-tie fa-icon"></i> Sutradara: <?php echo htmlspecialchars($film['sutradara']); ?></p>
            <p><i class="fas fa-star fa-icon"></i> Rating: <?php echo htmlspecialchars($film['rating']); ?></p>
            <h4><i class="fas fa-receipt fa-icon"></i> Detail Pembayaran</h4>
            <p><i class="fas fa-user fa-icon"></i> <?php echo htmlspecialchars($nama_user); ?></p>
            <p><i class="fas fa-wallet fa-icon"></i> Metode Pembayaran: <?php echo htmlspecialchars($metode_pembayaran); ?></p>
            <p><i class="fas fa-calendar-alt fa-icon"></i> Tanggal Pembayaran: <?php echo htmlspecialchars($tanggal_bayar); ?></p>
            <p><i class="fas fa-clock fa-icon"></i> Jam Pembayaran: <?php echo htmlspecialchars($jam_bayar); ?></p>
            <p><i class="fas fa-calendar-alt fa-icon"></i> Tanggal Kembali: <?php echo htmlspecialchars($tanggal_kembali); ?></p>
            <p><i class="fas fa-clock fa-icon"></i> Jam Kembali: <?php echo htmlspecialchars($jam_kembali); ?></p>
            <p><i class="fas fa-money-bill-wave fa-icon"></i> Harga Film: <b>Rp <?php echo number_format($harga_film, 0, ',', '.'); ?></b></p>
            <p><i class="fas fa-money-check-alt fa-icon"></i> Nominal Bayar: <b>Rp <?php echo number_format($nominal_bayar, 0, ',', '.'); ?></b></p>
            <p><i class="fas fa-coins fa-icon"></i> Kembalian: <b>Rp <?php echo number_format($uang_kembalian, 0, ',', '.'); ?></b></p>
            <div class="divider"><i class="fas fa-shield fa-icon"></i></div>
            <h5> Terima Kasih </h5>
        </div>
        <div class="film-poster">
            <img src="../uploads/img_film/<?php echo htmlspecialchars($film['poster']); ?>" alt="Poster Film">
            <div class="button-container">
                <a class="watch-now-btn" href="tonton_film.php?id_film=<?php echo $id_film; ?>"><i class="fas fa-play fa-icon"></i> Nonton Sekarang</a>
                <a class="home-btn" href="../index.php"><i class="fas fa-home fa-icon"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
