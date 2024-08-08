<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

if (!isset($_GET['id_film'])) {
    header('Location: user_infosewafilm.php');
    exit();
}

$id_film = $_GET['id_film'];

// Ambil data film
$sql = "SELECT * FROM tb_film WHERE id_film = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "Film tidak ditemukan.";
    header('Location: user_infosewafilm.php');
    exit();
}

$film = $result->fetch_assoc();

// Proses ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ulasan'])) {
        $ulasan = mysqli_real_escape_string($conn, $_POST['ulasan']);
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;

        // Simpan ulasan ke database
        $sql = "INSERT INTO tb_ulasan (id_user, id_film, ulasan, rating, tanggal_ulasan) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $_SESSION['user_id'], $id_film, $ulasan, $rating);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Ulasan berhasil dikirim.";
        } else {
            $_SESSION['error_message'] = "Terjadi kesalahan saat mengirim ulasan.";
        }
        // Redirect kembali ke halaman detail film
        header("Location: tonton_film.php?id_film=$id_film");
        exit();
    } else {
        $_SESSION['error_message'] = "Silakan lengkapi ulasan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($film['judul']); ?></title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styletonton.css">
    <style>
        /* Masukkan CSS yang telah diperbarui di sini */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var textarea = document.querySelector('textarea[name="ulasan"]');
            textarea.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    document.querySelector('form').submit();
                }
            });
        });
    </script>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container">
        <div class="film-container">
            <div class="film-video">
                <h1>Selamat menonton. <?php echo htmlspecialchars($film['judul']); ?></h1>
                <iframe src="<?php echo htmlspecialchars($film['link_film']); ?>" allowfullscreen></iframe>
            </div>
        </div>
        <div class="details-comments-container">
            <div class="film-detail">
                <h1 class="film-title"><?php echo htmlspecialchars($film['judul']); ?></h1>
                <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($film['deskripsi']); ?></p>
                <p><strong>Sutradara:</strong> <?php echo htmlspecialchars($film['sutradara']); ?></p>
                <p><strong>Pemeran:</strong> <?php echo htmlspecialchars($film['pemeran']); ?></p>
                <p><strong>Rating:</strong> <?php echo htmlspecialchars($film['rating']); ?></p>
                <p><strong>Tahun:</strong> <?php echo htmlspecialchars($film['tahun']); ?></p>
            </div>
            <div class="comments">
                <h2>Komentar</h2>
                <!-- Tampilkan pesan kesalahan atau sukses di sini -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-message">
                        <?php echo $_SESSION['error_message']; ?>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message">
                        <?php echo $_SESSION['success_message']; ?>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php
                    // Query untuk mengambil komentar dari tabel tb_ulasan dan nama pengguna dari tb_user
                    $sql = "SELECT u.ulasan, u.rating, u.tanggal_ulasan, us.nama FROM tb_ulasan u 
                            JOIN tb_user us ON u.id_user = us.id_user 
                            WHERE u.id_film = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_film);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Loop untuk menampilkan setiap komentar
                    while ($row = $result->fetch_assoc()) {
                        // Menampilkan komentar
                        echo '<div class="comment">';
                        echo '<p class="user">' . htmlspecialchars($row['nama']) . '</p>';
                        echo '<p class="content">' . htmlspecialchars($row['ulasan']) . '</p>';
                        echo '<p class="rating">Rating: ' . ($row['rating'] !== null ? $row['rating'] : 'Tidak ada') . '</p>';
                        echo '<p class="date">Tanggal: ' . $row['tanggal_ulasan'] . '</p>';
                        echo '</div>';
                    }
                ?>
                <!-- Form untuk menambahkan komentar baru -->
                <div class="add-comment">
                    <form action="tonton_film.php?id_film=<?php echo $id_film; ?>" method="POST">
                        <textarea name="ulasan" placeholder="Tambahkan komentar Anda..." rows="3" required></textarea>
                        <label for="rating">Rating (opsional):</label>
                        <input type="number" name="rating" id="rating" min="1" max="10">
                        <button type="submit">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>
</body>
</html>
