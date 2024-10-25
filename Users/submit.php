<?php
include 'koneksi.php';  // Hubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $semester = (int)$_POST['semester'];
    $ipk = (float)$_POST['ipk'];
    $beasiswa1 = mysqli_real_escape_string($conn, $_POST['beasiswa1']);
    $beasiswa2 = mysqli_real_escape_string($conn, $_POST['beasiswa2']);

    // Proses upload file
    $berkas = $_FILES['berkas']['name'];
    $file_tmp = $_FILES['berkas']['tmp_name'];
    $target_dir = __DIR__ . "/uploads/";  // Path absolut ke folder uploads
    $target_file = $target_dir . basename($berkas);

    // Ekstensi yang diizinkan
    $allowed_extensions = ['pdf', 'jpg', 'png'];
    $file_ext = strtolower(pathinfo($berkas, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_extensions)) {
        // Cek apakah folder uploads tersedia dan file berhasil diupload
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);  // Buat folder jika belum ada
        }

        if (move_uploaded_file($file_tmp, $target_file)) {
            // Simpan data ke database
            $sql = "INSERT INTO pendaftaran (nama, email, hp, semester, ipk, beasiswa_akademik, beasiswa_non_akademik, berkas, status) 
             VALUES ('$nama', '$email', '$hp', $semester, $ipk, '$beasiswa1', '$beasiswa2', '$berkas', 'Belum Terverifikasi')";

            // Debugging: Tampilkan query dan data
            echo "SQL: $sql <br>";

            if (mysqli_query($conn, $sql)) {
                header('Location: hasil.php');  // Redirect ke hasil.php setelah berhasil
                exit();  // Hentikan eksekusi setelah redirect
            } else {
                echo "Gagal menyimpan data: " . mysqli_error($conn);  // Tampilkan error
            }
        } else {
            echo "Gagal mengupload berkas.";
        }
    } else {
        echo "Ekstensi file tidak diizinkan. Hanya PDF, JPG, atau PNG yang diperbolehkan.";
    }

    mysqli_close($conn);
}
