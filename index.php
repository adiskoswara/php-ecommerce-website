<?php
session_start();
require "koneksi.php";

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Menangani tombol tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id_produk'];
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $foto = $_POST['foto'];

    // Cek apakah produk sudah ada di keranjang
    $index = array_search($id, array_column($_SESSION['cart'], 'id_produk'));
    if ($index !== false) {
        $_SESSION['cart'][$index]['qty'] += 1;
    } else {
        $_SESSION['cart'][] = [
            'id_produk' => $id,
            'nama_produk' => $nama,
            'harga' => $harga,
            'foto' => $foto,
            'qty' => 1
        ];
    }
    header("Location: index.php");
    exit();
}

// Menampilkan produk
$queryProduk = mysqli_query($con, "SELECT id_produk, nama_produk, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php require "navbar.php"; ?>

<div class="container-fluid banner d-flex align-items-center">
    <div class="container text-center">
        <h1>LookWear</h1>
        <h3>Nyari Apa?</h3>
        <div class="col-md-8 offset-3">
            <form method="get" action="produk.php">
                <div class="input-group input-group-lg my-3">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari Produk" required>
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container text-center">
        <h3>Kategori Terlaris</h3>
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="highlighted-kategori kategori-kaos d-flex justify-content-center align-items-center">
                    <h4 class="text-white"><a href="produk.php?kategori=kaos">Kaos</a></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="highlighted-kategori kategori-hoodie d-flex justify-content-center align-items-center">
                    <h4><a href="produk.php?kategori=hoodie">Hoodie</a></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                    <h4 class="text-white"><a href="produk.php?kategori=sepatu">Sepatu</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid warna4 py-5">
    <div class="container text-center">
        <h3>Tentang Kami</h3>
        <p class="fs-5 mt-3">
            Selamat datang di LookWear, destinasi online terpercaya untuk kebutuhan fashion Anda! Kami hadir untuk memberikan pengalaman belanja mudah dan stylish. Mulai dari pakaian kasual, hoodie, hingga sepatu, kami punya semuanya. Dengan sistem belanja yang user-friendly, pengiriman cepat, dan harga terjangkau, LookWear adalah solusi fashion tanpa ribet!
        </p>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container text-center">
        <h3>Produk</h3>
        <div class="row mt-5">
            <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama_produk']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp. <?php echo number_format($data['harga']); ?></p>

                            <form method="post">
                                <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
                                <input type="hidden" name="nama_produk" value="<?php echo $data['nama_produk']; ?>">
                                <input type="hidden" name="harga" value="<?php echo $data['harga']; ?>">
                                <input type="hidden" name="foto" value="<?php echo $data['foto']; ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>

                            <a href="produk-detail.php?id=<?php echo $data['id_produk']; ?>" class="btn btn-secondary mt-2">Detail</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <a class="btn btn-outline-secondary mt-3" href="produk.php">Lihat Semua</a>
    </div>
</div>

<footer class="container-fluid bg-dark text-white py-3">
    <div class="container text-center">
        <p>Follow us on</p>
        <div class="social-icons">
            <a href="https://www.facebook.com" target="_blank" class="me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com" target="_blank" class="me-3"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com" target="_blank" class="me-3"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p class="mt-3">&copy; 2025 LookWear. All rights reserved.</p>
    </div>
</footer>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>
