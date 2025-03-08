<?php
include '../../conn/koneksi.php'; // Pastikan file koneksi database sudah terhubung

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kantin_id'])) {
    $kantin_id = $_POST['kantin_id'];

    // Query untuk mengambil nama kantin berdasarkan kantin_id
    $query_kantin = "SELECT nm_kantin FROM t_kantin WHERE id_kantin = '$kantin_id'";
    $result_kantin = mysqli_query($koneksi, $query_kantin);

    if ($result_kantin && mysqli_num_rows($result_kantin) > 0) {
        $row_kantin = mysqli_fetch_assoc($result_kantin);
        echo $row_kantin['nm_kantin']; // Kembalikan nama kantin
    } else {
        echo "Nama Kantin Tidak Ditemukan";
    }
    exit; // Hentikan eksekusi script setelah mengembalikan data
}
?>