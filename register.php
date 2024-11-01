<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kayıt Ol</title>
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
        <h1>Kayıt Ol</h1>
        <form action="register.php" method="post">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-posta</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Şifre</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Kayıt Ol</button>
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
// register.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli('localhost', 'root', '', 'reservation_system');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    session_start();
$conn = new mysqli('localhost', 'root', '', 'reservation_system');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
    $conn->close();
}
?>
