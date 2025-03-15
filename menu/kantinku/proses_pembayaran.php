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

// Hitung total harga pesanan
$total_harga = 0;
foreach ($menus as $menu) {
    $total_harga += intval($menu['price']) * intval($menu['quantity']);
}

// Cek saldo pengguna di t_murid
$querySaldo = $koneksi->prepare("SELECT saldo FROM t_murid WHERE id_user = ?");
$querySaldo->bind_param("i", $id_user);
$querySaldo->execute();
$resultSaldo = $querySaldo->get_result();

if ($resultSaldo->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Saldo tidak ditemukan"]);
    exit;
}

$saldoData = $resultSaldo->fetch_assoc();
$saldo = intval($saldoData['saldo']);

if ($saldo < $total_harga) {
    echo json_encode(["status" => "error", "message" => "Saldo anda tidak mencukupi, silakan top up terlebih dahulu"]);
    exit;
}

// Jika saldo mencukupi, lanjutkan proses pembayaran
$queryLastId = $koneksi->query("SELECT id_jual FROM t_jual ORDER BY id_jual DESC LIMIT 1");
$row = $queryLastId->fetch_assoc();
$id_jual = $row ? intval($row['id_jual']) + 1 : 1;

$date = date("Ymd");
$queryNTJual = $koneksi->query("SELECT nt_jual FROM t_jual WHERE nt_jual LIKE 'TRX{$date}%' ORDER BY nt_jual DESC LIMIT 1");
$rowNT = $queryNTJual->fetch_assoc();
$newChar = ($rowNT) ? chr(ord(substr($rowNT['nt_jual'], -1)) + 1) : "A";
$nt_jual = "TRX" . $date . $newChar;
$tgl_jual = date("Y-m-d");

$stmt = $koneksi->prepare("INSERT INTO t_jual (id_jual, id_kantin, id_user, tgl_jual, nt_jual, rate, kom) VALUES (?, ?, ?, ?, ?, 0, '')");
$stmt->bind_param("iiiss", $id_jual, $kantin_id, $id_user, $tgl_jual, $nt_jual);

if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan transaksi utama: " . $stmt->error]);
    exit;
}

$stmt->close();

$insertDetail = $koneksi->prepare("INSERT INTO t_jualdtl (id_jual, kd_brg, qty, hrgj, dis1, dis2) VALUES (?, ?, ?, ?, 0, 0)");
if (!$insertDetail) {
    echo json_encode(["status" => "error", "message" => "Query t_jualdtl gagal: " . $koneksi->error]);
    exit;
}

foreach ($menus as $menu) {
    $menuName = $menu['name'];
    $quantity = intval($menu['quantity']);
    $price = intval($menu['price']);

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

    $insertDetail->bind_param("isii", $id_jual, $kd_brg, $quantity, $price);
    if (!$insertDetail->execute()) {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan detail transaksi untuk: " . $menuName . " - " . $insertDetail->error]);
        exit;
    }
}

$insertDetail->close();

// Kurangi saldo pengguna
$newSaldo = $saldo - $total_harga;
$updateSaldo = $koneksi->prepare("UPDATE t_murid SET saldo = ? WHERE id_user = ?");
$updateSaldo->bind_param("ii", $newSaldo, $id_user);
if (!$updateSaldo->execute()) {
    echo json_encode(["status" => "error", "message" => "Gagal mengupdate saldo: " . $updateSaldo->error]);
    exit;
}

$updateSaldo->close();
$koneksi->close();

echo json_encode(["status" => "success", "message" => "Pembayaran berhasil!", "redirect" => "struk.php"]);
?>
