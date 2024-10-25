<?php
include '../config.php';

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Pagination dan pencarian
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query pencarian dengan pagination
$query = "SELECT * FROM beasiswa 
          WHERE nama_beasiswa LIKE '%$search%' 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) AS total FROM beasiswa WHERE nama_beasiswa LIKE '%$search%'";
$totalResult = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery));
$totalData = $totalResult['total'];
$totalPages = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Header tabel dengan warna abu-abu muda dan rata tengah */
        thead th {
            position: sticky;
            top: 0;
            background-color: #f0f0f0; /* Warna abu-abu muda */
            color: black;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Container tabel dengan scroll */
        .scrollable-container {
            max-height: 400px;
            overflow-y: auto;
        }

        /* Rata kanan-kiri dan konsistensi padding */
        td, th {
            text-align: justify;
            vertical-align: middle;
            padding: 12px 20px; /* Memberikan jarak antar teks */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="tambah_beasiswa.php" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Tambah Beasiswa
        </a>

        <!-- Form Pencarian -->
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Beasiswa" value="<?= $search; ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </form>
    </div>

    <!-- Tabel Beasiswa -->
    <div class="scrollable-container border rounded shadow-sm">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Beasiswa</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = $offset + 1;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_beasiswa']; ?></td>
                        <td><?= $row['deskripsi']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?= $row['deadline']; ?></td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="edit_beasiswa.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm me-2">
                                    <i class="fa fa-edit me-1"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id']; ?>)">
                                    <i class="fa fa-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page - 1; ?>&search=<?= $search; ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>&search=<?= $search; ?>"><?= $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page + 1; ?>&search=<?= $search; ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Hapus -->
<script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus beasiswa ini?')) {
            window.location.href = 'hapus_beasiswa.php?id=' + id;
        }
    }
</script>

</body>
</html>
