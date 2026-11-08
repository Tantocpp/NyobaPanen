<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($judul_halaman) ?> - Admin BUYPANEN</title>
</head>
<body>
  <p><a href="index.php">&larr; Kembali</a></p>
  <h1><?= htmlspecialchars($judul_halaman) ?></h1>

  <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <form method="post">
    <p><label>Judul<br>
      <input type="text" name="judul" maxlength="150" size="60" value="<?= htmlspecialchars($data['judul']) ?>"></label></p>

    <p><label>Kategori<br>
      <select name="kategori_id">
        <option value="0">-- pilih --</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= $k['id'] ?>" <?= (int)$data['kategori_id'] === (int)$k['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama']) ?></option>
        <?php endforeach; ?>
      </select></label></p>

    <p><label>Ringkasan<br>
      <textarea name="ringkasan" rows="2" cols="60" maxlength="255"><?= htmlspecialchars($data['ringkasan']) ?></textarea></label></p>

    <p><label>Isi artikel<br>
      <textarea name="isi" rows="12" cols="60"><?= htmlspecialchars($data['isi']) ?></textarea></label></p>

    <p><label>Status<br>
      <select name="status">
        <option value="draft"   <?= $data['status'] === 'draft'   ? 'selected' : '' ?>>Draft</option>
        <option value="publish" <?= $data['status'] === 'publish' ? 'selected' : '' ?>>Publish</option>
      </select></label></p>

    <button type="submit">Simpan</button>
  </form>
</body>
</html>