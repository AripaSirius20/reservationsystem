<?php
// dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] == 'admin') {
    echo "Welcome, Admin!";
    // Admin kontrol paneline yönlendirme
} else {
    echo "Welcome, Customer!";
    // Müşteri ana sayfasına yönlendirme
}
?>
