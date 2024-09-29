<?php
// Memanggil atau membutuhkan file function.php
require 'function.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo " <script>
            alert('user baru berhasil ditambahkan');
        </script> ";
    } else {
        echo mysqli_error($koneksi);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perpus - Register</title>
    <link rel="stylesheet" href="css/login1.css">
</head>

<body>

    <header>
        Manajemen Buku
    </header>

    <div class="container">
        <div class="login-wrapper">
            <img src="https://smadharmawanitapare.sch.id/media_library/images/47250683e2b0fa6b7444ee4af26eab5f.png" alt="School Icon" class="logo" />
            <h1>Register Manajemen Buku</h1>
        
            <form action="" method="post">
                <input type="hidden" name="dst" value="$(link-orig)" />
                <input type="hidden" name="popup" value="true" />

                <div class="input-group">
                    <img src="img/user.svg" alt="User Icon" />
                    <input type="text" name="username" placeholder="Username" autocomplete= "off" required />
                </div>

                <div class="input-group">
                    <img src="img/password.svg" alt="Password Icon" />
                    <input type="password" name="password" placeholder="Password" autocomplete= "off" required />
                </div>

                <div class="input-group">
                    <img src="img/password.svg" alt="Password Icon" />
                    <input type="password" name="password2" placeholder="Confirm Password" required />
                </div>

                <input type="submit" name ="register" value="Register" />
            </form>
            <p class="info">Already have account? <a href="login1.php">Click here</a></p>
            <p class="info">Powered by ASAN</p>
        </div>
    </div>

    <footer>
        &copy; 2024 ASAN Capital. All rights reserved.
    </footer>

</body>

</html>
