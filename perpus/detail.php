<?php
// Memanggil atau membutuhkan file function.php
require 'function.php';

// Jika databuku diklik maka
if (isset($_POST['databuku'])) {
    $output = '';

    // mengambil data buku dari no_buku yang berasal dari databuku
    $sql = "SELECT * FROM buku WHERE no_buku = '" . $_POST['databuku'] . "'";
    $result = mysqli_query($koneksi, $sql);

    $output .= '<div class="table-responsive">
                        <table class="table table-bordered">';
    foreach ($result as $row) {
        $output .= '<tr align="center">
                            <td colspan="2"><img src="img/' . $row['gambar'] . '" width="50%"></td>
                        </tr>
                        <tr>
                            <th width="40%">No Buku</th>
                            <td width="60%">' . $row['no_buku'] . '</td>
                        </tr>
                        <tr>
                            <th width="40%">Judul Buku</th>
                            <td width="60%">' . $row['nama'] . '</td>
                        </tr>
                        <tr>
                            <th width="40%">Penulis</th>
                            <td width="60%">' . $row['penulis'] . '</td>
                        </tr>
                        <tr>
                            <th width="40%">Tempat dan Tanggal Terbit</th>
                            <td width="60%">' . $row['tmpt_terbit'] . ', ' . date("d M Y", strtotime($row['tgl_terbit'])) . '</td>
                        </tr>
                        <tr>
                            <th width="40%">Kategori</th>
                            <td width="60%">' . $row['kategori'] . '</td>
                        </tr>
                        ';
    }
    $output .= '</table></div>';
    // Tampilkan $output
    echo $output;
}
