<?php

    session_start();
    require "koneksi.php";

    $nama = $_GET['nama'];
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryprodukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>
<style>
/* Styling untuk bagian detail produk */
.container-fluid {
    padding: 5rem 0; /* Menambahkan padding lebih untuk membuat halaman lebih lapang */
}

/* Styling untuk gambar produk */
.col-lg-5 img {
    border-radius: 15px; /* Membuat sudut gambar lebih halus */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Memberikan bayangan halus pada gambar */
    transition: transform 0.3s ease; /* Menambahkan animasi saat gambar dihover */
}

.col-lg-5 img:hover {
    transform: scale(1.05); /* Membesarkan gambar sedikit saat hover */
}

/* Styling untuk bagian informasi produk */
.col-lg-6 h1 {
    font-family: 'Poppins', sans-serif; /* Font yang bersih dan modern */
    font-size: 2.5rem; /* Ukuran font lebih besar untuk judul produk */
    color: #181C14; /* Warna gelap untuk kontras */
    font-weight: 700;
}

.col-lg-6 p {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.2rem;
    color: #3C3D37; /* Warna teks lebih lembut */
    line-height: 1.6;
}

.fs-3 {
    font-size: 1.8rem; /* Ukuran font lebih besar untuk harga produk */
    font-weight: bold;
    color: #FFD700; /* Warna emas untuk harga */
}

.fs-5 {
    font-size: 1.2rem; /* Ukuran font lebih kecil untuk detail stok */
    color: #697565; /* Warna abu-abu gelap */
    font-weight: 600;
}

/* Styling untuk bagian produk terkait */
.warna4 {
    background-color: #ECDFCC; /* Warna latar belakang untuk produk terkait */
}

.warna4 h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 2rem;
    color: #181C14; /* Warna judul produk terkait */
    margin-bottom: 2rem;
}

.produk-terkait-image {
    width: 100%; /* Agar lebar mengikuti container */
    height: 200px; /* Tinggi yang konsisten */
    object-fit: cover; /* Menjaga proporsi gambar */
    border-radius: 8px; /* Menambahkan sudut melengkung untuk tampilan lebih estetis */
}

/* Tambahkan margin antar produk */
.col-md-6.col-lg-3.mb-3 {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Jika ingin menambahkan box-shadow */
.produk-terkait-image:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: 0.3s ease-in-out;
}

/* Styling untuk footer */
footer {
    background-color: #181C14;
    color: white;
    padding: 30px 0;
}

footer .social-icons a {
    font-size: 1.5rem;
    color: #fff;
    margin: 0 15px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #FFD700; /* Efek hover dengan warna emas */
}

footer p {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    margin-top: 15px;
}

/* Styling responsif */
@media (max-width: 768px) {
    .col-lg-5, .col-lg-6 {
        text-align: center;
    }

    .col-lg-5 img {
        width: 100%; /* Membuat gambar produk full width pada perangkat kecil */
    }

    .col-lg-6 h1 {
        font-size: 2rem; /* Ukuran font lebih kecil pada perangkat kecil */
    }

    .col-lg-6 p {
        font-size: 1rem;
    }

    .produk-terkait-image {
        max-width: 100%;
        height: auto;
    }

    footer {
        text-align: center;
    }
}

</style>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="image/<?php echo $produk['foto']?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama'];?></h1>
                    <p clas="fs-5"><?php echo $produk['detail'];?></p>
                    <p class="fs-3">Rp. <?php echo $produk['harga'];?></p>
                    <p class="fs-5"><strong><?php echo $produk['stok'];?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 warna4">
        <div class="container">
            <h2 class="text-center mb-5 ">Produk Terkait</h2>

            <div class="row">
                <?php while($data=mysqli_fetch_array($queryprodukTerkait)){?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $data['nama'];?>">
                        <img src="image/<?php echo $data['foto'];?>" class="img-fluid img-thumbnail produk-terkait-image" alt="">
                    </a>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>

    <footer class="container-fluid bg-dark text-white py-3">
        <div class="container text-center">
            <p>Follow us on</p>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank" class="me-3">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com" target="_blank" class="me-3">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.twitter.com" target="_blank" class="me-3">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <p class="mt-3">&copy; 2025 LookWear. All rights reserved.</p>
        </div>
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>