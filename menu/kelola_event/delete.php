<?php
include '../../conn/koneksi.php';

// Cek apakah parameter ID tersedia
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query untuk menghapus data event
    $sql = "DELETE FROM tb_events WHERE id_event = '$id'";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
            alert('Event berhasil dihapus!');
            window.location.href = 'event.php';
        </script>";
    } else {
        $error_message = addslashes(mysqli_error($koneksi));
        echo "<script>
            alert('Terjadi kesalahan saat menghapus data: $error_message');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('ID tidak ditemukan!');
        window.location.href = 'event.php';
    </script>";
    exit;
}
?>
