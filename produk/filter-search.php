
<?php
$products = [
    [
        'id' => 1,
        'nama' => 'Tomat',
        'kategori' => 'Sayuran',
        'petani' => 'Pak Budi',
        'harga' => 12000
    ],
    [
        'id' => 2,
        'nama' => 'Pisang',
        'kategori' => 'Buah',
        'petani' => 'Bu Siti',
        'harga' => 15000
    ],
    [
        'id' => 3,
        'nama' => 'Jagung',
        'kategori' => 'Biji-bijian',
        'petani' => 'Pak Andi',
        'harga' => 8000
    ]
];

$search = $_GET['search'] ?? '';
$kategori = $_GET['kategori'] ?? '';

$filteredProducts = [];

foreach ($products as $product) {
    $cocokSearch = stripos($product['nama'], $search) !== false ||
                   stripos($product['petani'], $search) !== false;

    $cocokKategori = $kategori === '' ||
                     $product['kategori'] === $kategori;

    if ($cocokSearch && $cocokKategori) {
        $filteredProducts[] = $product;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Search dan Filter Produk - BuyPanen</title>
</head>
<body>

    <h2>Katalog Hasil Panen</h2>

    <form method="GET">
        <input
            type="text"
            name="search"
            placeholder="Cari produk atau petani..."
            value="<?= htmlspecialchars($search) ?>"
        >

        <select name="kategori">
            <option value="">Semua Kategori</option>
            <option value="Sayuran" <?= $kategori === 'Sayuran' ? 'selected' : '' ?>>Sayuran</option>
            <option value="Buah" <?= $kategori === 'Buah' ? 'selected' : '' ?>>Buah</option>
            <option value="Biji-bijian" <?= $kategori === 'Biji-bijian' ? 'selected' : '' ?>>Biji-bijian</option>
        </select>

        <button type="submit">Cari</button>
    </form>

    <?php foreach ($filteredProducts as $product): ?>
        <div>
            <h3><?= htmlspecialchars($product['nama']) ?></h3>
            <p>Petani: <?= htmlspecialchars($product['petani']) ?></p>
            <p>Kategori: <?= htmlspecialchars($product['kategori']) ?></p>
            <p>Harga: Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>

            <a href="detail-produk.php?id=<?= $product['id'] ?>">
                Lihat Detail
            </a>
        </div>
    <?php endforeach; ?>

    <?php if (empty($filteredProducts)): ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>

</body>
</html>
