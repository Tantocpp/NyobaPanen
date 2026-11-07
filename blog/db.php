<?php
// SEMENTARA: nanti ganti isi file ini dengan koneksi milik tim (auth/database.php)
$pdo = new PDO(
    'mysql:host=localhost;dbname=buypanen;charset=utf8mb4',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);