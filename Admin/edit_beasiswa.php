<?php
include '../config.php';

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil ID beasiswa yang ingin diedit
$id = $_GET['id'];

// Query untuk mengambil data beasiswa berdasarkan ID
$query = "SELECT * FROM beasiswa WHERE id='$id'";
$result = mysqli_query($conn, $query);
$beasiswa = mysqli_fetch_assoc($result);

// Cek apakah form disubmit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_beasiswa'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $deadline = $_POST['deadline'];

    $query = "UPDATE beasiswa SET nama_beasiswa='$nama', deskripsi='$deskripsi', kategori='$kategori', deadline='$deadline' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

    <!-- Form Edit Beasiswa -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Beasiswa</h2>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="nama_beasiswa" class="form-label">Nama Beasiswa</label>
                <input type="text" class="form-control" id="nama_beasiswa" name="nama_beasiswa" value="<?= $beasiswa['nama_beasiswa']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= $beasiswa['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $beasiswa['kategori']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" value="<?= $beasiswa['deadline']; ?>" required>
            </div>
            <div class="d-flex justify-content-start gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
