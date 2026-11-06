
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../config/login.php");
    exit;
}

// Pastikan hanya petani yang bisa mengakses halaman petani
if ($_SESSION["role"] !== "petani") {
    http_response_code(403);
    exit("Akses ditolak! Halaman ini khusus petani.");
}

?>
