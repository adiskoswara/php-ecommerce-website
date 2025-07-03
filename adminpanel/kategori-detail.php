<?php
require "session.php";
require "../koneksi.php";

// Validasi parameter 'p'
$id = isset($_GET['p']) ? mysqli_real_escape_string($con, $_GET['p']) : null;

if (!$id) {
    echo "<script>alert('ID kategori tidak ditemukan'); window.location='kategori.php';</script>";
    exit;
}

// Ambil data kategori berdasarkan ID
$query = mysqli_query($con, "SELECT * FROM kategori WHERE id_kategori = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Data kategori tidak ditemukan'); window.location='kategori.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container mt-5">
    <h2>Detail Kategori</h2>

    <div class="col-12 col-md-6">
        <form action="" method="post">
            <div class="mb-3">
                <label for="kategori">Nama Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control"
                       value="<?php echo htmlspecialchars($data['nama_kategori']); ?>" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" name="editBtn" class="btn btn-warning">Edit</button>
                <button type="submit" name="deleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </form>

        <?php
        // Tombol Edit
        if (isset($_POST['editBtn'])) {
            $kategoriBaru = htmlspecialchars($_POST['kategori']);

            if ($data['nama_kategori'] == $kategoriBaru) {
                echo '<meta http-equiv="refresh" content="0; url=kategori.php" />';
            } else {
                $cekDuplikat = mysqli_query($con, "SELECT * FROM kategori WHERE nama_kategori = '$kategoriBaru'");
                if (mysqli_num_rows($cekDuplikat) > 0) {
                    echo '<div class="alert alert-warning mt-3">Kategori sudah ada.</div>';
                } else {
                    $update = mysqli_query($con, "UPDATE kategori SET nama_kategori = '$kategoriBaru' WHERE id_kategori = '$id'");
                    if ($update) {
                        echo '<div class="alert alert-success mt-3">Kategori berhasil diperbarui.</div>';
                        echo '<meta http-equiv="refresh" content="2; url=kategori.php" />';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Gagal memperbarui kategori.</div>';
                    }
                }
            }
        }

        // Tombol Delete
        if (isset($_POST['deleteBtn'])) {
            $cekProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '$id'");
            if (mysqli_num_rows($cekProduk) > 0) {
                echo '<div class="alert alert-warning mt-3">Kategori tidak bisa dihapus karena digunakan oleh produk.</div>';
            } else {
                $hapus = mysqli_query($con, "DELETE FROM kategori WHERE id_kategori = '$id'");
                if ($hapus) {
                    echo '<div class="alert alert-success mt-3">Kategori berhasil dihapus.</div>';
                    echo '<meta http-equiv="refresh" content="2; url=kategori.php" />';
                } else {
                    echo '<div class="alert alert-danger mt-3">Gagal menghapus kategori.</div>';
                }
            }
        }
        ?>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
