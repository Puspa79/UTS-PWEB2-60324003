<?php
require_once 'config/database.php';

$result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .btn-custom-gap { margin-right: 0.3cm; }
        .card { border: none; border-radius: 10px; }
    </style>
</head>
<body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0">Data Kategori</h3>
        <a href="create.php" class="btn btn-primary px-4 shadow-sm">Tambah Kategori</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="10%">ID Kategori</th> 
                        <th width="12%">Kode</th>
                        <th width="20%">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center" width="10%">Status</th>
                        <th class="text-center" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($result && mysqli_num_rows($result) > 0):
                    $no = 1; 
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $no++; ?></td>
                        <td class="text-center text-muted"><?= $row['id_kategori']; ?></td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <?= $row['kode_kategori']; ?>
                            </span>
                        </td>
                        <td class="fw-bold"><?= $row['nama_kategori']; ?></td>
                        <td class="text-muted small">
                            <?= $row['deskripsi'] ? $row['deskripsi'] : '-'; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-<?= $row['status'] == 'Aktif' ? 'success' : 'danger'; ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id_kategori']; ?>" 
                               class="btn btn-sm btn-warning btn-custom-gap text-dark fw-bold">
                               Edit
                            </a>
                            
                            <a href="delete.php?id=<?= $row['id_kategori']; ?>" 
                               onclick="return confirm('Yakin ingin menghapus data ini?')" 
                               class="btn btn-sm btn-danger fw-bold">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php 
                    endwhile; 
                else: 
                ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada data kategori. Klik tombol <strong>+ Tambah Kategori</strong> untuk memulai.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>