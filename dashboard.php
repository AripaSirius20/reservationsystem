<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <nav>
    <ul>
        <li><a href="index.php">Ana Sayfa</a></li>
        <li><a href="register.php">Kayıt Ol</a></li>
        <li><a href="login.php">Oturum Aç</a></li>
        <li><a href="reservation.php">Rezervasyon Yap</a></li>
        <li><a href="reservations.php">Rezervasyonlar</a></li>
    </ul>
</nav>

    </body>
</html>
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
