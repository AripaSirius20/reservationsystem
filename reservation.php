<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rezervasyon Yap</title>
</head>
<body>
<ul>
        <li><a href="index.php">Ana Sayfa</a></li>
        <li><a href="register.php">Kayıt Ol</a></li>
        <li><a href="login.php">Oturum Aç</a></li>
        <li><a href="reservation.php">Rezervasyon Yap</a></li>
        <li><a href="reservations.php">Rezervasyonlar</a></li>
    </ul>
    <div class="container">
        <h1>Rezervasyon Yap</h1>
        <form action="reservation.php" method="post">
            <label for="date">Tarih</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Saat</label>
            <input type="time" id="time" name="time" required>

            <button type="submit">Rezervasyon Oluştur</button>
        </form>
        <?php if (isset($successMessage)) : ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)) : ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// reservation.php
session_start();
// Oturum kontrolü
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve'])) {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $conn = new mysqli('localhost', 'root', '', 'reservation_system');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // Aynı tarih ve saate başka bir rezervasyon var mı diye kontrol ediyoruz
    $stmt = $conn->prepare("SELECT id FROM reservations WHERE date = ? AND time = ? AND status = 'approved'");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "This time slot is already booked. Please choose a different time.";
    } else {
        $stmt = $conn->prepare("INSERT INTO reservations (user_id, date, time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $date, $time);

        if ($stmt->execute()) {
            echo "Reservation created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
    $conn->close();
}
?>
