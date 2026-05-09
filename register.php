<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if ($password !== $konfirmasi) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah digunakan!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $query  = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed')";

            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! Silahkan login.";
            } else {
                $error = "Registrasi gagal, coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="Js/script.js"></script>
    <link rel="stylesheet" href="Style/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>

    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Masukan Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <div style="position:relative">
        <input type="password" name="password" id="password" required>
        <span onclick="togglePassword()" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9c8878;">
            <i class="fa-regular fa-eye"></i>
        </span>
        </div>

        <label>Konfirmasi Password:</label>
        <input type="password" name="konfirmasi_password" required><br><br>

        <button type="submit">Register</button>
        <br>
        <br>
        <a href="login.php">Sudah punya akun? Login</a>
    </form>
    </div>
</body>
</html>