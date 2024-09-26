<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acnes_web";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

// Memeriksa apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    if (empty($input_username) || empty($input_password)) {
        echo json_encode(["status" => "error", "message" => "Username dan password wajib diisi."]);
        exit();
    }

    // Mempersiapkan statement untuk mengambil data user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();

    // Memeriksa apakah username ditemukan
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Memverifikasi password
        if (password_verify($input_password, $hashed_password)) {
            echo json_encode(["status" => "success", "message" => "Login berhasil", "user_id" => $id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Username atau password salah."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Username atau password salah."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Metode request tidak valid."]);
}

$conn->close();
?>