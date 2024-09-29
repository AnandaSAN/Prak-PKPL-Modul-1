<?php
session_start();
// Jika sudah login, arahkan ke index.php
if (isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Jika tombol login diklik
function login($koneksi) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk mendapatkan data pengguna
        $sql = "SELECT * FROM admin WHERE username = ?";
        if ($stmt = $koneksi->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifikasi kata sandi
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Debugging: menampilkan password yang dimasukkan dan disimpan
                // echo "Username entered: " . htmlspecialchars($username) . "<br>";
                // echo "Password entered: " . htmlspecialchars($password) . "<br>";
                // echo "Username stored: " . htmlspecialchars($row['username']) . "<br>";
                // echo "Password stored: " . htmlspecialchars($row['password']) . "<br>";

                if (password_verify($password, $row['password'])) {
                    $_SESSION['login'] = true;
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<script>alert('Username atau password salah');</script>";
                }
            } else {
                echo "<script>alert('Data tidak ditemukan');</script>";
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $koneksi->error;
        }
    }
}

login($koneksi);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Network - Log in</title>
    <link rel="stylesheet" href="css/login1.css">
</head>

<body>

    <header>
        Manajemen Buku
    </header>

    <div class="container">
        <div class="login-wrapper">
            <img src="https://smadharmawanitapare.sch.id/media_library/images/47250683e2b0fa6b7444ee4af26eab5f.png" alt="School Icon" class="logo" />
            <h1>Login Manajemen Buku</h1>
            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form name="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onSubmit="return doLogin()">
                <input type="hidden" name="dst" value="$(link-orig)" />
                <input type="hidden" name="popup" value="true" />

                <div class="input-group">
                    <img src="img/user.svg" alt="User Icon" />
                    <input type="text" name="username" placeholder="Username" required />
                </div>

                <div class="input-group">
                    <img src="img/password.svg" alt="Password Icon" />
                    <input type="password" name="password" placeholder="Password" required />
                </div>

                <input type="submit" name="login" value="Log In" />
            </form>
            <p class="info">Register? <a href="register.php">Click here</a></p>
            <p class="info">Powered by ASAN</p>
        </div>
    </div>

    <footer>
        &copy; 2024 ASAN Capital. All rights reserved.
    </footer>

</body>

</html>
