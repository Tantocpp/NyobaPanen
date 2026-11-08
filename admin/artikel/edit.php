<?php
require __DIR__ . '/../../middleware/admin.php';
require __DIR__ . '/../../auth/database.php';
require __DIR__ . '/_helper.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn,
  "SELECT judul, kategori_id, ringkasan, isi, status FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    http_response_code(404);
    exit('Artikel tidak ditemukan. <a href="index.php">Kembali</a>');
}

$kategori = daftar_kategori($conn);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data  = ambil_input();
    $error = validasi($data);

    if ($error === '') {
        // slug tidak diubah supaya link lama tetap berfungsi
        $up = mysqli_prepare($conn,
          "UPDATE artikel SET kategori_id = ?, judul = ?, ringkasan = ?, isi = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, 'issssi', $data['kategori_id'], $data['judul'],
            $data['ringkasan'], $data['isi'], $data['status'], $id);
        mysqli_stmt_execute($up);
        header('Location: index.php?pesan=edit');
        exit;
    }
}

$judul_halaman = 'Edit Artikel';
require __DIR__ . '/_form.php';