<?php
include "../../conn/koneksi.php";

// Periksa apakah parameter id_kls dan id_mrd ada di URL
if (isset($_GET['id_kls']) && isset($_GET['id_mrd'])) {
    $id_kls = $_GET['id_kls'];
    $id_mrd = $_GET['id_mrd'];

    // Query untuk menghapus data berdasarkan id_kls dan id_mrd
    $query = "DELETE FROM t_klsmrd WHERE id_kls = '$id_kls' AND id_mrd = '$id_mrd'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'kls_mrd.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat menghapus data!');
            window.location.href = 'kls_mrd.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID kelas atau ID murid tidak ditemukan!');
        window.location.href = 'kls_mrd.php';
    </script>";
}
?>
