<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    require_once 'config/database.php';
        
    $errors = [];
    $kode = '';
    $nama = '';
    $deskripsi = '';
    $status = 'Aktif';
        
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 1. Ambil dan sanitasi data (Poin C)
        $kode = htmlspecialchars(trim($_POST['kode_kategori']));
        $nama = htmlspecialchars(trim($_POST['nama_kategori']));
        $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
        $status = isset($_POST['status']) ? $_POST['status'] : 'Aktif';

        if (empty($kode)) {
            $errors[] = "Kode Kategori wajib diisi.";
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors[] = "Kode Kategori harus 4-10 karakter.";
        } elseif (substr($kode, 0, 4) !== "KAT-") {
            $errors[] = "Kode Kategori harus diawali 'KAT-'.";
        } else {
            $stmt_cek = mysqli_prepare($conn, "SELECT id_kategori FROM kategori WHERE kode_kategori = ?");
            mysqli_stmt_bind_param($stmt_cek, "s", $kode);
            mysqli_stmt_execute($stmt_cek);
            mysqli_stmt_store_result($stmt_cek);
            if (mysqli_stmt_num_rows($stmt_cek) > 0) {
                $errors[] = "Kode Kategori sudah terdaftar.";
            }
            mysqli_stmt_close($stmt_cek);
        }

        if (empty($nama)) {
            $errors[] = "Nama Kategori wajib diisi.";
        } elseif (strlen($nama) < 3 || strlen($nama) > 50) {
            $errors[] = "Nama Kategori harus 3-50 karakter.";
        }

        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors[] = "Deskripsi maksimal 200 karakter.";
        }

        if (empty($errors)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $kode, $nama, $deskripsi, $status);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data Berhasil Disimpan!'); window.location='index.php';</script>";
                exit();
            } else {
                $errors[] = "Gagal menyimpan data ke database.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    ?>
        
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                                                
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Kategori</label>
                                <input type="text" name="kode_kategori" class="form-control" value="<?= htmlspecialchars($kode) ?>" required>
                                <small class="text-muted">Contoh: KAT-001 (4-10 karakter)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($nama) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="aktif" value="Aktif" <?= ($status == 'Aktif') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="nonaktif" value="Nonaktif" <?= ($status == 'Nonaktif') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="nonaktif">Nonaktif</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Deskripsi (Opsional)</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($deskripsi) ?></textarea>
                            </div>
                                                        
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                <a href="index.php" class="btn btn-secondary px-4">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>