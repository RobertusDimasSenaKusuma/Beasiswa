<?php
include '../config.php';

// Ambil ID user dari URL
$id = $_GET['id'];

// Query untuk menghapus user
$query = "DELETE FROM users WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header('Location: user_management.php');
    exit();
} else {
    echo "Gagal menghapus user: " . mysqli_error($conn);
}
?>
