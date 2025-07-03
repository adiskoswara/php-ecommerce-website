<?php
require "session.php";
require "../koneksi.php";

// Query produk dan kategori
$query = mysqli_query($con, "SELECT a.*, b.nama_kategori FROM produk a JOIN kategori b ON a.id_kategori = b.id_kategori");
$jumlahProduk = mysqli_num_rows($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// Fungsi generate nama file acak
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<style>
    .no-decoration { text-decoration: none; }
    form div { margin-bottom: 10px; }
</style>

<body>
<?php require "navbar.php"; ?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="../adminpanel" class="no-decoration text-muted">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Produk</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Form Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama Produk</label>
                    <input type="text" id="nama" name="nama_produk" class="form-control" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="id_kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Satu</option>
                        <?php while ($data = mysqli_fetch_array($queryKategori)) { ?>
                            <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama_produk = htmlspecialchars($_POST['nama_produk']);
                $id_kategori = htmlspecialchars($_POST['id_kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $stok = htmlspecialchars($_POST['stok']);
                $detail = htmlspecialchars($_POST['detail']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if (empty($nama_produk) || empty($id_kategori) || empty($harga)) {
                    echo '<div class="alert alert-warning mt-3">Nama, kategori, dan harga wajib diisi</div>';
                } else {
                    if (!empty($nama_file)) {
                        if ($image_size > 500000) {
                            echo '<div class="alert alert-warning mt-3">File tidak boleh lebih dari 500 kb</div>';
                        } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
                            echo '<div class="alert alert-warning mt-3">File wajib bertipe jpg, png, atau gif</div>';
                        } else {
                            move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_name);
                        }
                    } else {
                        $new_name = "";
                    }

                    $queryTambah = mysqli_query($con, "INSERT INTO produk (id_kategori, nama_produk, harga, stok, foto, detail) 
                        VALUES ('$id_kategori', '$nama_produk', '$harga', '$stok', '$new_name', '$detail')");

                    if ($queryTambah) {
                        echo '<div class="alert alert-primary mt-3">Produk berhasil disimpan</div>';
                        echo '<meta http-equiv="refresh" content="2; url=produk.php" />';
                    } else {
                        echo '<div class="alert alert-danger mt-3">' . mysqli_error($con) . '</div>';
                    }
                }
            }
            ?>
        </div>

        <!-- Tabel Produk -->
        <div class="my-5 col-12">
            <h3>List Produk</h3>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                            echo '<tr><td colspan="6" class="text-center">Data produk tidak tersedia</td></tr>';
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$data['nama_produk']}</td>
                                    <td>{$data['nama_kategori']}</td>
                                    <td>Rp " . number_format($data['harga'], 0, ',', '.') . "</td>
                                    <td>{$data['stok']}</td>
                                    <td>
                                        <a href='produk-detail.php?p={$data['id_produk']}' class='btn btn-info'><i class='fas fa-search'></i></a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
