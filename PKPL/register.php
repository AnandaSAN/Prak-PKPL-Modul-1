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
    $input_email = trim($_POST['email']);
    $input_password = trim($_POST['password']);

    // Validasi input
    if (empty($input_username) || empty($input_email) || empty($input_password)) {
        echo json_encode(["status" => "error", "message" => "Semua field wajib diisi."]);
        exit();
    }

    // Memeriksa apakah username sudah digunakan
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username sudah digunakan."]);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

    // Mempersiapkan statement untuk menyimpan user baru
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $input_username, $input_email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registrasi berhasil"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registrasi gagal, silakan coba lagi."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Metode request tidak valid."]);
}

$conn->close();
?>
