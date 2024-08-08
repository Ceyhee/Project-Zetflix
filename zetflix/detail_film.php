<?php
session_start();
include 'koneksi.php';

// Mendapatkan ID film dari parameter GET
$id_film = $_GET['id'];

// Memeriksa apakah ada ulasan yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ulasan'])) {
        $ulasan = mysqli_real_escape_string($conn, $_POST['ulasan']);

        if ($_SESSION['user_role'] === 'user' && isset($_POST['rating'])) {
            $rating = $_POST['rating'];

            // Menyiapkan kueri SQL menggunakan prepared statement
            $sql = "INSERT INTO tb_ulasan (id_user, id_film, ulasan, rating, tanggal_ulasan) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);

            // Bind parameter ke kueri
            $stmt->bind_param("iisi", $_SESSION['user_id'], $id_film, $ulasan, $rating);
        } elseif ($_SESSION['user_role'] === 'admin') {
            // Menyiapkan kueri SQL menggunakan prepared statement
            $sql = "INSERT INTO tb_ulasan (id_admin, id_film, ulasan, tanggal_ulasan) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);

            // Bind parameter ke kueri
            $stmt->bind_param("iis", $_SESSION['admin_id'], $id_film, $ulasan);
        }

        // Eksekusi kueri
        $stmt->execute();

        // Redirect kembali ke halaman detail film
        header("Location: detail_film.php?id=$id_film");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah redirect
    }

    // Handle replies
    if (isset($_POST['balasan']) && ($_SESSION['user_role'] === 'admin') && isset($_POST['id_ulasan'])) {
        $balasan = mysqli_real_escape_string($conn, $_POST['balasan']);
        $id_ulasan = $_POST['id_ulasan'];

        // Menyiapkan kueri SQL menggunakan prepared statement
        $sql_reply = "INSERT INTO tb_ulasan (id_admin, id_film, ulasan, tanggal_ulasan, id_balasan) VALUES (?, ?, ?, NOW(), ?)";
        $stmt_reply = $conn->prepare($sql_reply);

        // Bind parameter ke kueri
        $stmt_reply->bind_param("iisi", $_SESSION['admin_id'], $id_film, $balasan, $id_ulasan);

        // Eksekusi kueri
        $stmt_reply->execute();

        // Redirect kembali ke halaman detail film
        header("Location: detail_film.php?id=$id_film");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah redirect
    }

    // Handle delete comments
    if (isset($_POST['delete_comment']) && ($_SESSION['user_role'] === 'admin') && isset($_POST['id_ulasan'])) {
        $id_ulasan = $_POST['id_ulasan'];

        // Menyiapkan kueri SQL menggunakan prepared statement
        $sql_delete = "DELETE FROM tb_ulasan WHERE id_ulasan = ? OR id_balasan = ?";
        $stmt_delete = $conn->prepare($sql_delete);

        // Bind parameter ke kueri
        $stmt_delete->bind_param("ii", $id_ulasan, $id_ulasan);

        // Eksekusi kueri
        $stmt_delete->execute();

        // Redirect kembali ke halaman detail film
        header("Location: detail_film.php?id=$id_film");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah redirect
    }
}

// Mengambil detail film
$sql_film = "SELECT * FROM tb_film WHERE id_film = '$id_film'";
$result_film = $conn->query($sql_film);
$film = $result_film->fetch_assoc();

// Mengambil ulasan untuk film tersebut
$sql_ulasan = "
    SELECT u.*, us.nama, us.email 
    FROM tb_ulasan u
    LEFT JOIN tb_user us ON u.id_user = us.id_user
    WHERE u.id_film = '$id_film' AND u.id_balasan IS NULL
";
$result_ulasan = $conn->query($sql_ulasan);

// Mengambil balasan untuk ulasan
$sql_balasan = "
    SELECT u.*, us.nama, us.email 
    FROM tb_ulasan u
    LEFT JOIN tb_user us ON u.id_user = us.id_user
    WHERE u.id_film = '$id_film' AND u.id_balasan IS NOT NULL
";
$result_balasan = $conn->query($sql_balasan);
$balasan_list = [];
while ($balasan = $result_balasan->fetch_assoc()) {
    $balasan_list[$balasan['id_balasan']][] = $balasan;
}

// Cek apakah film sedang disewa oleh user
$user_id = $_SESSION['user_id'] ?? null;
$isRentedByUser = false;

if ($user_id) {
    // Kueri untuk memeriksa apakah film sudah disewa
    $sql_sewa = "SELECT * FROM tb_sewafilm WHERE id_film = '$id_film' AND id_user = '$user_id' AND tanggal_kembali IS NULL";
    $result_sewa = $conn->query($sql_sewa);
    $isRentedByUser = $result_sewa->num_rows > 0;
}

