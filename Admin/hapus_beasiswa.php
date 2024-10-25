<?php
include '../config.php';

// Cek apakah user admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil ID beasiswa yang ingin dihapus
$id = $_GET['id'];

// Query untuk menghapus beasiswa
$query = "DELETE FROM beasiswa WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header('Location: admin_dashboard.php');
    exit();
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
