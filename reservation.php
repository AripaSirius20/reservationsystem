<!-- reservation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation</title>
</head>
<body>
    <h2>Make a Reservation</h2>
    <form action="reservation.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" required><br>

        <button type="submit" name="reserve">Reserve</button>
    </form>
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
