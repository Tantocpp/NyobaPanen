
<?php
// Data sementara, nantinya diganti dengan data dari database
$products = [
    [
        'id' => 1,
        'nama' => 'Tomat',
        'kategori' => 'Sayuran',
        'petani' => 'Pak Budi',
        'harga' => 12000,
        'stok' => '50 kg',
        'deskripsi' => 'Tomat segar hasil panen lokal.'
    ],
    [
        'id' => 2,
        'nama' => 'Pisang',
        'kategori' => 'Buah',
        'petani' => 'Bu Siti',
        'harga' => 15000,
        'stok' => '30 kg',
        'deskripsi' => 'Pisang matang dan siap dijual.'
    ],
    [
        'id' => 3,
        'nama' => 'Jagung',
        'kategori' => 'Biji-bijian',
        'petani' => 'Pak Andi',
        'harga' => 8000,
        'stok' => '100 kg',
        'deskripsi' => 'Jagung segar hasil panen lokal.'
    ]
];

// Mengambil ID produk dari URL
$id = $_GET['id'] ?? null;

$detailProduct = null;

foreach ($products as $product) {
    if ($product['id'] == $id) {
        $detailProduct = $product;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - BuyPanen</title>
</head>
<body>

    <?php if ($detailProduct): ?>

        <h2>Detail Produk</h2>

        <h3><?= htmlspecialchars($detailProduct['nama']) ?></h3>
        <p>Kategori: <?= htmlspecialchars($detailProduct['kategori']) ?></p>
        <p>Nama Petani: <?= htmlspecialchars($detailProduct['petani']) ?></p>
        <p>Harga: Rp<?= number_format($detailProduct['harga'], 0, ',', '.') ?></p>
        <p>Stok: <?= htmlspecialchars($detailProduct['stok']) ?></p>
        <p>Deskripsi: <?= htmlspecialchars($detailProduct['deskripsi']) ?></p>

        <a href="filter-search.php">Kembali ke katalog</a>

    <?php else: ?>

        <h2>Produk tidak ditemukan.</h2>
        <a href="filter-search.php">Kembali ke katalog</a>

    <?php endif; ?>

</body>
</html>
