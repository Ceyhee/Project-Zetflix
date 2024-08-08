<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_film = $_POST['id_film'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $sutradara = mysqli_real_escape_string($conn, $_POST['sutradara']);
    $pemeran = mysqli_real_escape_string($conn, $_POST['pemeran']);
    $genre_id = mysqli_real_escape_string($conn, $_POST['genre_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $harga = mysqli_real_escape_string($conn, str_replace('.', '', $_POST['harga'])); // Remove formatting before saving to the database
    $link_film = mysqli_real_escape_string($conn, $_POST['link_film']); // Tambahkan link_film
    
    // Jika gambar diunggah, proses upload
    if (!empty($_FILES['poster']['name'])) {
        $poster = mysqli_real_escape_string($conn, $_FILES['poster']['name']);
        $target_dir = "../uploads/img_film/";
        $target_file = $target_dir . basename($poster);
        
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            // Jika berhasil diupload, update dengan poster baru
            $sql = "UPDATE tb_film SET judul=?, deskripsi=?, tahun=?, sutradara=?, pemeran=?, genre_id=?, rating=?, harga=?, poster=?, link_film=? WHERE id_film=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisssdsssi", $judul, $deskripsi, $tahun, $sutradara, $pemeran, $genre_id, $rating, $harga, $poster, $link_film, $id_film);
        } else {
            // Jika gagal diupload, update tanpa mengubah poster
            $sql = "UPDATE tb_film SET judul=?, deskripsi=?, tahun=?, sutradara=?, pemeran=?, genre_id=?, rating=?, harga=?, link_film=? WHERE id_film=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisssdssi", $judul, $deskripsi, $tahun, $sutradara, $pemeran, $genre_id, $rating, $harga, $link_film, $id_film);
        }
    } else {
        // Jika tidak ada gambar yang diunggah, update tanpa mengubah poster
        $sql = "UPDATE tb_film SET judul=?, deskripsi=?, tahun=?, sutradara=?, pemeran=?, genre_id=?, rating=?, harga=?, link_film=? WHERE id_film=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssdssi", $judul, $deskripsi, $tahun, $sutradara, $pemeran, $genre_id, $rating, $harga, $link_film, $id_film);
    }

    if ($stmt->execute()) {
        echo "Film berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data film yang akan di-edit
if (isset($_GET['id'])) {
    $id_film = $_GET['id'];
    $sql = "SELECT * FROM tb_film WHERE id_film=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_film);
    $stmt->execute();
    $result = $stmt->get_result();
    $film = $result->fetch_assoc();
} else {
    // Redirect jika tidak ada ID yang diberikan
    header("Location: kelola_film.php");
    exit();
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
    <title>Edit Film</title>
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
        <h1>Edit Film</h1>
        <a href='kelola_film.php'><i class="fas fa-arrow-left"></i> Kembali</a>
        <form action="edit_film.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_film" value="<?php echo $film['id_film']; ?>">
            
            <label for="judul">Judul:</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo $film['judul']; ?>" required><br>
            
            <label for="deskripsi">Deskripsi:</label><br>
            <textarea id="deskripsi" name="deskripsi" required><?php echo $film['deskripsi']; ?></textarea><br>
            
            <label for="tahun">Tahun Rilis:</label><br>
            <input type="number" id="tahun" name="tahun" value="<?php echo $film['tahun']; ?>" required><br>
            
            <label for="sutradara">Sutradara:</label><br>
            <input type="text" id="sutradara" name="sutradara" value="<?php echo $film['sutradara']; ?>" required><br>
            
            <label for="pemeran">Pemeran:</label><br>
            <input type="text" id="pemeran" name="pemeran" value="<?php echo $film['pemeran']; ?>" required><br>
            
            <label for="genre_id">Genre:</label><br>
            <select id="genre_id" name="genre_id" required>
                <?php 
                while ($row = $genres->fetch_assoc()) { 
                    if ($row['id_genre'] == $film['genre_id']) {
                        echo "<option value='".$row['id_genre']."' selected>".$row['nama_genre']."</option>";
                    } else {
                        echo "<option value='".$row['id_genre']."'>".$row['nama_genre']."</option>";
                    }
                } 
                ?>
            </select><br>
            
            <label for="rating">Rating:</label><br>
            <input type="number" step="0.1" id="rating" name="rating" value="<?php echo $film['rating']; ?>" required><br>
            
            <label for="harga">Harga:</label><br>
            <input type="text" id="harga" name="harga" value="<?php echo number_format($film['harga'], 0, ',', '.'); ?>" required onkeyup="formatRupiah(this);"><br>
            
            <label for="poster">Poster:</label><br>
            <input type="file" id="poster" name="poster" onchange="previewPoster(this);"><br>
            <img id="poster-preview" src="../uploads/img_film/<?php echo $film['poster']; ?>" alt="Preview Poster" style="width: 100px;"><br><br>

            <label for="link_film">Link Film:</label><br>
            <input type="text" id="link_film" name="link_film" value="<?php echo $film['link_film']; ?>" required><br>
            
            <input type="submit" value="Perbarui Film">
        </form>
    </div>

    <script>
    function previewPoster(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('poster-preview').src = e.target.result;
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
