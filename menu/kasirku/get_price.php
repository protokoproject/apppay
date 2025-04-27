<?php
include '../../conn/koneksi.php'; // koneksi ke database kamu

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $stmt = $koneksi->prepare("SELECT hrg_jual FROM t_brg WHERE nm_brg = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($price);

    if ($stmt->fetch()) {
        echo json_encode(['price' => $price]);
    } else {
        echo json_encode(['price' => 0]);
    }

    $stmt->close();
}
?>
