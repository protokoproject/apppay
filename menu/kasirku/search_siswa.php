<?php
// include koneksi database
include '../../conn/koneksi.php'; // pastikan file ini ada dan di dalamnya variabel $koneksi sudah terdefinisi

if (isset($_POST['query'])) {
    $search = $koneksi->real_escape_string($_POST['query']);

    $sql = "
    SELECT t_murid.nm_murid, t_kelas.nm_kls, t_murid.id_user
    FROM t_murid
    JOIN t_klsmrd ON t_murid.id_mrd = t_klsmrd.id_mrd
    JOIN t_kelas ON t_klsmrd.id_kls = t_kelas.id_kls
    WHERE t_murid.nm_murid LIKE '%$search%'
    LIMIT 10
";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nm_murid = htmlspecialchars($row['nm_murid']);
            $nm_kls = htmlspecialchars($row['nm_kls']);
            $id_user = htmlspecialchars($row['id_user']); // pastikan kolom ini ada

            echo '<a href="#" class="list-group-item list-group-item-action" data-id="' . $id_user . '" data-nama="' . $nm_murid . '">'
                . $nm_murid . ' - ' . $nm_kls . '</a>';
        }
    }
}
