<?php
session_start();

// Periksa apakah session username ada
$response = ['session_exists' => isset($_SESSION['username'])];
header('Content-Type: application/json');
echo json_encode($response);
?>