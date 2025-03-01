<?php
include '../../conn/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qr_data'])) {
    $qr_data = $_POST['qr_data'];
    
    // Validasi format QR Code menggunakan regex
    $pattern = '/^id_jadwal:\d+;id_kls:\d+;tgl:\d{4}-\d{2}-\d{2};jam:\d{2}:\d{2}:\d{2}$/';

    if (!preg_match($pattern, $qr_data)) {
        echo json_encode(['status' => 'error', 'message' => 'Format QR Code tidak valid']);
        exit;
    }

    // Parse data QR Code
    parse_str(str_replace([';', ':'], ['&', '='], $qr_data), $qr_values);
    
    if (!isset($qr_values['id_jadwal'], $qr_values['id_kls'], $qr_values['tgl'], $qr_values['jam'])) {
        echo json_encode(['status' => 'error', 'message' => 'Format QR Code tidak valid']);
        exit;
    }
    
    $id_jadwal = (int)$qr_values['id_jadwal'];
    $id_kls = (int)$qr_values['id_kls'];
    $tgl_qr = $qr_values['tgl']; // Tanggal dari QR Code
    $jam_qr = $qr_values['jam']; // Jam dari QR Code

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

    // Validasi apakah murid terdaftar di kelas yang sesuai dengan QR Code
    $query_kelas = "SELECT id_kls FROM t_klsmrd WHERE id_mrd = ?";
    $stmt_kelas = $koneksi->prepare($query_kelas);
    $stmt_kelas->bind_param("i", $id_mrd);
    $stmt_kelas->execute();
    $result_kelas = $stmt_kelas->get_result();
    $kelas_data = $result_kelas->fetch_assoc();
    $stmt_kelas->close();

    if (!$kelas_data || $kelas_data['id_kls'] != $id_kls) {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak terdaftar di kelas ini']);
        exit;
    }

    // Set waktu absensi sesuai waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    $tgl_abs = date('Y-m-d'); // Tanggal saat ini
    $jam_abs = date('H:i:s');
    $ket_abs = "Hadir"; // Set default keterangan absensi

    // **Validasi: Absensi hanya bisa dilakukan pada tanggal yang ada di QR Code**
    if ($tgl_abs !== $tgl_qr) {
        echo json_encode(['status' => 'error', 'message' => 'Absensi hanya bisa dilakukan pada tanggal yang tertera di QR Code']);
        exit;
    }

    // **Validasi: Jika murid sudah absen pada tanggal yang ada di QR Code, tampilkan pesan error**
    $query_check = "SELECT id_absen FROM t_absen WHERE id_mrd = ? AND id_jadwal = ? AND tgl_abs = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param("iis", $id_mrd, $id_jadwal, $tgl_qr);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah berhasil absen pada tanggal ini.']);
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
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("iiissss", $id_absen, $id_mrd, $id_jadwal, $id_kls, $tgl_abs, $jam_abs, $ket_abs);
    
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
