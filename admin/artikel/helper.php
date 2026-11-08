<?php
function daftar_kategori($conn) {
    $r = mysqli_query($conn, "SELECT id, nama FROM kategori_artikel ORDER BY nama");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function ambil_input() {
    $status = $_POST['status'] ?? 'draft';
    return [
        'judul'       => trim($_POST['judul'] ?? ''),
        'kategori_id' => (int)($_POST['kategori_id'] ?? 0),
        'ringkasan'   => trim($_POST['ringkasan'] ?? ''),
        'isi'         => trim($_POST['isi'] ?? ''),
        'status'      => in_array($status, ['draft', 'publish'], true) ? $status : 'draft',
    ];
}

function validasi($d) {
    if ($d['judul'] === '' || strlen($d['judul']) > 150) return 'Judul wajib diisi (maksimal 150 karakter).';
    if ($d['kategori_id'] <= 0) return 'Pilih kategori.';
    if ($d['ringkasan'] === '' || strlen($d['ringkasan']) > 255) return 'Ringkasan wajib diisi (maksimal 255 karakter).';
    if ($d['isi'] === '') return 'Isi artikel wajib diisi.';
    return '';
}

function buat_slug($conn, $judul) {
    $dasar = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($judul)), '-');
    $dasar = substr($dasar === '' ? 'artikel' : $dasar, 0, 150);
    $slug = $dasar;
    $i = 2;
    while (true) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM artikel WHERE slug = ?");
        mysqli_stmt_bind_param($stmt, 's', $slug);
        mysqli_stmt_execute($stmt);
        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) === 0) return $slug;
        $slug = $dasar . '-' . $i++;
    }
}