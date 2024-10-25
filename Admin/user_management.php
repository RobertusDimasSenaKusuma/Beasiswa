<?php
include '../config.php';

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Proses tambah user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $semester = $_POST['semester'];
    $ipk = $_POST['ipk'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];

    $query = "INSERT INTO users (username, password, role, semester, ipk, email, nomor_hp) 
              VALUES ('$username', '$password', 'user', '$semester', '$ipk', '$email', '$nomor_hp')";
    if (mysqli_query($conn, $query)) {
        header('Location: user_management.php');
        exit();
    } else {
        echo "Gagal menambah user: " . mysqli_error($conn);
    }
}

// Pagination dan pencarian
$limit = 5; // Batas jumlah user per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Pencarian
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Ambil data user dengan role 'user' dan pencarian
$query = "SELECT * FROM users WHERE role = 'user' AND username LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Hitung total user untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM users WHERE role = 'user' AND username LIKE '%$search%'";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
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
    </style>
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Konten Utama -->
<div class="container mt-5">
    
    <form method="POST" action="" class="form-inline mb-4">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="text" name="semester" class="form-control" placeholder="Semester" required max="8">
        <input type="number" name="ipk" class="form-control" step="0.01" placeholder="IPK" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="text" name="nomor_hp" class="form-control" placeholder="Nomor HP" required>
        <button type="submit" name="add_user" class="btn btn-success">Tambah User</button>
    </form>

    <!-- Form Pencarian -->
    <form method="POST" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Username" value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <h3 class="mt-4">Daftar User</h3>
    <table class="table table-striped table-bordered mt-2">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Semester</th>
                <th>IPK</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = $offset + 1; while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['semester']; ?></td>
                    <td><?= $row['ipk']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['nomor_hp']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
