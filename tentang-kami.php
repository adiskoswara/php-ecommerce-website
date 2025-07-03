<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Tentang Kami</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>
<style>
/* Mengatur latar belakang banner */
.banner2 {
    background-image: url('image/banner.jpg'); /* Ganti dengan gambar yang sesuai */
    background-size: cover;
    background-position: center;
    height: 50vh;
    position: relative;
    color: white;
}

.banner2 .container {
    z-index: 2;
    position: relative;
}

.banner2::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Efek gelap di atas gambar */
    z-index: 1;
}

/* Judul "Tentang Kami" */
.banner2 h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 3.5rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
    margin-top: 20px;
}

/* Styling untuk konten utama */
.container-fluid.py-5 {
    background-color: #f4f4f9;
    padding-top: 5rem;
    padding-bottom: 5rem;
}

.container.fs-5 p {
    font-family: 'Roboto', sans-serif;
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 1.5rem;
    text-align: justify;
}

/* Efek hover pada paragraf */
.container.fs-5 p:hover {
    color: #16A085;
    transition: color 0.3s ease-in-out;
}

/* Footer */
footer {
    background-color: #333;
    padding-top: 2rem;
    padding-bottom: 2rem;
    color: #ddd;
}

footer .social-icons a {
    color: #ddd;
    font-size: 1.5rem;
    margin: 0 15px;
    transition: color 0.3s ease-in-out;
}

footer .social-icons a:hover {
    color: #16A085;
}

/* Copyright text */
footer p {
    font-size: 0.875rem;
    color: #bbb;
}

/* Tombol follow us */
footer p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    font-weight: bold;
}

/* Styling responsif */
@media (max-width: 768px) {
    .banner2 h1 {
        font-size: 2.5rem;
    }
    .container.fs-5 p {
        font-size: 1rem;
    }
}

</style>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container text-center">
            <h1 class="text-white">Tentang Kami</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container fs-5 text-center">
            <p>
            Selamat datang di LookWear, destinasi 
            online terpercaya untuk memenuhi kebutuhan f
            ashion Anda! Kami hadir dengan visi memberikan
             pengalaman belanja yang mudah, nyaman, dan stylish 
             bagi setiap pelanggan. Di LookWear, kami percay
             a bahwa setiap orang berhak tampil percaya diri dengan
              gaya yang mencerminkan kepribadiannya. Oleh karena itu
              , kami menyediakan berbagai koleksi fashion terkini de
              ngan kualitas terbaik dan harga yang terjangkau. Mulai 
              dari pakaian kasual, formal, hoodie hingga sepatu pria m
              aupun wanita, kami menghadirkan pilihan produ
            k yang beragam untuk memenuhi kebutuhan Anda. Dengan 
            sistem belanja yang user-friendly, berbagai metode pemba
            yaran, dan pengiriman cepat, kami memastikan kenyamanan A
            nda adalah prioritas utama. Tim customer service kami jug
            a selalu siap membantu Anda kapan saja untuk memberikan p
            elayanan terbaik. Misi kami adalah menghubungkan tren fash
            ion terbaru dengan gaya hidup Anda, menjadikan Fashionin A
            ja solusi belanja fashion yang pas tanpa ribet!
            </p>

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