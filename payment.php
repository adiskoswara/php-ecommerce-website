<?php
session_start();

// Bersihkan sesi keranjang setelah pembayaran sukses
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        .success-container {
            text-align: center;
            margin-top: 50px;
        }
        .success-icon {
            font-size: 80px;
            color: green;
        }
        .order-info {
            font-size: 18px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h2>Pembayaran Berhasil!</h2>
        <p class="order-info">Terima kasih telah berbelanja di toko kami.</p>
        <a href="index.php" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
