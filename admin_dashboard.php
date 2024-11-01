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
// admin_dashboard.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'reservation_system');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT reservations.id, users.username, reservations.date, reservations.time, reservations.status 
                        FROM reservations JOIN users ON reservations.user_id = users.id 
                        ORDER BY reservations.date, reservations.time");

echo "<h2>Manage Reservations</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>User</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['date']}</td>
        <td>{$row['time']}</td>
        <td>{$row['status']}</td>
        <td>
            <form action='admin_dashboard.php' method='POST'>
                <input type='hidden' name='reservation_id' value='{$row['id']}'>
                <button type='submit' name='approve'>Approve</button>
                <button type='submit' name='cancel'>Cancel</button>
            </form>
        </td>
    </tr>";
}
echo "</table>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $action = isset($_POST['approve']) ? 'approved' : 'canceled';

    $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $reservation_id);

    if ($stmt->execute()) {
        echo "Reservation " . ($action == 'approved' ? "approved" : "canceled") . " successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
