<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: "SF Pro Display", "Arial", sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            padding: 20px;
            max-width: 1200px;
        }

        .dashboard-item {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
        }

        .dashboard-item:hover {
            transform: translateY(-5px);
        }

        .dashboard-item i {
            font-size: 36px;
            color: #333;
            margin-bottom: 10px;
        }

        .dashboard-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333333;
            margin-bottom: 10px;
        }

        .dashboard-item p {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }

        /* Navbar */
        .navbar {
            margin-bottom: 180px;
        }

        /* Footer */
        .footer {
            margin-top: 180px;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    <h1>Admin Dashboard</h1>
    <div class="dashboard-container">
        <button class="dashboard-item" onclick="location.href='kelola_user.php'">
            <i class="fas fa-users"></i>
            <h3>Kelola Users</h3>
            <p>Kelola daftar pengguna</p>
        </button>
        <button class="dashboard-item" onclick="location.href='kelola_film.php'">
            <i class="fas fa-film"></i>
            <h3>Kelola Films</h3>
            <p>Kelola database film</p>
        </button>
        <button class="dashboard-item" onclick="location.href='kelola_ulasan.php'">
            <i class="fas fa-comments"></i>
            <h3>Kelola Ulasan</h3>
            <p>Kelola Manager Review</p>
        </button>
        <button class="dashboard-item" onclick="location.href='kelola_sewafilm.php'">
            <i class="fas fa-video"></i>
            <h3>Kelola Sewa Films</h3>
            <p>Kelola pengguna yang menyewa film</p>
        </button>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
