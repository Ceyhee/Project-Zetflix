<?php
session_start();
include 'koneksi.php';

// Fungsi untuk menampilkan pesan selamat datang sesuai dengan tipe pengguna
function showWelcomeMessage() {
    if (!isset($_SESSION['user_name'])) {
        echo "Welcome, Guest, to Zetflix";
    } elseif ($_SESSION['user_role'] == 'admin') {
        echo "Welcome, Admin, to Zetflix";
    } else {
        echo "Welcome, " . htmlspecialchars($_SESSION['user_name']) . ", to Zetflix";
    }
}

// Fungsi untuk menampilkan pesan akses sesuai dengan tipe pengguna
function showAccessMessage() {
    if (!isset($_SESSION['user_name'])) {
        echo "Please <a href='user/user_login.php'>login</a> to access all features.";
    } elseif ($_SESSION['user_role'] == 'admin') {
        echo "Go to <a href='admin/index.php'>Admin Panel</a> to control the website.";
    } else {
        echo "What are you watching today?";
    }
}

$sql = "SELECT * FROM tb_film ORDER BY rating DESC";
$result = $conn->query($sql);
$films = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetflix - Home</title>
    <link rel="icon" type="image/x-icon" href="./uploads/img_logo/favicon-32x32.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-4GzYj0JvG3j5Jv2g+PAtqeViWchxdOWH01J1ntbT0Mz43sKcwkgBcHhejxVjizmqXklFl8DwZy81QNIj2B/xLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding-top: 20px; /* Tambahkan padding ke bagian atas body */
        }
        .welcome-text {
            font-family: 'Brush Script MT', cursive;
            font-size: 70px;
            color: #333;
            margin-bottom: 20px;
        }
        .user-type {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .user-type i {
            color: gold; /* Warna kuning untuk ikon bintang */
        }
        .movie-item {
            position: relative;
            margin-bottom: 20px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .movie-item img {
            cursor: pointer;
            width: 100%;
            border-radius: 8px;
            object-fit: cover; /* Poster akan menyesuaikan dengan ukuran container */
            transition: transform 0.3s; /* Efek transisi ketika gambar dihover */
        }
        .movie-item img:hover {
            transform: scale(1.05); /* Memperbesar gambar saat dihover */
        }
        .movie-details {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Transparan hitam */
            padding: 10px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            transition: 0.3s; /* Efek transisi */
            opacity: 0; /* Awalnya tidak terlihat */
        }
        .movie-item:hover .movie-details {
            opacity: 1; /* Munculkan detail saat dihover */
        }
        .movie-details .movie-title, .movie-details .movie-rating, .movie-details .movie-actions {
            color: #fff;
            margin: 0;
        }
        .movie-actions a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s; /* Efek transisi warna */
        }
        .movie-actions a:hover {
            color: #ffd700; /* Warna kuning saat dihover */
        }
        /* Stylize modal */
        .modal-content {
            border-radius: 15px;
            background-color: rgba(0, 0, 0, 0.8); /* Warna latar belakang */
            color: #fff; /* Warna teks */
        }
        .modal-body {
            padding: 20px;
        }
        .modal-title {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffd700; /* Warna judul modal */
        }
        .modal-rating {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .modal-actions {
            text-align: right;
        }
        /* Stylize trailer carousel */
        #trailerCarousel {
            height: 400px;
            width: 400px; /* Atur lebar carousel */
            margin-left: auto; /* Geser ke kiri */
        }
        /* CSS untuk informasi film */
        /* CSS untuk informasi film */
        .film-info {
            display: flex;
            flex-direction: column;
            position: absolute;
            bottom: 0;
            right: 0;
            margin-bottom: 10px; /* Atur jarak antara trailer carousel dan informasi film */
            margin-right: 310px; /* Atur jarak antara trailer carousel dan informasi film */
            background-color: rgba(255, 255, 255, 0.7); /* Transparansi latar belakang */
            padding: 10px;
            border-radius: 8px;
        }

        .film-info h3 {
            margin-top: 0; /* Reset margin atas */
            margin-bottom: 0px; /* Atur jarak bawah judul */
        }

        .film-info ul {
            list-style-type: none; /* Hilangkan bullet list */
            padding: 0;
        }

        .film-info ul li {
            margin-bottom: 5px; /* Atur jarak antara setiap item */
        }

        .film-info ul li i {
            margin-right: 5px; /* Atur jarak antara ikon dan teks */
        }

        /* Gaya untuk ikon media sosial */
        .social-icons {
            position: absolute;
            bottom: 0;
            right: 0;
            margin-bottom: 20px;
            margin-right: 70px;
        }

        .social-icon {
            display: inline-block;
            margin-left: 30px; /* Atur jarak antara ikon media sosial */
            color: #333;
            font-size: 50px;
        }

        .social-icon:hover {
            color: #007bff; /* Warna ikon saat dihover */
        }
        

        
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container">
        <h1 class="welcome-text">
            <?php showWelcomeMessage(); ?>
        </h1>
        <p class="user-type">
            <?php showAccessMessage(); ?>
        </p>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <?php foreach ($films as $film) { ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="movie-item">
                                <?php if (!empty($film['poster'])) { ?>
                                    <img src="uploads/img_film/<?php echo $film['poster']; ?>" alt="<?php echo htmlspecialchars($film['judul']); ?>" onclick="showPoster('uploads/img_film/<?php echo $film['poster']; ?>', '<?php echo htmlspecialchars($film['judul']); ?>', '<?php echo htmlspecialchars($film['rating']); ?>', 'detail_film.php?id=<?php echo htmlspecialchars($film['id_film']); ?>')">
                                <?php } else { ?>
                                    <p class="text-center">Poster not available</p>
                                <?php } ?>
                                <div class="movie-details">
                                    <h4 class="movie-title"><?php echo htmlspecialchars($film['judul']); ?></h4>
                                    <p class="movie-rating">Rating: <?php echo htmlspecialchars($film['rating']); ?> <i class="fas fa-star text-warning"></i></p>
                                    <div class="movie-actions">
                                        <a href="detail_film.php?id=<?php echo htmlspecialchars($film['id_film']); ?>"><i class="fas fa-info-circle"></i> Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Trailer Carousel -->
                <h3>Trailer Video</h3>
            <div id="trailerCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg" style="border: 2px solid #ccc; overflow: hidden;">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/lV1OOlGwExM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg" style="border: 2px solid #ccc; overflow: hidden;">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/FVswuip0-co" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg" style="border: 2px solid #ccc; overflow: hidden;">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/YPY7J-flzE8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg" style="border: 2px solid #ccc; overflow: hidden;">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/3PsP8MFH8p0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg" style="border: 2px solid #ccc; overflow: hidden;">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/DGcJFwFMj9Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#trailerCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#trailerCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            </div>
        </div>
    </div>
    <div class="film-info">
    <h3>Informasi Film</h3>
        <ul>
            <li>
                <i class="fab fa-imdb"></i> <a href="https://www.imdb.com/">IMDb</a>: 8.0/10
            </li>
            <li>
                <i class="fas fa-film fa-icon"></i> <a href="https://www.metacritic.com/">Metacritic</a>: 75/100
            </li>
            <li>
                <i class="fab fa-youtube"></i> <a href="https://www.youtube.com/">Youtube</a>: 72/100
            </li>
            <li>
                <i class="fas fa-film fa-icon"></i> <a href="http://www.impawards.com/">impawards</a>: 60/100
            </li>
            <!-- Tambahkan informasi lainnya di sini -->
        </ul>
    </div>
        <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <!-- Tambah ikon media sosial lainnya jika diperlukan -->
        </div>

    <?php include 'include/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    function showPoster(posterPath, judul, rating, detailLink) {
        // Munculkan modal untuk menampilkan gambar poster dan informasi film
        $('#posterModal').modal('show');
        
        // Isi data poster dan informasi film ke dalam modal
        $('#posterImage').attr('src', posterPath);
        $('#posterModalLabel').text(judul);
        $('.modal-rating').html('Rating: ' + rating + ' <i class="fas fa-star text-warning"></i>');
        
        // Atur tautan tombol detail
        $('#detailButton').attr('href', detailLink);
    }
</script>


    <!-- Modal -->
<div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="posterImage" src="" class="img-fluid rounded" alt="Poster">
                <h5 class="modal-title mt-3" id="posterModalLabel"></h5>
                <p class="modal-rating"></p>
                <div class="modal-actions">
                    <a id="detailButton" class="btn btn-primary" href="#" role="button">Details</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

