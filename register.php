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
    <title>Document</title>
</head>
<body>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>
    
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Masukan Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label>
        <input type="password" name="konfirmasi_password" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>