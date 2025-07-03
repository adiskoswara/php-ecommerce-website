<?php
session_start();
require "koneksi.php";

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Menangani tombol tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $foto = $_POST['foto'];

    // Cek apakah produk sudah ada di keranjang
    $index = array_search($id, array_column($_SESSION['cart'], 'id'));
    if ($index !== false) {
        $_SESSION['cart'][$index]['qty'] += 1;
    } else {
        $_SESSION['cart'][] = [
            'id' => $id,
            'nama' => $nama,
            'harga' => $harga,
            'foto' => $foto,
            'qty' => 1
        ];
    }
    header("Location: produk.php");
    exit();
}

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($con, $_GET['keyword']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%'");
} elseif (isset($_GET['kategori'])) {
    $kategoriNama = mysqli_real_escape_string($con, $_GET['kategori']);
    $queryGetKategoriId = mysqli_query($con, "SELECT id_kategori FROM kategori WHERE nama_kategori='$kategoriNama'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    if ($kategoriId) {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id_kategori='" . $kategoriId['id_kategori'] . "'");
    } else {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE 1=0"); // kategori tidak ditemukan
    }
} else {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
}

$countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container-fluid banner2 d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white">Produk</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-5">
            <h3>Kategori</h3>
            <ul class="list-group">
                <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                    <a href="produk.php?kategori=<?php echo $kategori['nama_kategori']; ?>">
                        <li class="list-group-item"><?php echo $kategori['nama_kategori']; ?></li>
                    </a>
                <?php } ?>
            </ul>
        </div>
        <div class="col-lg-9">
            <h3 class="text-center mb-3">Produk</h3>
            <div class="row">
                <?php if ($countData < 1) { ?>
                    <h4 class="text-center my-5">Produk Tidak Tersedia</h4>
                <?php } ?>
                <?php while ($produk = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 d-flex flex-column">
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title"><?php echo $produk['nama_produk']; ?></h4>
                                <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                <p class="card-text text-harga">Rp. <?php echo number_format($produk['harga']); ?></p>
                                <div class="mt-auto">
                                    <a href="produk-detail.php?nama=<?php echo $produk['nama_produk'] ?>" class="btn btn-secondary w-100 mb-2">Detail</a>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?php echo $produk['id_produk']; ?>">
                                        <input type="hidden" name="nama" value="<?php echo $produk['nama_produk']; ?>">
                                        <input type="hidden" name="harga" value="<?php echo $produk['harga']; ?>">
                                        <input type="hidden" name="foto" value="<?php echo $produk['foto']; ?>">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Tambah ke Keranjang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid bg-dark text-white py-3">
    <div class="container text-center">
        <p>Follow us on</p>
        <div class="social-icons">
            <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p class="mt-3">&copy; 2025 FASHIONIN AJA. All rights reserved.</p>
    </div>
</footer>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>
