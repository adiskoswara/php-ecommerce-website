<?php
require "session.php";
require "../koneksi.php";

$id = mysqli_real_escape_string($con, $_GET['p']);

// Ambil data produk + kategori
$query = mysqli_query($con, "
    SELECT p.*, k.nama_kategori 
    FROM produk p 
    JOIN kategori k ON p.id_kategori = k.id_kategori 
    WHERE p.id_produk = '$id'
");
$data = mysqli_fetch_array($query);

// Ambil kategori selain yang sekarang dipakai produk
$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id_kategori != '{$data['id_kategori']}'");

// Fungsi acak nama file foto
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>form div { margin-bottom: 10px; }</style>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">
    <h2>Detail Produk</h2>

    <div class="col-12 col-md-6 mb-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="nama">Nama Produk</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama_produk']) ?>" class="form-control" required>
            </div>
            <div>
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="<?= $data['id_kategori'] ?>"><?= $data['nama_kategori'] ?></option>
                    <?php while ($kat = mysqli_fetch_array($queryKategori)) { ?>
                        <option value="<?= $kat['id_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="harga">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
            </div>
            <div>
                <label>Foto Saat Ini</label><br>
                <img src="../image/<?= $data['foto'] ?>" width="300px">
            </div>
            <div>
                <label for="foto">Ganti Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div>
                <label for="detail">Detail</label>
                <textarea name="detail" id="detail" class="form-control" rows="5"><?= htmlspecialchars($data['detail']) ?></textarea>
            </div>
            <div>
                <label for="stok">Ketersediaan Stok</label>
                <select name="stok" id="stok" class="form-control">
                    <option value="<?= $data['stok'] ?>"><?= ucfirst($data['stok']) ?></option>
                    <option value="<?= $data['stok'] == 'tersedia' ? 'habis' : 'tersedia' ?>">
                        <?= $data['stok'] == 'tersedia' ? 'Habis' : 'Tersedia' ?>
                    </option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
            </div>
        </form>

        <?php
        if (isset($_POST['simpan'])) {
            $nama = htmlspecialchars($_POST['nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $stok = htmlspecialchars($_POST['stok']);

            $update = mysqli_query($con, "
                UPDATE produk 
                SET nama_produk = '$nama', id_kategori = '$kategori', harga = '$harga', detail = '$detail', stok = '$stok' 
                WHERE id_produk = '$id'
            ");

            // Ganti foto jika di-upload
            if (!empty($_FILES['foto']['name'])) {
                $nama_file = $_FILES["foto"]["name"];
                $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20) . "." . $imageFileType;

                if ($image_size > 500000) {
                    echo '<div class="alert alert-warning mt-3">Ukuran gambar terlalu besar</div>';
                } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<div class="alert alert-warning mt-3">Format file tidak didukung</div>';
                } else {
                    move_uploaded_file($_FILES["foto"]["tmp_name"], "../image/" . $random_name);
                    mysqli_query($con, "UPDATE produk SET foto = '$random_name' WHERE id_produk = '$id'");
                }
            }

            if ($update) {
                echo '<div class="alert alert-success mt-3">Produk berhasil diperbarui</div>';
                echo '<meta http-equiv="refresh" content="2;url=produk.php">';
            } else {
                echo '<div class="alert alert-danger mt-3">Gagal memperbarui produk</div>';
            }
        }

        if (isset($_POST['hapus'])) {
            $hapus = mysqli_query($con, "DELETE FROM produk WHERE id_produk = '$id'");
            if ($hapus) {
                echo '<div class="alert alert-danger mt-3">Produk berhasil dihapus</div>';
                echo '<meta http-equiv="refresh" content="2;url=produk.php">';
            }
        }
        ?>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
