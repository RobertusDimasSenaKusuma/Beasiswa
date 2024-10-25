<?php
$host = "localhost";
$user = "root";
$pass = "";   // Password default (kosong)
$db   = "beasiswa";
$port = "3307";  // Port MySQL yang Anda gunakan

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();  // Memulai session
?>
