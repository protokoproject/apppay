<?php
include '../../conn/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qr_data'])) {
    $qr_data = $_POST['qr_data'];
    
    // Parse data QR Code
    parse_str(str_replace([';', ':'], ['&', '='], $qr_data), $qr_values);
    
    if (!isset($qr_values['id_jadwal'], $qr_values['id_kls'], $qr_values['tgl'], $qr_values['jam'])) {
        echo json_encode(['status' => 'error', 'message' => 'Format QR Code tidak valid']);
        exit;
    }
    
    $id_jadwal = (int)$qr_values['id_jadwal'];
    $id_kls = (int)$qr_values['id_kls'];
    $tgl_abs = $qr_values['tgl'];
    $jam_abs = $qr_values['jam'];
    
    if (!isset($_SESSION['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'User tidak terautentikasi']);
        exit;
    }
    
    $username = $_SESSION['username'];
    
    // Ambil id_user dari tb_user berdasarkan username
    $query_user = "SELECT id_user FROM tb_user WHERE username = ?";
    $stmt_user = $koneksi->prepare($query_user);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user_data = $result_user->fetch_assoc();
    $stmt_user->close();
    
    if (!$user_data) {
        echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
        exit;
    }
    
    $id_user = $user_data['id_user'];
    
    // Ambil id_mrd dari t_murid berdasarkan id_user
    $query_murid = "SELECT id_mrd FROM t_murid WHERE id_user = ?";
    $stmt_murid = $koneksi->prepare($query_murid);
    $stmt_murid->bind_param("i", $id_user);
    $stmt_murid->execute();
    $result_murid = $stmt_murid->get_result();
    $murid_data = $result_murid->fetch_assoc();
    $stmt_murid->close();
    
    if (!$murid_data) {
        echo json_encode(['status' => 'error', 'message' => 'Data murid tidak ditemukan']);
        exit;
    }
    
    $id_mrd = $murid_data['id_mrd'];
    
    // Cek apakah sudah absen sebelumnya
    $query_check = "SELECT id_absen FROM t_absen WHERE id_mrd = ? AND id_jadwal = ? AND tgl_abs = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param("iis", $id_mrd, $id_jadwal, $tgl_abs);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah absen hari ini']);
        exit;
    }
    
    $stmt_check->close();
    
    // Generate id_absen secara otomatis
    $query_auto = "SELECT COALESCE(MAX(id_absen), 0) + 1 AS new_id FROM t_absen";
    $result_auto = mysqli_query($koneksi, $query_auto);
    $row_auto = mysqli_fetch_assoc($result_auto);
    $id_absen = $row_auto['new_id'];

    // Insert data ke t_absen
    $query_insert = "INSERT INTO t_absen (id_absen, id_mrd, id_jadwal, id_kls, tgl_abs, jam_abs, ket_abs) 
                     VALUES (?, ?, ?, ?, ?, ?, '')";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("iiisss", $id_absen, $id_mrd, $id_jadwal, $id_kls, $tgl_abs, $jam_abs);
    
    if ($stmt_insert->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Absensi berhasil disimpan']);
    } else {
        error_log("Error Insert: " . $stmt_insert->error);
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan absensi']);
    }
    
    $stmt_insert->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
