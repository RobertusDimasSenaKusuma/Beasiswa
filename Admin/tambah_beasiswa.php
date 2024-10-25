<?php
include '../config.php';

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Proses tambah beasiswa
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_beasiswa'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $deadline = $_POST['deadline'];

    $query = "INSERT INTO beasiswa (nama_beasiswa, deskripsi, kategori, deadline) 
              VALUES ('$nama', '$deskripsi', '$kategori', '$deadline')";

    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

    <!-- Form Tambah Beasiswa -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Beasiswa</h2>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="nama_beasiswa" class="form-label">Nama Beasiswa</label>
                <input type="text" class="form-control" id="nama_beasiswa" name="nama_beasiswa" placeholder="Nama Beasiswa" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Akademik">Akademik</option>
                    <option value="Non Akademik">Non Akademik</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>
            <div class="d-flex justify-content-start gap-2">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
