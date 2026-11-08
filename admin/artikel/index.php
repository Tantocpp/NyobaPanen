<?php
require __DIR__ . '/../../middleware/admin.php';
require __DIR__ . '/../../auth/database.php';

$r = mysqli_query($conn,
  "SELECT a.id, a.judul, a.status, a.dilihat, a.created_at, k.nama AS kategori
   FROM artikel a JOIN kategori_artikel k ON a.kategori_id = k.id
   ORDER BY a.created_at DESC");
$daftar = mysqli_fetch_all($r, MYSQLI_ASSOC);

$pesan = [
  'tambah' => 'Artikel berhasil ditambahkan.',
  'edit'   => 'Artikel berhasil diperbarui.',
  'hapus'  => 'Artikel berhasil dihapus.',
][$_GET['pesan'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Artikel - Admin BUYPANEN</title>
</head>
<body>
  <h1>Kelola Artikel</h1>
  <?php if ($pesan): ?><p style="color:green"><?= htmlspecialchars($pesan) ?></p><?php endif; ?>
  <p><a href="tambah.php">+ Tambah artikel</a></p>

  <table border="1" cellpadding="6" cellspacing="0">
    <tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Dilihat</th><th>Aksi</th></tr>
    <?php foreach ($daftar as $a): ?>
      <tr>
        <td><?= htmlspecialchars($a['judul']) ?></td>
        <td><?= htmlspecialchars($a['kategori']) ?></td>
        <td><?= htmlspecialchars($a['status']) ?></td>
        <td><?= (int)$a['dilihat'] ?></td>
        <td>
          <a href="edit.php?id=<?= $a['id'] ?>">Edit</a>
          <form method="post" action="hapus.php" style="display:inline"
                onsubmit="return confirm('Hapus artikel ini?')">
            <input type="hidden" name="id" value="<?= $a['id'] ?>">
            <button type="submit">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="5">Belum ada artikel.</td></tr><?php endif; ?>
  </table>
</body>
</html>