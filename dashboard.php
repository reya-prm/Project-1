<?php
include 'auth.php';
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Ambil todo hari ini
$todos = mysqli_query($conn, "SELECT * FROM todos WHERE user_id = $user_id AND DATE(created_at) = CURDATE() ORDER BY created_at DESC");

// Centang selesai
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    mysqli_query($conn, "UPDATE todos SET status=1 WHERE id=$id AND user_id=$user_id");
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/style.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

<div class="dashboard-content">
    <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>To Do List Hari Ini</h2>

    <?php if(mysqli_num_rows($todos) > 0): ?>
    <table>
        <tr>
            <th>Aktivitas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while($todo = mysqli_fetch_assoc($todos)): ?>
        <tr>
            <td><?php echo $todo['judul']; ?></td>
            <td><?php echo $todo['status'] == 1 ? '<span style="color:#5aad7e; font-weight:700;">Selesai</span>' : '<span style="color:#e05c5c; font-weight:700;">Belum</span>'; ?></td>
            <td>
            <input type="checkbox" 
            <?php echo $todo['status'] == 1 ? 'checked disabled' : ''; ?>
            onclick="window.location='?selesai=<?php echo $todo['id']; ?>'">
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="color:#9c8878;">Belum ada aktivitas hari ini. Tambah di Update List!</p>
    <?php endif; ?>
</div>
</body>
</html>