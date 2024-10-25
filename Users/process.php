<?php
require_once '../config.php'; // Ganti dengan path yang sesuai jika file config.php berada di tempat lain



// Menangani upload file
$uploadDir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi
$attachment = $_FILES['berkas']['name'];
$uploadFilePath = $uploadDir . basename($attachment);

// Periksa apakah upload berhasil
if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFilePath)) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hp = $_POST['hp'];
    $semester = $_POST['semester'];
    $ipk = $_POST['ipk'];
    $beasiswa1 = $_POST['beasiswa1'];
    $beasiswa2 = $_POST['beasiswa2'];

    // Siapkan dan jalankan query untuk memasukkan data ke tabel hasil
    $sql = "INSERT INTO hasil (username, email, no_hp, semester, ipk, pilihan_beasiswa1, pilihan_beasiswa2, attachment) 
            VALUES (:username, :email, :no_hp, :semester, :ipk, :pilihan_beasiswa1, :pilihan_beasiswa2, :attachment)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $nama,
        ':email' => $email,
        ':no_hp' => $hp,
        ':semester' => $semester,
        ':ipk' => $ipk,
        ':pilihan_beasiswa1' => $beasiswa1,
        ':pilihan_beasiswa2' => $beasiswa2,
        ':attachment' => $attachment
    ]);

    // Redirect ke halaman hasil
    header("Location: hasil.php");
    exit();
} else {
    echo "Gagal mengupload berkas.";
}
?>
