<?php 
include 'auth.php';
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Edit todo - Tambah Todo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $judul = $_POST['editjudul'];
    mysqli_query($conn, "UPDATE todos SET judul='$judul' WHERE id=$id AND user_id=$user_id");
    header("Location: update_list.php?success=edit");
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
    
    <?php if(isset($_GET['success']) && $_GET['success'] == 'edit'): ?>
    <p style="color:green">Aktivitas berhasil diubah!</p>
    <?php endif; ?>   

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
                <a href="#" onclick="bukaModal(<?php echo $todo['id']; ?>, '<?php echo $todo['judul']; ?>')">Edit</a>
                <a href="?hapus=<?php echo $todo['id']; ?>">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>
<?php endif; ?>
    </div>
    <div id="modalEdit" style="display:none">
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <label>Edit Aktivitas</label>
            <input type="text" name="editjudul" id="editJudul" placeholder="Contoh: Menulis" required>
            <button type="submit">Edit Aktivitas</button>
            <button type="button" onclick="tutupModal()">Batal</button>
        </form>
    </div>

    <script src="Js/script.js"></script>   
</body>
</html>