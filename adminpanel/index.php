<?php
require "session.php";
require "../koneksi.php";

// Validasi akses admin
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil data kategori & produk
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);

// Ambil notifikasi
$queryNotif = mysqli_query($con, "SELECT * FROM notifications ORDER BY id DESC");
$jumlahNotif = mysqli_num_rows($queryNotif);

// Tandai sebagai sudah dibaca
if (isset($_POST['mark_as_read'])) {
    mysqli_query($con, "UPDATE notifications SET status = 'read' WHERE status = 'unread'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fashion</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f8f8f8;
            font-family: 'Roboto', sans-serif;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: #f7d54a;
            font-size: 28px;
            font-weight: bold;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInMove 1.5s ease forwards;
        }

        @keyframes fadeInMove {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #f7d54a;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #fff;
        }

        .summary-box {
            background: linear-gradient(145deg, #2e2e2e, #3c3c3c);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.7);
        }

        .summary-box i {
            color: #f7d54a;
        }

        .summary-box h3 {
            font-family: 'Playfair Display', serif;
            color: #f7d54a;
        }

        .summary-box p {
            color: #f8f8f8;
        }

        .no-decoration {
            text-decoration: none;
            color: #f7d54a;
        }

        .no-decoration:hover {
            text-decoration: underline;
        }

        .notif-box {
            background: #2e2e2e;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.5);
        }

        .notif-box h4 {
            color: #f7d54a;
        }

        .notif-list {
            max-height: 250px;
            overflow-y: auto;
        }

        .notif-item {
            background: #3c3c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .notif-time {
            font-size: 12px;
            color: #aaa;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>

<body>

    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><i class="fas fa-home"></i> Home</li>
            </ol>
        </nav>

        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <div class="row mt-5">
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-box p-4">
                    <div class="row">
                        <div class="col-6"><i class="fas fa-align-justify fa-7x"></i></div>
                        <div class="col-6">
                            <h3>Kategori</h3>
                            <p><?php echo $jumlahKategori; ?> Kategori</p>
                            <p><a href="kategori.php" class="no-decoration">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-box p-4">
                    <div class="row">
                        <div class="col-6"><i class="fas fa-box fa-7x"></i></div>
                        <div class="col-6">
                            <h3>Produk</h3>
                            <p><?php echo $jumlahProduk; ?> Produk</p>
                            <p><a href="produk.php" class="no-decoration">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="notif-box">
            <h4>Notifikasi Pesanan (<?php echo $jumlahNotif; ?>)</h4>
            <div class="notif-list">
                <?php while ($notif = mysqli_fetch_assoc($queryNotif)) { ?>
                    <div class="notif-item">
                        <i class="fas fa-bell"></i> <?php echo htmlspecialchars($notif['message']); ?>
                        <small class="notif-time d-block"><?php echo $notif['status']; ?></small>
                    </div>
                <?php } ?>

                <?php if ($jumlahNotif == 0) { ?>
                    <div class="text-muted">Tidak ada notifikasi baru.</div>
                <?php } ?>
            </div>

            <?php if ($jumlahNotif > 0) { ?>
                <form method="post" class="mt-3">
                    <button type="submit" name="mark_as_read" class="btn btn-primary">Tandai Semua Sudah Dibaca</button>
                </form>
            <?php } ?>
        </div>

        <footer class="mt-5">
            &copy; <?php echo date("Y"); ?> Dashboard Fashion. All rights reserved.
        </footer>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>