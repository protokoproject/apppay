<?php
// Koneksi ke database
$host = 'localhost';
$db = 'apppay'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Ambil data event dari tabel di database
$sql = "SELECT id, title, start_date, end_date FROM tb_events"; // Sesuaikan nama tabel dan kolom
$result = $connection->query($sql);

$events = [];

if ($result->num_rows > 0) {
    // Loop melalui hasil dan buat array event
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start_date'],
            'end' => $row['end_date']
        ];
    }
}

// Set header JSON dan kembalikan data event
header('Content-Type: application/json');
echo json_encode($events);

$connection->close();
?>
