<?php
session_start();
include 'koneksi.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM tb_film WHERE judul LIKE '%$search%' OR deskripsi LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 70%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        .movie-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .movie-item {
            position: relative;
            width: 29%;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .movie-item:hover {
            transform: translateY(-5px);
        }

        .movie-item img {
            max-width: 100%;
            height: auto;
            border-radius: 18px 18px 0 0;
            object-fit: cover;
        }


        .movie-item h3 {
            padding: 10px;
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .movie-item p {
            padding: 0 10px;
            margin: 5px 0;
            color: #777;
        }

        .movie-item a {
            display: block;
            padding: 10px;
            text-align: center;
            color: #fff;
            background-color: #333;
            text-decoration: none;
            border-radius: 0 0 8px 8px;
            transition: background-color 0.3s ease;
        }

        .movie-item a:hover {
            background-color: #555;
        }

        .no-movies {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container">
        <h1>Search Results</h1>
        <form method="get" action="">
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search for movies...">
            <button type="submit">Search</button>
        </form>
        <div class="movie-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='movie-item'>";
                    echo "<img src='uploads/img_film/".$row['poster']."' alt='".$row['judul']."'>";
                    echo "<h3>".$row['judul']."</h3>";
                    echo "<p>Rating: ".$row['rating']."</p>";
                    echo "<a href='detail_film.php?id=".$row['id_film']."'>Details</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-movies'>No movies found.</p>";
            }
            ?>
        </div>
    </div>
    <?php include 'include/footer.php'; ?>
</body>
</html>

