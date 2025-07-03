<nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-3">
                    <a class="nav-link " href="../adminpanel">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="kategori.php">Kategori</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="produk.php">Produk</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar Styling */
    .custom-navbar {
        background-color: #2c2c2c; /* Abu-abu gelap */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Shadow untuk menonjolkan navbar */
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%280, 0, 0, 0.7%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-nav .nav-link {
        font-size: 1.1rem;
        font-weight: bold;
        color: #f0f0f0; /* Warna putih terang */
        transition: color 0.3s ease, transform 0.3s ease; /* Efek transisi untuk hover */
    }

    .navbar-nav .nav-link:hover {
        color: #ffa500; /* Warna oranye untuk hover */
        transform: scale(1.1); /* Sedikit membesar saat di-hover */
    }

    .navbar-nav .active {
        color: #ffa500; /* Warna aktif */
        border-bottom: 2px solid #ffa500; /* Garis bawah untuk halaman aktif */
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .navbar-nav .nav-link {
            font-size: 1rem; /* Sedikit lebih kecil di layar kecil */
        }
    }
</style>
