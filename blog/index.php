<?php
require __DIR__ . '/db.php';

$q  = trim($_GET['q'] ?? '');
$kw = "%$q%";

$stmt = mysqli_prepare($conn,
  "SELECT a.slug, a.judul, a.ringkasan, k.nama AS kategori
   FROM artikel a
   JOIN kategori_artikel k ON a.kategori_id = k.id
   WHERE a.status = 'publish' AND (a.judul LIKE ? OR a.ringkasan LIKE ?)
   ORDER BY a.created_at DESC");
mysqli_stmt_bind_param($stmt, 'ss', $kw, $kw);
mysqli_stmt_execute($stmt);
$daftar = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edukasi - BUYPANEN</title>
</head>
<body>
  <h1>Edukasi &amp; Blog</h1>

  <form method="get">
    <input type="text" name="q" placeholder="Cari artikel..." value="<?= htmlspecialchars($q) ?>">
    <button type="submit">Cari</button>
  </form>

  <?php if (!$daftar): ?><p>Artikel tidak ditemukan.</p><?php endif; ?>

  <?php foreach ($daftar as $a): ?>
    <article>
      <small><?= htmlspecialchars($a['kategori']) ?></small>
      <h2><a href="detail.php?slug=<?= urlencode($a['slug']) ?>"><?= htmlspecialchars($a['judul']) ?></a></h2>
      <p><?= htmlspecialchars($a['ringkasan']) ?></p>
    </article>
  <?php endforeach; ?>
</body>
</html>