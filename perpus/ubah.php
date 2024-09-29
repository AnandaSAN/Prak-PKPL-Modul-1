<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
if (!isset($_SESSION['login'])) {
    header('location:login.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Mengambil data dari no_buku dengan fungsi get
$no_buku = $_GET['no_buku'];

// Mengambil data dari tabel buku berdasarkan no_buku
$buku = query("SELECT * FROM buku WHERE no_buku = '$no_buku'")[0];

// Jika fungsi ubah lebih dari 0/data terubah, maka munculkan alert
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data buku berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
    } else {
        // Jika fungsi ubah dibawah dari 0/data tidak terubah, maka munculkan alert
        echo "<script>
                alert('Data buku gagal diubah!');
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- animasi CSS Aos -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>Update Data Buku</title>
</head>

<body background="img/bg/bck.png">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sistem Admin Data Buku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <!-- Container -->
    <div class="container">
        <div class="row my-2 text-light">
            <div class="col-md">
                <h3 class="fw-bold text-uppercase ubah_data"></h3>
            </div>
            <hr>
        </div>
        <div class="row my-2 text-light">
            <div class="col-md">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="gambarLama" value="<?= $buku['gambar']; ?>">
                    <div class="mb-3">
                        <label for="no_buku" class="form-label">No Buku</label>
                        <input type="text" class="form-control w-50" id="no_buku" value="<?= $buku['no_buku']; ?>"
                               name="no_buku" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Buku</label>
                        <input type="text" class="form-control w-50" id="nama" value="<?= $buku['nama']; ?>"
                               name="nama" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="tmpt_terbit" class="form-label">Tempat Terbit</label>
                        <input type="text" class="form-control w-50" id="tmpt_terbit"
                               value="<?= $buku['tmpt_terbit']; ?>" name="tmpt_terbit" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control w-50" id="tgl_terbit"
                               value="<?= $buku['tgl_terbit']; ?>" name="tgl_terbit" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select w-50" id="kategori" name="kategori" required>
                            <option disabled selected value>--------------------------------------------Pilih
                                Kategori--------------------------------------------</option>
                            <option value="Novel" <?php if ($buku['kategori'] == 'Novel') { ?> selected <?php } ?>>Novel</option>
                            <option value="Komik" <?php if ($buku['kategori'] == 'Komik') { ?> selected <?php } ?>>Komik</option>
                            <option value="Cerpen" <?php if ($buku['kategori'] == 'Cerpen') { ?> selected <?php } ?>>Cerpen</option>
                            <option value="Dongeng" <?php if ($buku['kategori'] == 'Dongeng') { ?> selected <?php } ?>>Dongeng</option>
                            <option value="Biografi" <?php if ($buku['kategori'] == 'Biografi') { ?> selected <?php } ?>>Biografi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control w-50" id="penulis" value="<?= $buku['penulis']; ?>"
                               name="penulis" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar <i>(Saat ini)</i></label> <br>
                        <img src="img/<?= $buku['gambar']; ?>" width="50%" style="margin-bottom: 10px;">
                        <input class="form-control form-control-sm w-50" id="gambar" name="gambar" type="file">
                    </div>
                    <hr>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning" name="ubah">Ubah</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Footer -->
    <div class="container-fluid">
        <div class="row bg-dark text-white text-center">
            <div class="col my-2" id="about">
                <br><br><br>
                <h4 class="fw-bold text-uppercase">About</h4>

                <p>
                    Pembuat:
                    1. Farhan Ade Atalarik (2135038)
                </p>
            </div>
        </div>
    </div>
    <!-- Close Footer -->

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <!-- animasi  gsap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/TextPlugin.min.js"></script>
    <script>
    gsap.registerPlugin(TextPlugin);
    gsap.to('.ubah_data', {
        duration: 2,
        delay: 1,
        text: "Ubah Data Buku"
    });
    </script>
</body>

</html>
