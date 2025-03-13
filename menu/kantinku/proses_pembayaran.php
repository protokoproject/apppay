<?php
session_start();
include "../../conn/koneksi.php"; 

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Data tidak diterima"]);
    error_log("Data JSON tidak diterima: " . file_get_contents("php://input"));
    exit;
}


if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "User belum login"]);
    exit;
}

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

// Insert ke t_jual
$stmt = $koneksi->prepare("INSERT INTO t_jual (id_jual, id_kantin, id_user, tgl_jual, nt_jual, rate, kom) VALUES (?, ?, ?, ?, ?, 0, '')");
$stmt->bind_param("iiiss", $id_jual, $kantin_id, $id_user, $tgl_jual, $nt_jual);

if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan transaksi utama: " . $stmt->error]);
    exit;
}

$stmt->close();

// Insert ke t_jualdtl
$insertDetail = $koneksi->prepare("INSERT INTO t_jualdtl (id_jual, kd_brg, qty, hrgj, dis1, dis2) VALUES (?, ?, ?, ?, 0, 0)");

if (!$insertDetail) {
    echo json_encode(["status" => "error", "message" => "Query t_jualdtl gagal: " . $koneksi->error]);
    exit;
}

foreach ($menus as $menu) {
    $menuName = $menu['name'];
    $quantity = intval($menu['quantity']);
    $price = intval(preg_replace('/\D/', '', $menu['price'])); // Menghapus karakter non-digit

    if ($price <= 0) {
        echo json_encode(["status" => "error", "message" => "Harga tidak valid untuk: " . $menuName]);
        exit;
    }

    // Ambil kd_brg berdasarkan nama menu dari t_brg
    $queryBarang = $koneksi->prepare("SELECT kd_brg FROM t_brg WHERE nm_brg = ?");
    $queryBarang->bind_param("s", $menuName);
    $queryBarang->execute();
    $resultBarang = $queryBarang->get_result();

    if ($resultBarang->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Barang tidak ditemukan: " . $menuName]);
        exit;
    }

    $barangData = $resultBarang->fetch_assoc();
    $kd_brg = $barangData['kd_brg'];

    if (!$kd_brg || $quantity <= 0) {
        echo json_encode(["status" => "error", "message" => "Data tidak valid untuk: " . $menuName]);
        exit;
    }

    $insertDetail->bind_param("isii", $id_jual, $kd_brg, $quantity, $price);
    if (!$insertDetail->execute()) {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan detail transaksi untuk: " . $menuName . " - " . $insertDetail->error]);
        exit;
    }
}

// Jika semua berhasil
$insertDetail->close();
$koneksi->close();

echo json_encode(["status" => "success", "message" => "Pembayaran berhasil!", "redirect" => "struk.php"]);
?>
