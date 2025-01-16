<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $success_message = "Registrasi berhasil! <a href='login.php' class='font-bold underline'>Login di sini</a>";
    } else {
        $error = "Terjadi kesalahan: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <a class="menu-text text-white" href="index.html">Home</a>
            <a class="menu-text text-white" href="dashboard.php">Dashboard</a>
            <a class="menu-text text-white" href="login.php">Login</a>
        </nav>
        </div>
    </header>
    <section class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-700">Register</h1>
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= $success_message ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-600 text-sm font-medium">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" 
                       class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="password" class="block text-gray-600 text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" 
                       class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Register
            </button>
        </form>
        <p class="mt-4 text-center text-gray-600 text-sm">
            Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
    </div>
    </section>
</body>
</html>
