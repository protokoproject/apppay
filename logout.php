<?php
session_start();

// Ambil username dari session
$username = $_SESSION['username'];

// Hapus session
session_destroy();

// Output JavaScript untuk menghapus localStorage yang terkait dengan username
echo "<script>
    localStorage.removeItem('selectedMenus_' + '{$username}');
    window.location.href = 'login.php'; // Redirect ke halaman login
</script>";
?>