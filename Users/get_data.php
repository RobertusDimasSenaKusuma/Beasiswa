<?php
include '../config.php';

$response = [];

// Jika menerima permintaan berdasarkan nama user
if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $query = "SELECT email, nomor_hp, semester, ipk FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $nama);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $response['user'] = [
            'success' => true,
            'data' => $row
        ];
    } else {
        $response['user'] = ['success' => false, 'message' => 'User tidak ditemukan'];
    }
}

// Jika menerima permintaan berdasarkan kategori beasiswa
if (isset($_POST['kategori'])) {
    $kategori = $_POST['kategori'];
    $query = "SELECT nama_beasiswa AS nama FROM beasiswa WHERE kategori = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $kategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $beasiswa = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $beasiswa[] = $row;
    }

    if (count($beasiswa) > 0) {
        $response['beasiswa'] = ['success' => true, 'data' => $beasiswa];
    } else {
        $response['beasiswa'] = ['success' => false, 'message' => 'Tidak ada beasiswa untuk kategori ini'];
    }
}

// Mengirim respons JSON
echo json_encode($response);
?>
