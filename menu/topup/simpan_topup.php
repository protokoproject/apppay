<?php
include '../../conn/koneksi.php';

$id_mrd = $_GET['id_mrd'];

$queryMax = mysqli_query($koneksi, "SELECT MAX(id_hisdp) as max_id FROM t_hisdepo");
$dataMax = mysqli_fetch_assoc($queryMax);
$lastId = $dataMax['max_id'];
$newId = $lastId ? $lastId + 1 : 1;

$queryUser = mysqli_query($koneksi, "
  SELECT u.id_user 
  FROM tb_user u
  INNER JOIN t_murid m ON u.id_user = m.id_user
  WHERE m.id_mrd = '$id_mrd'
");

if ($row = mysqli_fetch_assoc($queryUser)) {
    $id_user = $row['id_user'];
} else {
    echo "ID User tidak ditemukan.";
    exit;
}

$nom_dp = isset($_POST['jumlah_topup']) ? $_POST['jumlah_topup'] : '0';
$nom_dp = preg_replace('/\D/', '', $nom_dp);

$tgl_dp = date('Y-m-d');
$idva = 'VANULL';
$stsdp = '0';

$insert = mysqli_query($koneksi, "
  INSERT INTO t_hisdepo (id_hisdp, idva, id_user, nom_dp, tgl_dp, stsdp) 
  VALUES ('$newId', '$idva', '$id_user', '$nom_dp', '$tgl_dp', '$stsdp')
");

if ($insert) {
    echo "Top up sebesar Rp " . number_format($nom_dp, 0, ',', '.') . " berhasil dicatat.";
} else {
    echo "Gagal menyimpan data top up: " . mysqli_error($koneksi);
}
?>
