<?php
include "../../conn/koneksi.php";

if (isset($_GET['kantin_id'])) {
    $kantin_id = $_GET['kantin_id'];
    $sql = "SELECT id_brg, nm_brg, hrg_jual FROM t_brg WHERE id_kantin = '$kantin_id'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<li class="tf-card-list medium bt-line">
                    <div class="info">
                        <h4 class="fw_6">' . htmlspecialchars($row["nm_brg"]) . '</h4>
                        <p>Rp. ' . number_format($row["hrg_jual"], 0, ',', '.') . ',-</p>
                    </div>
                    <input type="checkbox" class="tf-checkbox circle-check">
                  </li>';
        }
    } else {
        echo "<p>Tidak ada menu tersedia</p>";
    }
}
?>
