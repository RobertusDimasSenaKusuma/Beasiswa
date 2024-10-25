<?php
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];

    $sql = "UPDATE pendaftaran SET status='Terverifikasi' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header('Location: Approval_beasiswa.php');  // Redirect setelah berhasil
        exit();
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($conn);
    }
}
?>
