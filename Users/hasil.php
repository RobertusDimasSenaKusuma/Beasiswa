<?php
include 'koneksi.php';  // Hubungkan ke database
include 'Navbar_User.php'; // Include navbar

// Pagination dan pencarian
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Menghitung offset
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Pencarian

// Query untuk mengambil data pendaftaran dengan pencarian dan pagination
$sql = "SELECT * FROM pendaftaran 
        WHERE nama LIKE '%$search%' 
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) AS total FROM pendaftaran WHERE nama LIKE '%$search%'";
$totalResult = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery));
$totalData = $totalResult['total'];
$totalPages = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pendaftaran Beasiswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Header tabel */
        thead th {
            position: sticky;
            top: 0;
            background-color: #6c757d; /* Warna abu-abu */
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Rata kanan-kiri dan konsistensi padding */
        td, th {
            text-align: justify;
            vertical-align: middle;
            padding: 12px 20px; /* Memberikan jarak antar teks */
        }

        /* Styling untuk container tabel */
        .scrollable-container {
            max-height: 400px;
            overflow-y: auto;
        }

        body {
            background-color: #f4f4f4;
            padding-top: 0; /* Ruang untuk navbar */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Hasil Pendaftaran Beasiswa</h2>

    <div class="d-flex justify-content-between mb-3">
        <!-- Form Pencarian -->
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama" value="<?= htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </form>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
        <div class="scrollable-container border rounded shadow-sm">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Semester</th>
                        <th>IPK</th>
                        <th>Beasiswa Akademik</th>
                        <th>Beasiswa Non-Akademik</th>
                        <th>Berkas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = $offset + 1; // Nomor urut
                    while ($row = mysqli_fetch_assoc($result)) { 
                        $badgeClass = $row['status'] === 'Terverifikasi' ? 'bg-success' : 'bg-warning'; // Badge status
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['hp']); ?></td>
                            <td><?= htmlspecialchars($row['semester']); ?></td>
                            <td><?= htmlspecialchars($row['ipk']); ?></td>
                            <td><?= htmlspecialchars($row['beasiswa_akademik']); ?></td>
                            <td><?= htmlspecialchars($row['beasiswa_non_akademik']); ?></td>
                            <td>
                                <a href="uploads/<?= htmlspecialchars($row['berkas']); ?>" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Lihat Berkas
                                </a>
                            </td>
                            <td>
                                <span class="badge <?= $badgeClass; ?>">
                                    <?= htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info">Tidak ada data pendaftaran.</div>
    <?php } ?>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>"><?= $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php mysqli_close($conn); ?>
</body>
</html>
