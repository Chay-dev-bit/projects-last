<?php
$host = 'localhost'; // Ganti sesuai konfigurasi Anda
$user = 'root'; // Username database
$pass = ''; // Password database
$db = 'penjualan'; // Nama database

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>