<?php
include "../../conn/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_sts_user = $_POST['kd_sts_user'];
    $kd_menu = $_POST['kd_menu'];

    foreach ($kd_menu as $menu) {
        $view_menu = isset($_POST['view_menu'][$menu]) ? 1 : 0;
        $tmbh_menu = isset($_POST['tmbh_menu'][$menu]) ? 1 : 0;
        $edit_menu = isset($_POST['edit_menu'][$menu]) ? 1 : 0;
        $hapus_menu = isset($_POST['hapus_menu'][$menu]) ? 1 : 0;
        $lainnya = isset($_POST['lainnya'][$menu]) ? 1 : 0;

        $query = "
            UPDATE tb_role_akses 
            SET view_menu = '$view_menu', tmbh_menu = '$tmbh_menu', edit_menu = '$edit_menu', hapus_menu = '$hapus_menu', lainnya = '$lainnya' 
            WHERE kd_sts_user = '$kd_sts_user' AND kd_menu = '$menu'
        ";

        mysqli_query($koneksi, $query);
    }

    // Tampilkan alert dan redirect
    echo "
        <script>
            alert('Berhasil Mengubah Role Akses');
            window.location.href = 'akses.php';
        </script>
    ";
}
?>
