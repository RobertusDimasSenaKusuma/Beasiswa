<?php
include '../config.php';
include 'navbar.php'; // Include Navbar

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Query untuk mengambil semua data pendaftaran
$sql = "SELECT * FROM pendaftaran";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pendaftaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
        /* Header lebih besar */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Sticky dan styling header tabel */
        thead th {
            position: sticky;
            top: 0;
            background-color: #6c757d; /* Warna abu-abu */
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        td, th {
            text-align: center;
            vertical-align: middle;
        }
    
        body {
            padding-top: 0; /* Ruang untuk navbar */
        }

        .form-container {
            max-width: 800px; /* Ukuran maksimal form */
        }

        .form-inline {
            display: flex; /* Menjadikan form berjejer */
            justify-content: space-between;
        }

        .form-inline .form-control {
            margin-right: 10px; /* Jarak antar input */
        }
        .btn-verify {
            width: 100px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Manajemen Pendaftaran</h2>

    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) { 
                    // Warna status dengan Bootstrap Badge
                    $badgeClass = $row['status'] === 'Terverifikasi' ? 'bg-success' : 'bg-warning';
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
                        <a href="uploads/<?= htmlspecialchars($row['berkas']); ?>" 
                        class="btn btn-primary d-flex align-items-center gap-2" 
                        download="<?= htmlspecialchars($row['berkas']); ?>">
                        <i class="fas fa-download"></i> 
                        <span style="font-size: 0.85rem;">Lihat Berkas</span>
                        </a>
                        </td>
                        <td>
                            <span class="badge <?= $badgeClass; ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="approve.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
                                <button type="submit" class="btn btn-primary btn-verify">Verifikasi</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-info">Tidak ada data pendaftaran.</div>
    <?php } ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

</body>
</html>

<?php mysqli_close($conn); ?>
