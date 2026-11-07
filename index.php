<?php
session_start();
require_once 'auth/database.php';

// Ambil data produk yang statusnya 'tayang' beserta nama petani dan kategorinya
$query = "SELECT produk.*, users.nama AS nama_petani, petani.no_whatsapp, kategori.nama_kategori 
          FROM produk 
          JOIN users ON produk.user_id = users.id 
          LEFT JOIN petani ON users.id = petani.user_id
          JOIN kategori ON produk.kategori_id = kategori.id
          WHERE produk.status = 'tayang'
          ORDER BY produk.id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUYPANEN - Marketplace Hasil Panen Lokal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">🌾 BUYPANEN</a>
            <div class="ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="petani/profil.php" class="btn btn-light btn-sm me-2">Profil Petani</a>
                    <a href="config/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
                <?php else: ?>
                    <a href="config/login.php" class="btn btn-light btn-sm me-2">Login Petani</a>
                    <a href="config/register.php" class="btn btn-warning btn-sm">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Banner Hero -->
    <div class="bg-white py-5 mb-4 border-bottom text-center">
        <div class="container">
            <h1 class="fw-bold text-success">Katalog Hasil Panen Lokal</h1>
            <p class="text-muted">Beli langsung hasil pertanian segar dari petani lokal tanpa perantara.</p>
        </div>
    </div>

    <!-- Main Content: Grid Produk -->
    <div class="container pb-5">
        <div class="row g-4">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="assets/uploads/<?= htmlspecialchars($row['foto'] ?? ''); ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($row['nama_produk']); ?>"
                                 style="height: 200px; object-fit: cover;"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=Foto+Panen'">
                            <div class="card-body">
                                <span class="badge bg-success mb-2"><?= htmlspecialchars($row['nama_kategori']); ?></span>
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($row['nama_produk']); ?></h5>
                                <p class="text-success fw-semibold fs-5 mb-1">
                                    Rp <?= number_format($row['harga'], 0, ',', '.'); ?> / <?= htmlspecialchars($row['satuan']); ?>
                                </p>
                                <p class="text-muted small mb-2">Petani: <?= htmlspecialchars($row['nama_petani']); ?></p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <a href="produk/detail-produk.php?id=<?= $row['id']; ?>" class="btn btn-outline-success w-100">Detail & Hubungi WA</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">Belum ada produk hasil panen yang diunggah.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>