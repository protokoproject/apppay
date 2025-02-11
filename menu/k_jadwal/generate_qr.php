<?php
require __DIR__ . '/vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

if (isset($_GET['id_jadwal']) && isset($_GET['id_kls'])) {
    $id_jadwal = $_GET['id_jadwal'];
    $id_kls = $_GET['id_kls'];
    
    // Mendapatkan tanggal dan waktu saat ini
    date_default_timezone_set('Asia/Jakarta'); // Sesuaikan dengan zona waktu lokal
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    // Format QR Code
    $qr_text = "id_jadwal:$id_jadwal;id_kls:$id_kls;tgl:$tanggal;jam:$jam";

    // Generate QR Code
    $qrCode = new QrCode($qr_text);
    $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelMedium());
    $qrCode->setSize(300);
    $qrCode->setMargin(10);
    $qrCode->setRoundBlockSizeMode(new RoundBlockSizeModeMargin());

    // Output QR Code sebagai gambar PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    header('Content-Type: image/png');
    echo $result->getString();
    exit;
}
?>
