<?php
session_start();
require "koneksi.php";

// Pastikan keranjang tidak kosong
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total_harga = 0;

$produk_list = "";

// Pastikan semua item dalam keranjang memiliki jumlah
foreach ($_SESSION['cart'] as $key => $item) {
    if (!isset($item['jumlah']) || $item['jumlah'] <= 0) {
        $_SESSION['cart'][$key]['jumlah'] = 1; // Atur nilai default jika jumlah tidak ada
    }
    $total_harga += $_SESSION['cart'][$key]['harga'] * $_SESSION['cart'][$key]['jumlah'];
    $produk_list .= htmlspecialchars($item['nama']) . " (x" . $_SESSION['cart'][$key]['jumlah'] . ") - Rp. " . number_format($_SESSION['cart'][$key]['harga'] * $_SESSION['cart'][$key]['jumlah']) . "\n";
}

// Proses pesanan jika tombol checkout ditekan
if (isset($_POST['checkout'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $telepon = htmlspecialchars($_POST['telepon']);
    
    // Simpan data ke database
    $query = "INSERT INTO orders (nama, email, alamat, telepon, total_harga) VALUES ('$nama', '$email', '$alamat', '$telepon', '$total_harga')";
    mysqli_query($con, $query);
    
    // Dapatkan ID order terbaru
    $order_id = mysqli_insert_id($con);
    
    // Simpan notifikasi untuk admin
    $notif_message = "Pesanan baru dari $nama, email : $email, alamat : $alamat, no telp : $telepon telah dibuat. Produk yang dibeli:\n" . $produk_list;
    $notif_query = "INSERT INTO notifications (message, status) VALUES ('$notif_message', 'unread')";
    mysqli_query($con, $notif_query);
    
    // Kosongkan keranjang
    unset($_SESSION['cart']);
    
    // Redirect ke halaman sukses
    header("Location: payment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Checkout</h3>
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>    
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
            <h4>Ringkasan Belanja</h4>
            <ul class="list-group mb-3">
                <?php foreach ($_SESSION['cart'] as $item) { ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($item['nama']); ?> (x<?php echo isset($item['jumlah']) ? $item['jumlah'] : 1; ?>) - Rp. <?php echo number_format($item['harga'] * (isset($item['jumlah']) ? $item['jumlah'] : 1)); ?>
                    </li>
                <?php } ?>
            </ul>
            <h4>Total: Rp. <?php echo number_format($total_harga); ?></h4>
            <button type="submit" name="checkout" class="btn btn-success">Bayar Sekarang</button>
            <a href="cart.php" class="btn btn-secondary">Kembali ke Keranjang</a>
        </form>
    </div>
</body>
</html>
