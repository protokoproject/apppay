<?php
session_start();
include "../../conn/koneksi.php"; 

header("Content-Type: application/json"); // Pastikan respons dalam format JSON

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Data tidak diterima"]);
    exit;
}

// Pastikan user login
if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "User belum login"]);
    exit;
}

// Ambil id_user dari username
$username = $_SESSION['username'];
$queryUser = $koneksi->prepare("SELECT id_user FROM tb_user WHERE username = ?");
$queryUser->bind_param("s", $username);
$queryUser->execute();
$resultUser = $queryUser->get_result();

if ($resultUser->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User tidak ditemukan"]);
    exit;
}

$userData = $resultUser->fetch_assoc();
$id_user = $userData['id_user'];

$kantin_id = $data['kantin_id'] ?? null;
$menus = $data['menus'] ?? [];

if (!$kantin_id || empty($menus)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap!"]);
    exit;
}

// Mendapatkan ID Jual terakhir
$queryLastId = $koneksi->query("SELECT id_jual FROM t_jual ORDER BY id_jual DESC LIMIT 1");
$row = $queryLastId->fetch_assoc();
$id_jual = $row ? intval($row['id_jual']) + 1 : 1;

// Membuat kode transaksi (nt_jual)
$date = date("Ymd");
$queryNTJual = $koneksi->query("SELECT nt_jual FROM t_jual WHERE nt_jual LIKE 'TRX{$date}%' ORDER BY nt_jual DESC LIMIT 1");
$rowNT = $queryNTJual->fetch_assoc();

$newChar = ($rowNT) ? chr(ord(substr($rowNT['nt_jual'], -1)) + 1) : "A";
$nt_jual = "TRX" . $date . $newChar;
$tgl_jual = date("Y-m-d");

// Nilai default untuk rate dan kom
$rate = 0;
$kom = "";

$stmt = $koneksi->prepare("INSERT INTO t_jual (id_jual, id_kantin, id_user, tgl_jual, nt_jual, rate, kom) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Query gagal: " . $koneksi->error]);
    exit;
}

$stmt->bind_param("iiissis", $id_jual, $kantin_id, $id_user, $tgl_jual, $nt_jual, $rate, $kom);
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Pembayaran berhasil!", "redirect" => "struk.php"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan transaksi: " . $stmt->error]);
}

$stmt->close();
$koneksi->close();
?>
