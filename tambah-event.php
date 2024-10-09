<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event</title>
</head>
<body>
    <h2>Form Tambah Event</h2>
    <form action="tambah-event.php" method="POST">
        <label for="title">Judul Event:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="start_date">Tanggal Mulai:</label><br>
        <input type="date" id="start_date" name="start_date" required><br><br>
        
        <label for="end_date">Tanggal Selesai:</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>
        
        <input type="submit" value="Tambahkan Event">
    </form>

    <?php
    // Koneksi ke database
$host = 'localhost';
$db = 'apppay'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda
// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Koneksi ke database
    $connection = new mysqli($host, $user, $pass, $db);

    if ($connection->connect_error) {
        die("Koneksi gagal: " . $connection->connect_error);
    }

    // Insert event baru ke tabel
    $sql = "INSERT INTO tb_events (title, start_date, end_date) VALUES ('$title', '$start_date', '$end_date')";

    if ($connection->query($sql) === TRUE) {
        echo "Event berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}
?>

</body>
</html>
