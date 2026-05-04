<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    require_once 'config/database.php';
    
    $errors = [];
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    if ($id) {
        $stmt_get = mysqli_prepare($conn, "SELECT * FROM kategori WHERE id_kategori = ?");
        mysqli_stmt_bind_param($stmt_get, "i", $id);
        mysqli_stmt_execute($stmt_get);
        $result = mysqli_stmt_get_result($stmt_get);
        $data = mysqli_fetch_assoc($result);

        if (!$data) {
            echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
            exit;
        }
        
        $kode = $data['kode_kategori'];
        $nama = $data['nama_kategori'];
        $deskripsi = $data['deskripsi'];
        $status = $data['status'];
    } else {
        header("Location: index.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_baru = htmlspecialchars(trim($_POST['kode_kategori']));
        $nama_baru = htmlspecialchars(trim($_POST['nama_kategori']));
        $desk_baru = htmlspecialchars(trim($_POST['deskripsi']));
        $stat_baru = $_POST['status'];

//validasi
        if (empty($kode_baru)) {
            $errors[] = "Kode Kategori wajib diisi.";
        } elseif (strlen($kode_baru) < 4 || strlen($kode_baru) > 10) {
            $errors[] = "Kode Kategori harus 4-10 karakter.";
        } elseif (substr($kode_baru, 0, 4) !== "KAT-") {
            $errors[] = "Kode Kategori harus diawali 'KAT-'.";
        } else {
            if ($kode_baru !== $data['kode_kategori']) {
                $stmt_cek = mysqli_prepare($conn, "SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
                mysqli_stmt_bind_param($stmt_cek, "si", $kode_baru, $id);
                mysqli_stmt_execute($stmt_cek);
                mysqli_stmt_store_result($stmt_cek);
                if (mysqli_stmt_num_rows($stmt_cek) > 0) {
                    $errors[] = "Kode Kategori '$kode_baru' sudah digunakan oleh data lain.";
                }
                mysqli_stmt_close($stmt_cek);
            }
        }

//validasi nama kategori
        if (empty($nama_baru)) {
            $errors[] = "Nama Kategori wajib diisi.";
        } elseif (strlen($nama_baru) < 3 || strlen($nama_baru) > 50) {
            $errors[] = "Nama Kategori harus 3-50 karakter.";
        }

        // --- VALIDASI DESKRIPSI ---
        if (!empty($desk_baru) && strlen($desk_baru) > 200) {
            $errors[] = "Deskripsi maksimal 200 karakter.";
        }

        if (empty($errors)) {
            $stmt_upd = mysqli_prepare($conn, "UPDATE kategori SET kode_kategori = ?, nama_kategori = ?, deskripsi = ?, status = ? WHERE id_kategori = ?");
            mysqli_stmt_bind_param($stmt_upd, "ssssi", $kode_baru, $nama_baru, $desk_baru, $stat_baru, $id);
            
            if (mysqli_stmt_execute($stmt_upd)) {
                echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
                exit;
            } else {
                $errors[] = "Gagal memperbarui database.";
            }
            mysqli_stmt_close($stmt_upd);
        }
        
        $kode = $kode_baru;
        $nama = $nama_baru;
        $deskripsi = $desk_baru;
        $status = $stat_baru;
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning py-3">
                        <h4 class="mb-0 text-dark">Edit Kategori</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $err): ?> <li><?= $err ?></li> <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Kategori</label>
                                <input type="text" name="kode_kategori" class="form-control" 
                                       value="<?= htmlspecialchars($kode) ?>" required>
                                <small class="text-muted">Format wajib: KAT- (Contoh: KAT-002)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control" 
                                       value="<?= htmlspecialchars($nama) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="aktif" value="Aktif" 
                                           <?= ($status == 'Aktif') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="nonaktif" value="Nonaktif" 
                                           <?= ($status == 'Nonaktif') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="nonaktif">Nonaktif</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Deskripsi (Opsional)</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($deskripsi) ?></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                                <a href="index.php" class="btn btn-light border px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>