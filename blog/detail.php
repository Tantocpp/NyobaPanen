<?php
require __DIR__ . '/db.php';

$slug = $_GET['slug'] ?? '';

$stmt = mysqli_prepare($conn,
  "SELECT a.id, a.judul, a.isi, a.dilihat, a.created_at, k.nama AS kategori, u.nama AS penulis
   FROM artikel a
   JOIN kategori_artikel k ON a.kategori_id = k.id
   JOIN users u ON a.penulis_id = u.id
   WHERE a.slug = ? AND a.status = 'publish'");
mysqli_stmt_bind_param($stmt, 's', $slug);
mysqli_stmt_execute($stmt);
$artikel = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$artikel) {
    http_response_code(404);
    exit('Artikel tidak ditemukan. <a href="index.php">Kembali</a>');
}

$up = mysqli_prepare($conn, "UPDATE artikel SET dilihat = dilihat + 1 WHERE id = ?");
mysqli_stmt_bind_param($up, 'i', $artikel['id']);
mysqli_stmt_execute($up);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($artikel['judul']) ?> - BUYPANEN</title>
</head>
<body>
  <p><a href="index.php">&larr; Kembali ke daftar artikel</a></p>
  <small><?= htmlspecialchars($artikel['kategori']) ?></small>
  <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
  <p>
    Oleh <?= htmlspecialchars($artikel['penulis']) ?> &middot;
    <?= date('d M Y', strtotime($artikel['created_at'])) ?> &middot;
    <?= (int)$artikel['dilihat'] + 1 ?> kali dilihat
  </p>
  <div><?= nl2br(htmlspecialchars($artikel['isi'])) ?></div>
</body>
</html>