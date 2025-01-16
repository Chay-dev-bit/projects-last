<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <section class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-700">Login</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-sm mb-4"><?= $error ?></p>
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
                Login
            </button>
        </form>
        <p class="mt-4 text-center text-gray-600 text-sm">
            Belum punya akun? <a href="ragister.php" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
    </div>
    </section>
</body>
</html>
