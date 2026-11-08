<?php
require __DIR__ . '/../../middleware/admin.php';
require __DIR__ . '/../../auth/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

$id = (int)($_POST['id'] ?? 0);
$stmt = mysqli_prepare($conn, "DELETE FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

header('Location: index.php?pesan=hapus');
exit;