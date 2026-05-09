<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
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
    <title>Login</title>
</head>
<body>
    <div class="container">
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Password:</label>
        <div style="position:relative">
        <input type="password" name="password" id="password" required>
        <span onclick="togglePassword()" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9c8878;">
            <i class="fa-regular fa-eye"></i>
        </span>
        </div>
        <button type="submit">Login</button>
        <a href="register.php">Belum punya akun? Daftar</a>
    </form>
    </div>
    
</body>
</html>