<?php
require 'db.php'; // Pastikan file db.php memiliki koneksi ke database

$action = $_GET['action'] ?? ''; // Ambil aksi dari URL
$id = $_GET['id'] ?? ''; // Ambil ID dari URL jika ada

// Proses Tambah atau Edit Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $description);
        $stmt->execute();
    } elseif ($_POST['action'] === 'update' && $id) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $name, $price, $description, $id);
        $stmt->execute();
    }
    header("Location: kelola_produk.php");
    exit;
}

// Proses Hapus Produk
if ($action === 'delete' && $id) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: kelola_produk.php");
    exit;
}

// Ambil Daftar Produk
$products = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);

// Ambil Data Produk untuk Edit
$product = [];
if ($action === 'edit' && $id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./output.css" />
</head>
<body>
<header class="bg-blue-950 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white space-x-2">Coffe
                <img src="coffee-cup.png" alt="kopi" class="size-10 w-8 h-8">
            </h1>
        <nav class="text-base gap-4 hidden md:flex">
            <a class="menu-text text-white" href="index.php">Home</a>
            <a class="menu-text text-white" href="dashboard.php">Dashboard</a>
            <a class="menu-text text-white" href="login.php">Login</a>
        </nav>
        </div>
    </header>
    <section class="bg-gray-100 min-h-screen p-8">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Kelola Produk</h1>

        <!-- Form Produk -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-bold mb-4"><?= $action === 'edit' ? 'Edit' : 'Tambah' ?> Produk</h2>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="<?= $action === 'edit' ? 'update' : 'create' ?>">
                <div>
                    <label class="block text-gray-700 font-medium">Nama Anda</label>
                    <input type="text" name="name" value="<?= $product['name'] ?? '' ?>" required 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Harga</label>
                    <input type="number" name="price" value="<?= $product['price'] ?? '' ?>" step="0.01" required 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Pesanan anda</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"><?= $product['description'] ?? '' ?></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    <?= $action === 'edit' ? 'Update' : 'Tambah' ?>
                </button>
                <?php if ($action === 'edit'): ?>
                    <a href="kelola_produk.php" class="ml-2 text-gray-500">Batal</a>
                <?php endif; ?>
            </form>
        </div>
        <!-- Daftar Produk -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Daftar Produk</h2>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">id</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Harga</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $index + 1 ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($product['name']) ?></td>
                            <td class="border px-4 py-2">Rp<?= number_format($product['price'], 2, ',', '.') ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($product['description']) ?></td>
                            <td class="border px-4 py-2">
                                <a href="kelola_produk.php?action=edit&id=<?= $product['id'] ?>" 
                                   class="text-blue-500 hover:underline">Edit</a>
                                <a href="kelola_produk.php?action=delete&id=<?= $product['id'] ?>" 
                                   class="text-red-500 hover:underline ml-2" 
                                   onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </section>
</body>
</html>
