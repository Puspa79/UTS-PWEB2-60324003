<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    $query = "DELETE FROM kategori WHERE id_kategori = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>
                    alert('Data kategori berhasil dihapus!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal: Data tidak ditemukan atau sudah dihapus sebelumnya.');
                    window.location.href = 'index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Terjadi kesalahan sistem saat menghapus data.');
                window.location.href = 'index.php';
              </script>";
    }

    mysqli_stmt_close($stmt);

} else {
    header("Location: index.php");
}

mysqli_close($conn);
?>