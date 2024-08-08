<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $sutradara = mysqli_real_escape_string($conn, $_POST['sutradara']);
    $pemeran = mysqli_real_escape_string($conn, $_POST['pemeran']);
    $genre_id = mysqli_real_escape_string($conn, $_POST['genre_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $harga = mysqli_real_escape_string($conn, str_replace('.', '', $_POST['harga'])); // Remove formatting before saving to the database
    $poster = mysqli_real_escape_string($conn, $_FILES['poster']['name']);
    $link_film = mysqli_real_escape_string($conn, $_POST['link_film']); // Tambahkan link_film
    $target_dir = "../uploads/img_film/";
    $target_file = $target_dir . basename($poster);

    if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO tb_film (judul, deskripsi, tahun, sutradara, pemeran, genre_id, rating, harga, poster, link_film) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssdsss", $judul, $deskripsi, $tahun, $sutradara, $pemeran, $genre_id, $rating, $harga, $poster, $link_film);

        // Melakukan eksekusi pernyataan SQL
        if ($stmt->execute()) {
            echo "Film berhasil ditambahkan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$sql = "SELECT * FROM tb_genre";
$genres = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film Baru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="email"],
        form input[type="password"],
        form select,
        form textarea,
        form input[type="file"],
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Film Baru</h1>
        <a href='kelola_film.php'><i class="fas fa-arrow-left"></i> Beranda</a>
        <form action="tambah_film.php" method="POST" enctype="multipart/form-data">
            <label for="judul">Judul:</label><br>
            <input type="text" id="judul" name="judul" required><br>
            
            <label for="deskripsi">Deskripsi:</label><br>
            <textarea id="deskripsi" name="deskripsi" required></textarea><br>
            
            <label for="tahun">Tahun Rilis:</label><br>
            <input type="number" id="tahun" name="tahun" required><br>
            
            <label for="sutradara">Sutradara:</label><br>
            <input type="text" id="sutradara" name="sutradara" required><br>
            
            <label for="pemeran">Pemeran:</label><br>
            <input type="text" id="pemeran" name="pemeran" required><br>
            
            <label for="genre_id">Genre:</label><br>
            <select id="genre_id" name="genre_id" required>
                <?php while ($row = $genres->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_genre']; ?>"><?php echo $row['nama_genre']; ?></option>
                <?php } ?>
            </select><br>
            
            <label for="rating">Rating:</label><br>
            <input type="number" step="0.1" id="rating" name="rating" required><br>
            
            <label for="harga">Harga:</label><br>
            <input type="text" id="harga" name="harga" required onkeyup="formatRupiah(this);"><br>
            
            <label for="poster">Poster:</label><br>
            <input type="file" id="poster" name="poster" required onchange="previewPoster(this);"><br>
            <img id="poster-preview" src="#" alt="Preview Poster" style="display: none; width: 100px;"><br><br>

            <label for="link_film">Link Film:</label><br> <!-- Tambahkan input untuk link_film -->
            <input type="text" id="link_film" name="link_film" required><br>
            
            <input type="submit" value="Tambah Film">
        </form>
    </div>

    <script>
    function previewPoster(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('poster-preview').src = e.target.result;
                document.getElementById('poster-preview').style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function formatRupiah(input) {
        var value = input.value.replace(/\D/g, '');
        var formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = formatted;
    }
    </script>
</body>
</html>
