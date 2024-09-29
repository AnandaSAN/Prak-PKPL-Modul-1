<?php
// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "Perpus");

// membuat fungsi query dalam bentuk array
function query($query)
{
    // Koneksi database
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    // membuat varibale array
    $rows = [];

    // mengambil semua data dalam bentuk array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi;

    $no_buku = htmlspecialchars($data['no_buku']);
    $nama = htmlspecialchars($data['nama']);
    $tmpt_terbit = htmlspecialchars($data['tmpt_terbit']);
    $tgl_terbit = $data['tgl_terbit'];
    $kategori = $data['kategori'];
    $penulis = htmlspecialchars($data['penulis']);
    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    $sql = "INSERT INTO buku VALUES ('$no_buku','$nama','$tmpt_terbit','$tgl_terbit','$kategori','$penulis','$gambar')";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi hapus
function hapus($no_buku)
{
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM buku WHERE no_buku = $no_buku");
    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi ubah
function ubah($data)
{
    global $koneksi;

    $no_buku = $data['no_buku'];
    $nama = htmlspecialchars($data['nama']);
    $tmpt_terbit = htmlspecialchars($data['tmpt_terbit']);
    $tgl_terbit = $data['tgl_terbit'];
    $kategori = $data['kategori'];
    $penulis = htmlspecialchars($data['penulis']);

    $gambarLama = $data['gambarLama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $sql = "UPDATE buku SET nama = '$nama', tmpt_terbit = '$tmpt_terbit', tgl_terbit = '$tgl_terbit', kategori = '$kategori', penulis = '$penulis', gambar = '$gambar' WHERE no_buku = $no_buku";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi upload gambar
function upload()
{
    // Syarat
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Jika tidak mengupload gambar atau tidak memenuhi persyaratan diatas maka akan menampilkan alert dibawah
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // format atau ekstensi yang diperbolehkan untuk upload gambar adalah
    $extValid = ['jpg', 'jpeg', 'png'];
    $ext = explode('.', $namaFile);
    $ext = strtolower(end($ext));

    // Jika format atau ekstensi bukan gambar maka akan menampilkan alert dibawah
    if (!in_array($ext, $extValid)) {
        echo "<script>alert('Yang anda upload bukanlah gambar!');</script>";
        return false;
    }

    // Jika ukuran gambar lebih dari 3.000.000 byte maka akan menampilkan alert dibawah
    if ($ukuranFile > 3000000) {
        echo "<script>alert('Ukuran gambar anda terlalu besar!');</script>";
        return false;
    }

    // nama gambar akan berubah angka acak/unik jika sudah berhasil tersimpan
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ext;

    // memindahkan file ke dalam folde img dengan nama baru
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function registrasi($data)
{
    global $koneksi;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($koneksi, "SELECT username FROM admin WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar');
        </script>";
        return false;
    }

    // cek konfirmasi password

    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($koneksi, "INSERT INTO admin VALUES('', '$username', '$password')
    ");

    return mysqli_affected_rows($koneksi);
}