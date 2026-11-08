<?php
require __DIR__ . '/../../middleware/admin.php';
require __DIR__ . '/../../auth/database.php';
require __DIR__ . '/_helper.php';

$kategori = daftar_kategori($conn);
$data  = ['judul' => '', 'kategori_id' => 0, 'ringkasan' => '', 'isi' => '', 'status' => 'draft'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data  = ambil_input();
    $error = validasi($data);

    if ($error === '') {
        $slug    = buat_slug($conn, $data['judul']);
        $penulis = (int)$_SESSION['user_id'];
        $stmt = mysqli_prepare($conn,
          "INSERT INTO artikel (penulis_id, kategori_id, judul, slug, ringkasan, isi, status)
           VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iisssss', $penulis, $data['kategori_id'],
            $data['judul'], $slug, $data['ringkasan'], $data['isi'], $data['status']);
        mysqli_stmt_execute($stmt);
        header('Location: index.php?pesan=tambah');
        exit;
    }
}

$judul_halaman = 'Tambah Artikel';
require __DIR__ . '/_form.php';