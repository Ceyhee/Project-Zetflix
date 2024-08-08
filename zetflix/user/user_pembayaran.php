<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: user_login.php');
    exit();
}

// Set timezone to Jakarta
date_default_timezone_set('Asia/Jakarta');

$id_film = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch film data
$sql_film = "SELECT judul, deskripsi, tahun, sutradara, pemeran, genre_id, rating, poster, harga FROM tb_film WHERE id_film = ?";
$stmt_film = $conn->prepare($sql_film);

if ($stmt_film === false) {
    die('Error preparing the film query: ' . $conn->error);
}

$stmt_film->bind_param("i", $id_film);
$stmt_film->execute();
$result_film = $stmt_film->get_result();
$film = $result_film->fetch_assoc();
$harga_film = $film['harga'];

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nominal = $_POST['nominal'];
    $nominal = intval(str_replace('.', '', $nominal)); // Remove dots and convert to int
    $payment_method = $_POST['payment_method'];

    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Verify user password
        $sql_user = "SELECT * FROM tb_user WHERE id_user = ?";
        $stmt_user = $conn->prepare($sql_user);

        if ($stmt_user === false) {
            die('Error preparing the user query: ' . $conn->error);
        }

        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Verify payment amount
            if ($nominal >= $harga_film) {
                // Process payment
                $tanggal_sewa = date('Y-m-d');
                $jam_sewa = date('H:i:s');
                $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
                $jam_kembali = $jam_sewa;
                $uang_kembalian = $nominal - $harga_film;

                $sql_sewa = "INSERT INTO tb_sewafilm (id_user, id_film, tanggal_sewa, tanggal_kembali) VALUES (?, ?, ?, ?)";
                $stmt_sewa = $conn->prepare($sql_sewa);

                if ($stmt_sewa === false) {
                    die('Error preparing the sewa query: ' . $conn->error);
                }

                $stmt_sewa->bind_param("iiss", $user_id, $id_film, $tanggal_sewa, $tanggal_kembali);

                if ($stmt_sewa->execute()) {
                    $sql_nota = "INSERT INTO tb_nota (id_user, id_film, harga_film, nominal_bayar, uang_kembalian, tanggal_bayar, jam_bayar, tanggal_kembali, jam_kembali, metode_pembayaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt_nota = $conn->prepare($sql_nota);

                    if ($stmt_nota === false) {
                        die('Error preparing the nota query: ' . $conn->error);
                    }

                    $stmt_nota->bind_param("iiiiisssss", $user_id, $id_film, $harga_film, $nominal, $uang_kembalian, $tanggal_sewa, $jam_sewa, $tanggal_kembali, $jam_kembali, $payment_method);
                    $stmt_nota->execute();
                    
                    header('Location: user_nota.php');
                    exit();
                } else {
                    $error = "Gagal menyewa film. Silakan coba lagi.";
                }
            } else {
                $error = "Nominal pembayaran kurang dari harga film. Silakan masukkan nominal yang sesuai.";
            }
        } else {
            $error = "Password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Sewa Film</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/stylepembayaran.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#pay-now").click(function() {
                let selectedMethod = $("input[name='payment_method']:checked").val();
                if (!selectedMethod) {
                    alert("Pilih metode pembayaran terlebih dahulu.");
                    return;
                }
                let nominal = $("#nominal").val();
                $("#selected-method").text(selectedMethod.toUpperCase());
                $("#selected-nominal").text("Rp " + nominal.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#hidden-payment-method").val(selectedMethod); // Set the selected payment method
                $("#paymentModal").show();
            });

            $(".close").click(function() {
                $("#paymentModal").hide();
            });

            $("#nominal").on('input', function() {
                let value = $(this).val();
                let formattedValue = value.replace(/\D/g, '');
                let displayValue = "";

                if (formattedValue.length >= 1) {
                    let reverseValue = formattedValue.split('').reverse().join('');
                    displayValue = reverseValue.match(/\d{1,3}/g).join('.').split('').reverse().join('');
                }

                $(this).val(displayValue);
            });

            <?php if ($error): ?>
                alert("<?php echo $error; ?>");
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="film-info">
            <h1>Penyewaan Film</h1>
            <div class="divider"><i class="fas fa-circle-check fa-icon"></i></div>
            <h3><?php echo htmlspecialchars($film['judul']); ?></h3>
            <p>Deskripsi: <?php echo htmlspecialchars($film['deskripsi']); ?></p>
            <p>Tahun: <?php echo htmlspecialchars($film['tahun']); ?></p>
            <p>Sutradara: <?php echo htmlspecialchars($film['sutradara']); ?></p>
            <p>Pemeran: <?php echo htmlspecialchars($film['pemeran']); ?></p>
            <p>Genre ID: <?php echo htmlspecialchars($film['genre_id']); ?></p>
            <p>Rating: <?php echo htmlspecialchars($film['rating']); ?></p>
            <p>Harga: Rp <?php echo number_format($harga_film, 0, ',', '.'); ?></p>
        </div>
        <div class="film-poster">
            <img src="../uploads/img_film/<?php echo htmlspecialchars($film['poster']); ?>" alt="Poster Film">
        </div>
        <div class="total-payment">
            <h3>Total Pembayaran</h3>
            <p>Harga Film: Rp <?php echo number_format($harga_film, 0, ',', '.'); ?></p>
            <p>Sisa Pembayaran: Rp <?php echo number_format($harga_film, 0, ',', '.'); ?></p>
        </div>
        <div class="payment-options">
            <h3>Pilih Metode Pembayaran:</h3>
            <input type="radio" id="gopay" name="payment_method" value="GoPay">
            <label for="gopay"><img src="/zetflix/uploads/img_logo/logo_gopay.png" alt="GoPay" width="60"></label>
            <input type="radio" id="dana" name="payment_method" value="Dana">
            <label for="dana"><img src="/zetflix/uploads/img_logo/logo_dana.png" alt="Dana" width="50"></label>
            <input type="radio" id="ovo" name="payment_method" value="OVO">
            <label for="ovo"><img src="/zetflix/uploads/img_logo/logo_ovo.png" alt="OVO" width="42"></label>
        </div>
        <button id="pay-now">Bayar Sekarang</button>
        <button class="back-button" onclick="history.back()">Kembali</button>
    </div>

    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="">
                <p style="font-size: 1.6em; font-weight: bold;">Metode Pembayaran: <span id="selected-method"></span></p>
                <p style="font-size: 1.6em; font-weight: bold;">Harga Sewa Film: <span id="selected-nominal"></span></p>
                <input type="password" name="password" placeholder="Masukkan password akun Zetflix anda" required>
                <input type="password" name="confirm_password" placeholder="Konfirmasi password Anda" required>
                <input type="hidden" name="payment_method" id="hidden-payment-method">
                <label for="nominal" style="font-size: 1.1em;">Nominal Pembayaran:</label>
                <input type="text" name="nominal" placeholder="Rp" required id="nominal" value="<?php echo number_format($harga_film, 0, ',', '.'); ?>">
                <button type="submit" style="font-size: 1.1em; font-weight: bold;">Bayar</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#pay-now").click(function() {
                let selectedMethod = $("input[name='payment_method']:checked").val();
                if (!selectedMethod) {
                    alert("Pilih metode pembayaran terlebih dahulu.");
                    return;
                }
                let nominal = $("#nominal").val();
                $("#selected-method").text(selectedMethod.toUpperCase());
                $("#selected-nominal").text("Rp " + nominal.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#hidden-payment-method").val(selectedMethod); // Set the selected payment method
                $("#paymentModal").show();
            });

            $(".close").click(function() {
                $("#paymentModal").hide();
                $("#errorModal").hide();
            });

            $("#nominal").on('input', function() {
                let value = $(this).val();
                let formattedValue = value.replace(/\D/g, '');
                let displayValue = "";

                if (formattedValue.length >= 1) {
                    let reverseValue = formattedValue.split('').reverse().join('');
                    displayValue = reverseValue.match(/\d{1,3}/g).join('.').split('').reverse().join('');
                }

                $(this).val(displayValue);
            });

            <?php if ($error): ?>
                $("#errorModal").show();
            <?php endif; ?>
        });
    </script>
</body>
</html>
