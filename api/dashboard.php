<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index2.php");
    exit;
}
require 'db.php';

// Fetch username
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <header class="bg-blue-900 text-white">
        <div class="container mx-auto flex items-center justify-between p-4">
            <h1 class="text-2xl font-bold flex items-center space-x-2">
                <span>Coffee</span>
                <img src="coffee-cup.png" alt="Kopi" class="w-8 h-8">
            </h1>
            <nav class="hidden md:flex space-x-6">
                <a href="index.html" class="hover:text-gray-300">Home</a>
                <a href="dashboard.php" class="hover:text-gray-300">Dashboard</a>
                <a href="products.php" class="hover:text-gray-300">Kelola Produk</a>
                <a href="logout.php" class="hover:text-gray-300">Logout</a>
            </nav>
            <button class="block md:hidden text-white focus:outline-none" id="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
        <div class="md:hidden bg-blue-800" id="mobile-menu" style="display: none;">
            <a href="index.html" class="block px-4 py-2 hover:bg-blue-700">Home</a>
            <a href="dashboard.php" class="block px-4 py-2 hover:bg-blue-700">Dashboard</a>
            <a href="products.php" class="block px-4 py-2 hover:bg-blue-700">Kelola Produk</a>
            <a href="logout.php" class="block px-4 py-2 hover:bg-blue-700">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
        <p class="text-gray-700 mb-6">Ini adalah dashboard pemesanan anda. pesan coffe sesuka hatimu dan temukan rasa nampol.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-bold text-gray-800">Kelola Produk</h2>
                <p class="text-gray-600">Tambahkan, edit, dan hapus produk Anda.</p>
                <a href="products.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Produk</a>
            </div>
            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-bold text-gray-800">Home</h2>
                <p class="text-gray-600">Kembali ke halaman utama website.</p>
                <a href="index.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Home</a>
            </div>
            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-bold text-gray-800">Logout</h2>
                <p class="text-gray-600">Keluar dari sesi Anda.</p>
                <a href="logout.php" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle Mobile Menu
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        });
    </script>
</body>
</html>