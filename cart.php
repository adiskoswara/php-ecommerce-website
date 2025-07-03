<?php
session_start();
require "koneksi.php";

// Tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = floatval($_POST['harga']);
    $foto = $_POST['foto'];
    $jumlah = 1;

    $item = [
        'id_produk' => $id_produk,
        'nama_produk' => $nama_produk,
        'harga' => $harga,
        'foto' => $foto,
        'jumlah' => $jumlah
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id_produk'] == $id_produk) {
            $_SESSION['cart'][$key]['jumlah'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $item;
    }

    header("Location: cart.php");
    exit();
}

// Hapus item dari keranjang
if (isset($_GET['remove'])) {
    $id_produk = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id_produk'] == $id_produk) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break;
        }
    }
    header("Location: cart.php");
    exit();
}

// Update jumlah produk
if (isset($_POST['update_cart']) && isset($_POST['jumlah'])) {
    foreach ($_POST['jumlah'] as $id_produk => $jumlah) {
        $jumlah = intval($jumlah);
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id_produk'] == $id_produk) {
                $_SESSION['cart'][$key]['jumlah'] = max(1, $jumlah);
                break;
            }
        }
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Keranjang Belanja</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $total_belanja = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) { 
                    $harga = floatval($item['harga']);
                    $jumlah = intval($item['jumlah']);
                    $total_harga = $harga * $jumlah;
                    $total_belanja += $total_harga;
            ?>
            <tr>
                <td><img src="image/<?php echo htmlspecialchars($item['foto']); ?>" width="60" height="60"></td>
                <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                <td>Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                <td>
                    <form method="post" class="d-flex">
                        <input type="number" class="form-control me-2" style="width: 80px;" name="jumlah[<?php echo htmlspecialchars($item['id_produk']); ?>]" value="<?php echo $jumlah; ?>" min="1">
                        <button type="submit" name="update_cart" class="btn btn-warning btn-sm">Update</button>
                    </form>
                </td>
                <td>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                <td><a href="cart.php?remove=<?php echo htmlspecialchars($item['id_produk']); ?>" class="btn btn-danger btn-sm">Hapus</a></td>
            </tr>
            <?php 
                } 
            } else { ?>
            <tr>
                <td colspan="6" class="text-center">Keranjang kosong</td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total Belanja: Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></h4>
        </div>

        <div class="mt-3">
            <a href="checkout.php" class="btn btn-success">Checkout</a>
            <a href="index.php" class="btn btn-primary">Lanjut Belanja</a>
        </div>
    </div>
</body>
</html>
