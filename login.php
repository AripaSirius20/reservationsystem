<!-- login.php -->
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Oturum Aç</title>
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
        <h1>Oturum Aç</h1>
        <form action="login.php" method="post">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Şifre</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Oturum Aç</button>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// login.php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'reservation_system');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            echo "Login successful!";
            header("Location: dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
    $conn->close();
    session_start();
$conn = new mysqli('localhost', 'root', '', 'reservation_system');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;
        header("Location: " . ($role == 'admin' ? "admin_dashboard.php" : "reservation.php"));
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
}
$conn->close();
}
?>