// Cek apakah film sudah difavoritkan oleh user
$isFavoritedByUser = false;
if ($user_id) {
    $sql_favorit = "SELECT * FROM tb_filmfavorit WHERE id_film = '$id_film' AND id_user = '$user_id'";
    $result_favorit = $conn->query($sql_favorit);
    $isFavoritedByUser = $result_favorit->num_rows > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Film</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styledetailfilm.css">
    <style>
        .ulasan-balasan {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="poster-container">
            <img src="uploads/img_film/<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['judul']); ?>">
        </div>

        <div class="detail-ulasan-container">
            <div class="detail-container">
                <h1><?php echo htmlspecialchars($film['judul']); ?></h1>
                <p><?php echo htmlspecialchars($film['deskripsi']); ?></p>
                <p>Tahun: <?php echo htmlspecialchars($film['tahun']); ?></p>
                <p>Sutradara: <?php echo htmlspecialchars($film['sutradara']); ?></p>
                <p>Pemeran: <?php echo htmlspecialchars($film['pemeran']); ?></p>
                <p>Rating: <?php echo htmlspecialchars($film['rating']); ?></p>
                <p>Harga: Rp. <?php echo number_format($film['harga'], 0, ',', '.'); ?></p>
                <div class="action-buttons">
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin/edit_film.php?id=<?php echo $id_film; ?>">Edit</a>
                        <a href="admin/hapus_film.php?id=<?php echo $id_film; ?>" onclick="return confirm('Anda yakin ingin menghapus film ini?')">Hapus</a>
                    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user'): ?>
                        <?php if (!$isRentedByUser): ?>
                            <a href="user/user_pembayaran.php?id=<?php echo $id_film; ?>">Sewa Film</a>
                        <?php else: ?>
                            <button type="button" disabled>Sudah Disewa</button>
                        <?php endif; ?>

                        <?php if (!$isFavoritedByUser): ?>
                            <a href="user/user_favoritfilm.php?id=<?php echo $id_film; ?>">+ Tambah Favorit</a>
                        <?php else: ?>
                            <button type="button" disabled>+ Sudah Ditambah</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Silakan <a href="user/user_login.php"> login </a> untuk menyewa film atau menambah favorit.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="ulasan-list">
                <h2>Ulasan</h2>
                <?php while ($ulasan = $result_ulasan->fetch_assoc()): ?>
                    <div class="ulasan-item">
                        <p>
                            <strong><?php echo htmlspecialchars($ulasan['nama']); ?>:</strong> 
                            <span style="<?php echo ($ulasan['email'] === 'admin@example.com') ? 'color:red;' : ''; ?>">
                                <?php echo htmlspecialchars($ulasan['ulasan']); ?>
                            </span>
                        </p>
                        <p>Rating: <?php echo htmlspecialchars($ulasan['rating']); ?></p>
                        <p><small>Ditulis pada: <?php echo htmlspecialchars($ulasan['tanggal_ulasan']); ?></small></p>
                        
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <form action="detail_film.php?id=<?php echo $id_film; ?>" method="post" style="display:inline;">
                                <input type="hidden" name="id_ulasan" value="<?php echo $ulasan['id_ulasan']; ?>">
                                <button type="submit" name="delete_comment">Hapus</button>
                            </form>
                            <div class="form-balasan">
                                <form action="detail_film.php?id=<?php echo $id_film; ?>" method="post">
                                    <textarea name="balasan" rows="2" placeholder="Balas ulasan" required></textarea>
                                    <input type="hidden" name="id_ulasan" value="<?php echo $ulasan['id_ulasan']; ?>">
                                    <button type="submit">Balas</button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($balasan_list[$ulasan['id_ulasan']])): ?>
                            <?php foreach ($balasan_list[$ulasan['id_ulasan']] as $balasan): ?>
                                <div class="ulasan-balasan" style="margin-left: 20px; <?php echo ($balasan['email'] === 'admin@example.com') ? 'color:red;' : ''; ?>">
                                    <p><strong><?php echo htmlspecialchars($balasan['nama']); ?>:</strong> <?php echo htmlspecialchars($balasan['ulasan']); ?></p>
                                    <p><small>Ditulis pada: <?php echo htmlspecialchars($balasan['tanggal_ulasan']); ?></small></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'user'): ?>
                    <div class="form-ulasan">
                        <h3>Tulis Ulasan</h3>
                        <form action="detail_film.php?id=<?php echo $id_film; ?>" method="post">
                            <textarea name="ulasan" rows="5" placeholder="Tulis ulasan Anda" required></textarea>
                            <input type="number" name="rating" min="1" max="10" placeholder="Rating (1-10)" required>
                            <button type="submit">Kirim Ulasan</button>
                        </form>
                    </div>
                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin'): ?>
                    <div class="form-ulasan">
                        <h3>Tulis Komentar</h3>
                        <form action="detail_film.php?id=<?php echo $id_film; ?>" method="post">
                            <textarea name="ulasan" rows="5" placeholder="Tulis komentar Anda" required></textarea>
                            <button type="submit">Kirim Komentar</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p><a href="user/user_login.php">Login</a> untuk menulis ulasan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('textarea').forEach(function(textarea) {
                textarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        textarea.form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
