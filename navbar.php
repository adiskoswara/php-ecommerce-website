<?php
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">LookWear</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produk.php">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang-kami.php">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                            <?php echo $cart_count; ?>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>
    .custom-navbar {
        background-color: #2c2c2c;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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
        color: #f0f0f0;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover {
        color: #ffa500;
        transform: scale(1.1);
    }
    
    .navbar-nav .active {
        color: #ffa500;
        border-bottom: 2px solid #ffa500;
    }
    
    .badge {
        font-size: 0.8rem;
    }
    
    @media (max-width: 991.98px) {
        .navbar-nav .nav-link {
            font-size: 1rem;
        }
    }
</style>
