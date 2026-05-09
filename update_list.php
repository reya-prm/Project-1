<?php 
include 'auth.php';
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Tambah todo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['judul'])) {
    $judul = $_POST['judul'];
    $stmt = mysqli_prepare($conn, "INSERT INTO todos (user_id, judul) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "is", $user_id, $judul);
    mysqli_stmt_execute($stmt);
    header("Location: update_list.php");
    exit();
}

// Hapus todo
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM todos WHERE id=$id AND user_id=$user_id");
    header("Location: update_list.php");
    exit();
}

// Ambil semua todo
$todos = mysqli_query($conn, "SELECT * FROM todos WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/style.css">
    <title>Update</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="dashboard-content">
        <form method="POST">
            <label>Ketik Aktivitas</label>
            <input type="text" name="judul" placeholder="Contoh: Belajar PHP" required>
            <button type="submit">Tambah Aktivitas</button>
        </form>
        
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
            <td><?php echo $todo['status'] == 1 ? '<span style="color:#5aad7e; font-weight:700;">Selesai</span>' : '<span style="color:#e05c5c; font-weight:700;">Belum</span>' ?></td>
            <td>
                <a href="edit_todo.php?id=<?php echo $todo['id']; ?>">Edit</a>
                <a href="?hapus=<?php echo $todo['id']; ?>">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>
<?php endif; ?>
    </div>
</body>
</html>